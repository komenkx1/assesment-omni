<template>
    <div class="pt-8">
        <div class="header-title">
            <h3 class="font-bold text-brand-500 text-lg">Manajemen User Data</h3>
            <p>Sistem Manajemen User Data</p>
        </div>
        <hr class="mt-3">
        <div class="mt-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
            <TableComp :columns="columnsTable" :items="userData" :loading="loadingTable">
                <template #aksi="{ row }">
                    <BtnIcon icon="PencilIcon" @click="showData(row)" color="brand" class="mx-1" />
                    <BtnIcon icon="TrashIcon" @click="confirmDelete(row)" color="gray-300" class="mx-1" />
                </template>
                <template #table-action>
                    <BtnWithIcon color="green" icon="PlusIcon" @click="() => modalFormUser = true">
                        Tambah User
                    </BtnWithIcon>
                </template>
            </TableComp>
        </div>

        <ModalConfirm :modal="modalConfirm" :onYesWithButton="true" @handleOnYes="deleteUser"
            @closeModal="() => modalConfirm = false">
            <p>Apakah Anda Yakin Ingin Menghapus Data Ini?</p>
        </ModalConfirm>

        <ModalComp :showing="modalFormUser" @close="() => modalFormUser = false">
            <div class="m-3 p-3">
                <p class="font-bold text-brand-600">Form Data User</p>
                <hr class="my-3">
                <form @submit.prevent="submitData">
                    <div class="input my-2">
                        <label for="user">Name</label>
                        <input v-model="modalForm.name" required type="text" class="t-form" placeholder="Jhon Doe">
                    </div>
                    <div class="input my-2">
                        <label for="phone">Phone</label>
                        <input v-model="modalForm.telepon" required type="text" class="t-form" placeholder="0829898398">
                    </div>
                    <div class="input my-2">
                        <label for="email">Email</label>
                        <input v-model="modalForm.email" required type="email" class="t-form"
                            placeholder="JhonDoe@example.com">
                    </div>
                    <div class="input my-2">
                        <label for="password">Password</label>
                        <input v-model="modalForm.password" required type="password" class="t-form"
                            placeholder="Input Password">
                    </div>
                    <div class="input my-2">
                        <label for="password">Confirmation Password</label>
                        <input v-model="modalForm.password_confirmation" required type="password" class="t-form"
                            placeholder="Input Confirmation Password">
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-end">
                        <BtnWithIcon type="submit" color="green" icon="CheckIcon">
                            Simpan
                        </BtnWithIcon>
                    </div>
                </form>
            </div>
        </ModalComp>

    </div>
</template>

<script>
import BtnIcon from '../components/global/BtnIcon.vue';
import BtnWithIcon from '../components/global/BtnWithIcon.vue';
import ModalComp from '../components/global/ModalComp.vue';
import ModalConfirm from '../components/global/ModalConfirm.vue';
import TableComp from '../components/global/TableComp.vue';

export default {
    components: { TableComp, BtnIcon, BtnWithIcon, ModalConfirm, ModalComp },
    data() {
        return {
            loadingTable: false,
            modalConfirm: false,
            modalFormUser: false,
            modalForm: {
                id: '',
                name: '',
                email: '',
                telepon: '',
                password: '',
                password_confirmation: ''
            },
            rowData: {},
            userData: [],
            columnsTable: [
                { label: '#', field: 'id' },
                { label: 'Nama', field: 'name' },
                { label: 'Email', field: 'email' },
                { label: 'Telepon', field: 'telepon' },
                { label: 'Aksi', field: 'aksi' },
            ]
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        confirmDelete(row) {
            this.modalConfirm = true
            this.rowData = row
        },
        showData(row) {
            this.modalFormUser = true
            this.modalForm = {
                id: row.id,
                name: row.name,
                email: row.email,
                telepon: row.telepon,
                password: '',
                password_confirmation: ''
            }
        },
        submitData() {
            this.loadingTable = true
            let dispatch = ''
            let data = {}

            if (this.modalForm.id) {
                dispatch = 'updateUser'
                data = {
                    dataForm: { ...this.modalForm, _method: 'PUT' },
                    id: this.modalForm.id
                }
            } else {
                dispatch = 'addUser'
                data = {
                    dataForm: this.modalForm,
                }
            }
            this.$store.dispatch(dispatch, data)
                .then(response => {
                    this.getUsers();
                    this.resetForm()
                    this.loadingTable = false
                    this.modalFormUser = false
                })
                .catch(error => {
                    console.log(error)
                    this.loadingTable = false
                    this.modalConfirm = false
                });
        },
        deleteUser() {
            this.loadingTable = true
            this.$store.dispatch('deleteUser', this.rowData.id)
                .then(response => {
                    this.loadingTable = false
                    this.getUsers();
                    this.modalConfirm = false
                })
                .catch(error => {
                    console.log(error)
                    this.loadingTable = false
                    this.modalConfirm = false
                });
        },
        getUsers() {
            this.loadingTable = true
            this.$store.dispatch('fetchUsers')
                .then(response => {
                    this.userData = response.data.data;
                    this.loadingTable = false
                })
                .catch(error => {
                    console.log(error)
                    this.loadingTable = false
                });
        },
        resetForm() {
            this.modalForm = {
                name: '',
                email: '',
                telepon: '',
                password: '',
                password_confirmation: ''
            }
        }
    }
}
</script>