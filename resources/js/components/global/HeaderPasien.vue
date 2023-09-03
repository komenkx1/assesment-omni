<template>
    <div
      class="
        relative
        pt-4
        px-4
        pb-4
        bg-brand-600
        dark:bg-brand-700
      text-white
        rounded-lg
        sm:grid sm:grid-cols-2 sm:gap-4
      "
    >
      <div class="sm:col-span-2 flex">
        <div class="flex-1">
          <!-- <span
            class="
              inline-block
              mb-1 mr-1
              bg-green-600
              text-green-100
              px-4
              py-1
              text-xs
              rounded-full
            "
          >
            
          </span> -->
          
          <span
            class="
              inline-block
              mb-1 mr-1
              bg-white
              text-brand-600
              px-4
              py-1
              text-xs
              rounded-full
            "
          >
            Waktu Pendaftaran: <span class="font-bold">{{ new Date(pasien.waktu_daftar).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'long' }) }}</span>
          </span>
        </div>
      </div>
      <div>
        <h4
          class="
            text-2xl
            font-bold
          "
        >
          {{ pasien.nama }}
        </h4>
        <p class="mt-2">
          {{ pasien.tempat_lahir }},
          {{ new Date(pasien.tanggal_lahir).toLocaleString('id-ID', { dateStyle: 'long' }) }}
          
          <span class="px-2">•</span>
          <span class="font-bold">{{ $helpers.getAge(pasien.tanggal_lahir) }}</span>
        </p>
        <p class="mt-2">
          <span class="font-medium">
            {{ pasien.jenis_kelamin }}
          </span>
        </p>
      </div>
  
      <div>
        <p class="text-right">
          <span class="pr-2">Nomor Rekam Medis</span>
          <span
            class="font-bold block text-xl"
          >
            {{ pasien.no_rm }}
          </span>
        </p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      pasien: {
        type: Object,
        default: () => {}
      }
    }
  }
  </script>