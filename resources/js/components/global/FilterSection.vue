<template>
    <div>
        <!-- filter section (jika ada slot) -->
        <Disclosure v-slot="{ open }">
            <DisclosureButton
                class="flex my-2 w-full justify-between rounded-lg bg-brand-500 p-4 text-left text-sm font-medium text-purple-900 hover:bg-brand-400 focus:outline-none focus-visible:ring focus-visible:ring-purple-500 focus-visible:ring-opacity-75">
                <h4 class="text-white dark:text-gray-300">
                    Filter Data
                </h4>
                <ChevronUpIcon :class="!open ? 'rotate-180 transform' : ''" class="h-5 w-5 bg-white rounded-lg" />
            </DisclosureButton>
            <transition enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-out" leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0">
                <DisclosurePanel
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
                    <form ref="filterForm" @submit="handleFilter">
                        <div class="grid gap-6 mt-2 mb-4 md:grid-cols-4">
                            <!-- <div>
                                <label for="status_transaksi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                                    Transaksi</label>
                                <select class="t-form" v-model="formFilter.status_transaksi">
                                    <option value="" disabled hidden>Pilih Status Transaksi</option>
                                    <option :value="statusTransaksi.kode"
                                        v-for="(statusTransaksi, i) in dataStatusTransaksi" :key="i">{{
                                            statusTransaksi.nama }}</option>
                                </select>
                            </div> -->
                            <div>
                                <label for="status_transaksi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Alat</label>
                                <v-select id="alat" placeholder="Pilih Jenis Alat" v-model="formFilter.alat_canggih"
                                    label="nama_alat" :options=alatCanggih />
                            </div>
                            <div>
                                <label for="tgl_booking"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                    Booking</label>
                                <DatePicker :shortcuts="[
                                    { text: 'Today', onClick: () => new Date() }
                                ]" v-model:value="formFilter.tgl_booking" value-type="YYYY-MM-DD " type="date"
                                    format="D MMM YYYY" class="!w-full" input-class="rounded-none !rounded-r-lg t-form"
                                    placeholder="Masukan Tanggal Booking" confirm required />
                            </div>
                            <div>
                                <label for="tgl_periksa"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                    Pemeriksaan</label>
                                <DatePicker :shortcuts="[
                                    { text: 'Today', onClick: () => new Date() }
                                ]" v-model:value="formFilter.tgl_pemeriksaan" value-type="YYYY-MM-DD " type="date"
                                    format="D MMM YYYY" class="!w-full" input-class="rounded-none !rounded-r-lg t-form"
                                    placeholder="Masukan Tanggal Pemeriksaan" confirm required />
                            </div>
                            <div>
                                <label for="status_proses"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                                    Proses</label>
                                <v-select id="status_proses" placeholder="Pilih Status Proses"
                                    v-model="formFilter.status_tahapan" label="nama_proses" :options=statusProsesData
                                    :clearable="false" />
                            </div>

                            <div>
                                <label for="subunit"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subunit</label>
                                <v-select id="subunit" placeholder="Pilih Sub unit" v-model="formFilter.subunit"
                                    :options=dataSubunit label="nama_subunit" :clearable="false" />
                            </div>
                            <div>
                                <label for="dokter_perujuk"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dokter
                                    Perujuk</label>
                                <v-select placeholder="Pilih Dokter Perujuk" id="dokter_perujuk"
                                    v-model="formFilter.nama_dokter_perujuk" :options=DataDokterPerujuk label="nama_dokter"
                                    :clearable="false" />
                            </div>

                        </div>

                        <div>
                            <div class="grid gap-2 mt-2 mb-4 md:grid-cols-8">
                                <btn-with-icon type="button" title="Filter" color="brand" icon="CheckIcon"
                                    @click="handleFilter">
                                    Filter
                                </btn-with-icon>
                                <btn-with-icon type="button" class="bg-gray-50 border border-gray-300 text-sm rounded-lg"
                                    title="Batal" @handleClick="resetFilter" color="gray" icon="XMarkIcon">
                                    Reset
                                </btn-with-icon>
                            </div>
                            <!-- <BtnIcon v-if="hakAkses.includes('hapus')" type="button" title="Edit" color="red" icon="TrashIcon"
                      icon-size="sm" add-class="ml-2" @handleClick="hapus(row)" /> -->
                        </div>
                    </form>
                </DisclosurePanel>
            </transition>
        </Disclosure>
    </div>
