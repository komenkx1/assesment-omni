<template>
    <div id="container">
        <div id="streamControl">
            <video ref="videoElement" style="width: 100%; max-height: 300px;" playsinline autoplay hidden></video>
        </div>
        <div class="p-3">
            <div id="controls p-3">
                <div class="grid lg:grid-cols-4 md:grid-cols-4 grid-cols-1 gap-3 ">
                    <div class="select">
                        <select ref="selectSource" class="t-form"></select>
                    </div>
                    <btn-with-icon color="green" icon="EyeIcon" @click="toggleCamera">{{ cameraButtonLabel
                    }}</btn-with-icon>
                    <btn-with-icon color="red" icon="CameraIcon" @click="captureImage" :disabled="!cameraActive">Capture
                        Image</btn-with-icon>
                    <btn-with-icon color="brand" icon="CameraIcon" @click="toggleRecord" :disabled="!cameraActive">{{
                        recordButtonLabel }}</btn-with-icon>
                    <!-- <btn-with-icon color="gray" icon="CameraIcon" @click="openServerFiles">Open Files on
                        Server</btn-with-icon> -->
                </div>
            </div>
        </div>
        <div id="captureImage" v-if="capturedItems.length > 0"
            class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-3 m-3">
            <div v-for="(item, index) in capturedItems" :key="index" class="image-container">
                <div v-if="item.type == 'image'">
                    <img ref="image" :src="item.url" alt="Gambar" @load="onImageLoad(index)"
                        @click="addPoint($event, index)" class="w-full" />
                    <div class="w-full">
                        <btn-with-icon color="red" icon="TrashIcon" class="w-full rounded-none" @click="deleteItem(index)">
                            Hapus
                        </btn-with-icon>
                    </div>
                    <div class="" v-for="(polygon, polygonIndex) in item.polygon" :key="polygonIndex">
                        <svg class="shape" :width="imageWidth" :height="imageHeight">
                            <polygon
                                :points="calculateClosestPoints(polygon.points).map(point => point.x + ',' + point.y).join(' ')"
                                :fill="polygon.fillTransparent" :stroke="polygon.color" stroke-width="2" />
                            <circle v-for="(point, pointIndex) in polygon.points" :key="pointIndex" :cx="point.x"
                                :cy="point.y" r="5" :fill="polygon.color" />
                        </svg>
                        <div class="input-keterangan my-3">
                            <div class="grid lg:grid-cols-6 gap-3">
                                <div class="order-1 lg:order-3 flex gap-3 w-full justify-center">
                                    <btn-icon color="red" icon="TrashIcon" @click="deletePolygon(index, polygonIndex)" />
                                    <btn-icon color="green" icon="CheckIcon" v-if="polygon.isActive == true"
                                        @click="unselectPolygon(polygon)" />
                                    <btn-icon color="brand" icon="PencilSquareIcon" @click="editPoligon(polygon, index)"
                                        v-else />
                                </div>
                                <input type="text"  v-model="polygon.keterangan" class="t-form lg:col-span-4 order-2"
                                    placeholder="Masukan Keterangan">
                                <div class="order-3 lg:order-1 flex gap-2">
                                    <div :style="{ background: polygon.color }" class="color-polygin h-10 w-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <btn-with-icon v-if="item.polygon?.length > 0" :color="'green'" class="w-full  my-3"
                            :icon="'PlusIcon'" @click="addPolygon($event, index)">
                            Tambah Penandaan
                        </btn-with-icon>
                    </div>
                </div>
                <div class="" v-else>
                    <video class="col-span-2" ref="image" alt="video" controls type="video/mp4">
                        <source :src="item.url" type="video/mp4">
                    </video>
                    <div class="w-full">
                        <btn-with-icon color="red" icon="TrashIcon" class="w-full rounded-none" @click="deleteItem(index)">
                            Hapus
                        </btn-with-icon>
                    </div>
                </div>
            </div>
        </div>

        <canvas ref="canvasElement" class="w-full h-auto" hidden></canvas>

    </div>
</template>
  
