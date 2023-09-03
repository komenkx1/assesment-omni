<template>
  <div>
    <p class="whitespace-nowrap">
      <i
        v-if="'jenis_prioritas' in dataPasien && dataPasien.jenis_prioritas"
        class="fa fa-star text-orange-500 mr-2"
      />
      <span
        v-if="'is_pasien_baru' in dataPasien && dataPasien.is_pasien_baru"
        class="whitespace-nowrap px-2 rounded-full text-xs"
        :class="!badgePasienBaruInverted ? 'bg-brand-600 text-white' : 'bg-white text-brand-600'"
      >Pasien Baru</span>
    </p>
    <span :class="classNamaPasien">{{ dataPasien?.nama_pasien }}</span>
    <p class="whitespace-nowrap mt-1">
      <template
        v-for="f in settingKondisiPasien"
        :key="f.key"
      >
        <span
          v-if="f.key in dataPasien && dataPasien[f.key]"
          class="inline-block w-4 h-4 mr-2 rounded-sm cursor-pointer"
          :class="`bg-${f.color}-500`"
          :title="f.title + ': ' + (f?.des || '-')"
          @click="$emit('showKondisiPasien', {...f, nama_pasien: dataPasien.nama_pasien })"
        />
      </template>
    </p>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  props: {
    dataPasien: {
      type: Object,
      default: () => {
        return {
          nama_pasien: '', 
          is_pasien_baru: '',
          jenis_prioritas: '',
          is_resiko_jatuh: '',
          resiko_jatuh_des: '',
          is_alergi: '',
          alergi_res: '',
          is_resusitasi: '',
          resusitasi_des: ''
        }
      }
    },
    /**
     * Data

    {
      nama_pasien: row.nama_pasien, 
      is_pasien_baru: row.is_pasien_baru,
      jenis_prioritas: row.jenis_prioritas, // join ke m_pasien_prioritas
      
      // kondisi pasien join ke t_kondisi_pasien
    }
      */
    classNamaPasien: {
      type: String,
      default: ''
    },
    badgePasienBaruInverted: {
      type: Boolean,
      default: false
    }
  },
emits: ['showKondisiPasien'],
  data () {
    return {
      
    }
  },
  computed: {
    ...mapState({
      bgResikoJatuh: s => s.setupUnit.setupUnit.bg_resiko_jatuh,
      bgAlergi: s => s.setupUnit.setupUnit.bg_alergi,
      bgResusitasi: s => s.setupUnit.setupUnit.bg_resusitasi,
    }),
    
    settingKondisiPasien () {
      return [
        { key: 'is_alergi', title: 'Alergi', color: this.bgAlergi, des: this.dataPasien.alergi_des },
        { key: 'is_resiko_jatuh', title: 'Resiko Jatuh', color: this.bgResikoJatuh, des: this.dataPasien.resiko_jatuh_des },
        { key: 'is_resusitasi', title: 'Jangan Dilakukan Resusitasi', color: this.bgResusitasi, des: this.dataPasien.resusitasi_des },
      ]
    }
  }
}
</script>