</template>
  
<script>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronDownIcon, ChevronUpIcon, DocumentIcon, InformationCircleIcon, PhoneIcon } from '@heroicons/vue/20/solid'
import BtnWithIcon from '../../components/global/BtnWithIcon.vue';
export default {
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        ChevronDownIcon,
        DocumentIcon,
        InformationCircleIcon,
        PhoneIcon,
        ChevronUpIcon,
        BtnWithIcon

    },
    props: {
        DataDokterPerujuk: Array,
        dataSubunit: Array,
    },
    data() {
        return {
            dataStatusTransaksi: [],
            alatCanggih: [],
            statusProsesData: [],
            formFilter: {
                alat_canggih: '',
                status_transaksi: '',
                tgl_booking: null,
                tgl_pemeriksaan: null,
                status_tahapan: null,
                subunit: null,
                nama_dokter_perujuk: null,
            },
        };
    },
    mounted() {
        this.loadDataStatusProses()
        this.loadDataAlatCanggih()
    },
    methods: {
        // async loadDataSubUnitAll() {
        //     this.isLoading = true;
        //     await this.$store.dispatch('fetchSubunit').then((res) => {
        //         if (res.data.status) {
        //             this.subUnitData = res.data.data
        //             this.isLoading = false;
        //         } else {
        //             this.toast.error(res.data.message)
        //             this.isLoading = false;
        //         }
        //     })
        //         .catch(() => {
        //             alert('error')
        //         })
        // },
        async loadStatusTransaksi() {
            const filter = {
                group_id: 334
            }
            this.isLoading = true;
            this.$store.dispatch('fetchRef', filter).then((res) => {
                this.dataStatusTransaksi = res.data.data
                this.isLoading = false;
            }).catch((err) => {
                this.isLoading = false;
                console.log(err)
            })
        },
        async loadDataStatusProses() {
            this.isLoading = true;

            await this.$store.dispatch('fetchStatusProses', this.filter).then((res) => {
                if (res.data.status) {
                    this.statusProsesData = res.data.data
                    //filter hanya status proses dengan id 1,2,5,6
                    this.statusProsesData = this.statusProsesData.filter((item) => {
                        return item.id == 1 || item.id == 2 || item.id == 5 || item.id == 6
                    })
                    this.isLoading = false;
                } else {
                    this.toast.error(res.data.message)
                    this.isLoading = false;
                }
            })
                .catch(() => {
                    alert('error')
                })
        },
        async loadDataAlatCanggih() {
            this.isLoading = true;

            await this.$store.dispatch('fetchAlatCanggih').then(res => {
                this.alatCanggih = res.data.data
            }).catch(err => {
                console.log(err)
            })

        },
        handleFilter() {
            this.formFilter = {
                status_transaksi: this.formFilter.status_transaksi,
                tgl_booking: this.formFilter.tgl_booking,
                alat_canggih: this.formFilter.alat_canggih?.id,
                tgl_pemeriksaan: this.formFilter.tgl_pemeriksaan,
                nama_dokter_perujuk: this.formFilter.nama_dokter_perujuk,
                status_tahapan_kode: this.formFilter.status_tahapan?.kode,
                setup_unit: this.formFilter.setup_unit,
                subunit_id: this.formFilter.subunit?.id,
            }
            //emit to parent
            this.$emit('loadDataBooking', this.formFilter)
        },
        resetFilter() {
            this.formFilter = {
                status_transaksi: null,
                tgl_booking: null,
                tgl_pemeriksaan: null,
                status_tahapan: null,
                subunit: null,
                nama_dokter_perujuk: null,
                alat_canggih: null
            }
            //emit to parent
            this.$emit('loadDataBooking', this.formFilter)
        },
    },
};
</script>
  