<script>
import BtnIcon from './BtnIcon.vue';
import BtnWithIcon from './BtnWithIcon.vue';
export default {
    components: {
        BtnWithIcon,
        BtnIcon,
    },
    data() {
        return {
            activePoligonIndex: null,
            points: [],
            imageLoaded: false,
            imageWidth: 0,
            imageHeight: 0,
            cameraActive: false,
            cameraButtonLabel: "Open Camera",
            recordButtonLabel: "Record Video",
            capturedItems: [],
            capturedItemsMerge: [],
            videoRecorder: null,
            imageElement: null,
            stream: null,
        };
    },
    props: {
        detailPemeriksaan: {
            type: Array,
            default: () => {
                return []
            }
        }
    },
    methods: {
        calculateClosestPoints(points) {
            if (points.length < 3) {
                return points; // Return as is if less than 3 points
            }

            const closestPoints = [];
            const remainingPoints = [...points];

            let currentPoint = remainingPoints.shift();
            closestPoints.push(currentPoint);

            while (remainingPoints.length > 0) {
                let minDistance = Number.MAX_SAFE_INTEGER;
                let closestIndex = -1;

                remainingPoints.forEach((point, index) => {
                    const distance = Math.sqrt(
                        Math.pow(point.x - currentPoint.x, 2) + Math.pow(point.y - currentPoint.y, 2)
                    );

                    if (distance < minDistance) {
                        minDistance = distance;
                        closestIndex = index;
                    }
                });

                if (closestIndex !== -1) {
                    currentPoint = remainingPoints.splice(closestIndex, 1)[0];
                    closestPoints.push(currentPoint);
                }
            }
            return closestPoints;
        },
        resetIsActivePolygon(indeximage) {
            this.capturedItems[indeximage].polygon.forEach(element => {
                element.isActive = false;
            });
        },
        editPoligon(row, indexImage) {
            this.resetIsActivePolygon(indexImage);
            row.isActive = true
        },
        addPolygon(event, index) {

            const randomColor = "#" + Math.floor(Math.random() * 16777215).toString(16);
            const fillTransparent = randomColor + "33";

            const image = this.imageElement[index];
            const rect = image.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            if (this.capturedItems[index].polygon.length < 1) {
                this.capturedItems[index].polygon.push(
                    {
                        color: randomColor,
                        fillTransparent: fillTransparent,
                        keterangan: '',
                        points: [
                            { x, y }
                        ]
                    }
                );
            } else {
                this.capturedItems[index].polygon.push(
                    {
                        points: [],
                        keterangan: '',
                        color: randomColor,
                        fillTransparent: fillTransparent,
                    }
                );
                this.resetIsActivePolygon(index);
            }
            const lastIndex = this.capturedItems[index].polygon.length - 1;
            this.capturedItems[index].polygon[lastIndex].isActive = true
        },
        unselectPolygon(row) {
            row.isActive = false;
        },
        deletePolygon(index, polygonIndex) {
            this.capturedItems[index].polygon.splice(polygonIndex, 1);
        },
        addPoint(event, index) {
            let isRemove = false;
            const image = this.imageElement[index];
            const rect = image.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            if (this.capturedItems[index].polygon.length < 1) {
                this.addPolygon(event, index);
            } else {
                const activePolygon = this.capturedItems[index].polygon.find(polygon => polygon.isActive == true);
                if (activePolygon) {
                    activePolygon.points.forEach((point, pointIndex) => {
                        if (point.x >= x - 5 && point.x <= x + 5 && point.y >= y - 5 && point.y <= y + 5) {
                            isRemove = true;
                            this.removePoint(index, this.capturedItems[index].polygon.indexOf(activePolygon), pointIndex);
                            return;
                        }
                    });

                    if (!isRemove) {
                        activePolygon.points.push({ x, y });
                    }
                }
            }
        },
        removePoint(itemIndex, polygonIndex, pointIndex) {
            this.capturedItems[itemIndex].polygon[polygonIndex].points.splice(pointIndex, 1);
        },
        async getVideoDimensions() {
            if (this.stream) {
                const track = this.stream.getVideoTracks()[0];
                if (track) {
                    const settings = track.getSettings();
                    return { width: settings.width, height: settings.height };
                }
            }
            return { width: 0, height: 0 };
        },
        onImageLoad(index) {
            this.imageElement = this.$refs.image;
            if (this.imageElement.length > 0) {
                this.imageWidth = this.imageElement[index].width;
                this.imageHeight = this.imageElement[index].height;
            }
            this.imageLoaded = true;
        },
        async toggleCamera() {
            if (this.cameraActive) {
                await this.closeCamera();
            } else {
                await this.openCamera();
            }
        },
        async openCamera() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        deviceId: this.$refs.selectSource.value,
                    },
                });

                this.$refs.videoElement.srcObject = this.stream;
                this.$refs.videoElement.muted = true;
                this.$refs.videoElement.hidden = false;
                this.$refs.selectSource.disabled = true;
                this.cameraActive = true;
                this.cameraButtonLabel = "Close Camera";
            } catch (error) {
                console.error("Error opening camera:", error);
            }
        },
        deleteItem(index) {
            this.capturedItems.splice(index, 1);
        },
        async closeCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach((track) => track.stop());
                this.stream = null;
                this.$refs.videoElement.hidden = true;
                this.$refs.selectSource.disabled = false;
                this.cameraActive = false;
                this.cameraButtonLabel = "Open Camera";
            }
        },
        async captureImage() {
            const { width, height } = await this.getVideoDimensions();
            this.$refs.canvasElement.width = width;
            this.$refs.canvasElement.height = height;

            const context = this.$refs.canvasElement.getContext("2d");
            context.drawImage(
                this.$refs.videoElement,
                0,
                0,
                this.$refs.canvasElement.width,
                this.$refs.canvasElement.height
            );
            const imgUrl = this.$refs.canvasElement.toDataURL("image/jpeg");

            const uniqueId = Math.random().toString(36).substr(2, 9);
            const newItem = { id: uniqueId, url: imgUrl, polygon: [], type: 'image' };
            this.capturedItems.push(newItem);
        },
        toggleRecord() {
            if (!this.videoRecorder) {
                this.startRecording();
            } else {
                this.stopRecording();
            }
        },
        startRecording() {
            const blobContainer = [];
            this.videoRecorder = new MediaRecorder(this.stream);
            this.videoRecorder.start();
            this.recordButtonLabel = "Stop Record Video";

            this.videoRecorder.ondataavailable = (e) => {
                blobContainer.push(e.data);
            };

            this.videoRecorder.onerror = (e) => {
                console.error(e.error);
            };

            this.videoRecorder.onstop = () => {
                this.videoRecorder = null;
                this.recordButtonLabel = "Record Video";
                const newVideoElement = document.createElement("video");
                const vidBlod = new Blob(blobContainer);
                const recorderUrl = URL.createObjectURL(vidBlod);
                newVideoElement.width = 250;
                newVideoElement.autoplay = false;
                newVideoElement.controls = true;
                newVideoElement.innerHTML = `<source src="${recorderUrl}" type="video/mp4">`;

                // Save to server logic here
                const newItem = { url: recorderUrl, blobVid: vidBlod, type: 'video' };
                this.capturedItems.push(newItem);
            };
        },
        stopRecording() {
            if (this.videoRecorder) {
                this.videoRecorder.stop();
            }
        },
        async initCamera() {
            try {
                //cek apakah sudah ada permission camera atau belum
                const permission = await navigator.permissions.query({ name: "camera" });
                //jika belum, minta permission
                if (permission.state === "prompt") {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    stream.getTracks().forEach(track => track.stop());
                }
                const devices = await navigator.mediaDevices.enumerateDevices();
                for (const device of devices) {
                    if (device.kind === "videoinput") {
                        const option = document.createElement("option");
                        option.value = device.deviceId;
                        option.text = device.label;
                        this.$refs.selectSource?.appendChild(option);
                    }
                }
            } catch (error) {
                console.error("Error enumerating devices:", error);
            }
        },
        resetForm() {
            this.capturedItems = [];
            this.capturedItemsMerge = [];
            this.closeCamera();

        },
        exportMergedImage() {
            this.capturedItemsMerge = [];
            this.capturedItems.forEach((item, index) => {
                let fileUrl = '';
                if (item.type == 'image') {
                    const isExist = this.capturedItemsMerge.some(element => element.id == item.id);
                    if (!isExist) {

                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        canvas.width = this.imageWidth;
                        canvas.height = this.imageHeight;

                        ctx.drawImage(this.$refs.image[index], 0, 0, this.imageWidth, this.imageHeight);

                        // Draw SVG polygons
                        item.polygon?.forEach(polygon => {
                            ctx.beginPath();
                            ctx.moveTo(polygon.points[0].x, polygon.points[0].y);
                            polygon.points.forEach(point => {
                                ctx.lineTo(point.x, point.y);
                            });
                            ctx.closePath();
                            ctx.fillStyle = polygon.fillTransparent;
                            ctx.fill();
                            ctx.strokeStyle = polygon.color;
                            ctx.stroke();
                        });

                        // Draw SVG circles
                        item.polygon?.forEach(polygon => {
                            polygon.points.forEach(point => {
                                ctx.beginPath();
                                ctx.arc(point.x, point.y, 5, 0, Math.PI * 2);
                                ctx.fillStyle = polygon.color;
                                ctx.fill();
                            });
                        });
                        fileUrl = canvas.toDataURL("image/jpeg");
                    }
                } else {
                    fileUrl = item.url;
                }
                const newItem = { id: item.id, url: fileUrl, file_url_original: item.url, polygon: item.polygon, type: item.type == 'image' ? 'image' : 'video' };
                this.capturedItemsMerge.push(newItem);

            });

        },
        exportblobVideoTomp4() {

        }
    },
    watch: {
        capturedItemsMerge: {
            handler: function (val, oldVal) {
                this.$emit('capturedItems', this.capturedItemsMerge);
            },
            deep: true
        }
    },
    computed: {
        urlBerkas() {
            return this.$store.state.setupUnit.setupUnit.url_berkas
        }
    },
    mounted() {
        if (this.detailPemeriksaan.length > 0) {
            this.detailPemeriksaan.forEach((item, index) => {
                const newItem = { id: item.id, url: `${item.url_file_original_base64 ?? item.url_file_original}`, polygon: item.polygon, type: item.type };
                this.capturedItems.push(newItem);
            });
        }
        this.initCamera()
    },
};
</script>
  
<style>
.image-container {
    position: relative;
}

.shape {
    position: absolute;
    top: 0;
    left: 0;
    pointer-events: none;
}
</style>
  