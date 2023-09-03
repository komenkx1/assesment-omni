<template>
    <div class="pt-8">
        <div class="header-title">
            <h3 class="font-bold text-brand-500 text-lg">List Data Log</h3>
            <p>Sistem Manajemen User Data</p>
        </div>
        <hr class="mt-3">
        <div class="mt-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
            <TableComp :columns="columnsTable" :items="logData" :loading="loadingTable">
                <template #table-action>
                    <BtnIcon icon="ArrowPathIcon" @click="getLog" color="gray" class="mx-1" />
                </template>
                <template #event="{row}">
                    <span v-if="row.event == 'CREATE'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded px-3 bg-green-500 text-white">
                        {{ row.event }}
                    </span>
                    <span v-if="row.event == 'UPDATE'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded px-3 bg-yellow-500 text-white">
                        {{ row.event }}
                    </span>
                    <span v-if="row.event == 'DELETE'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded px-3 bg-red-500 text-white">
                        {{ row.event }}
                    </span>
                    <span v-if="row.event == 'READ'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded px-3 bg-gray-500 text-white">
                        {{ row.event }}
                    </span>

                </template>
            </TableComp>
            
        </div>

    </div>
</template>

<script>
import { useToast } from 'vue-toastification';
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
            logData: [],
            errors: [],
            columnsTable: [
                { label: '#', field: 'id' },
                { label: 'Event', field: 'event' },
                { label: 'Subject', field: 'subject_id' },
                { label: 'Model', field: 'causer_type' },
                { label: 'Causer', field: 'causer' },
                { label: 'aksi', field: 'description' },
            ]
        }
    },
    mounted() {
        this.getLog();
    },
    methods: {
        getLog() {
            this.loadingTable = true
            this.$store.dispatch('fetchLog')
                .then(response => {
                    this.logData = response.data.data;
                    this.loadingTable = false
                })
                .catch(error => {
                    console.log(error)
                    this.loadingTable = false
                });
        },
      
    }
}
</script>