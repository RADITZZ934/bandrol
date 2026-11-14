<script setup lang="ts">
import { ref } from 'vue'
import { DotLottieVue } from '@lottiefiles/dotlottie-vue'
import { FileUp, FileText } from 'lucide-vue-next'
import { useBandrolStore } from '~/stores/bandrolStore'
import { UOM_OPTIONS } from '~/utils/constants'
import SizeSelector from '~/components/Sidebar/SizeSelector.vue'
import InputText from '~/components/Sidebar/InputText.vue'
import ItemAutocomplete from '~/components/Sidebar/ItemAutocomplete.vue'

const store = useBandrolStore()
const uploadedFileName = ref<string | null>(null)
const lottieFailed = ref(false)

function handleFileUpload(event: Event) {
  const input = event.target as HTMLInputElement
  const file = input.files?.[0]
  if (!file) return
  uploadedFileName.value = file.name
  store.setFileName(file.name)
}
</script>

<template>
  <aside
    class="no-print w-64 shrink-0 bg-white border-r border-gray-200 flex flex-col justify-between overflow-y-auto z-10"
  >
    <div class="p-3 space-y-3">
      <!-- 1. Theme / Color Mode Toggle -->
      <div class="grid grid-cols-2 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.colorMode === 'grayscale'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setColorMode('grayscale')"
        >
          Grayscale
        </button>
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.colorMode === 'colour'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setColorMode('colour')"
        >
          Colour
        </button>
      </div>

      <!-- 2. Input Method Toggle -->
      <div class="grid grid-cols-2 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.inputMethod === 'manual'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setInputMethod('manual')"
        >
          Manual
        </button>
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.inputMethod === 'upload-pdf'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setInputMethod('upload-pdf')"
        >
          Upload PDF
        </button>
      </div>

      <!-- 3. Brand Identity Toggle -->
      <div class="grid grid-cols-2 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.brand === 'laskar'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setBrand('laskar')"
        >
          Laskar
        </button>
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.brand === 'bazzar'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setBrand('bazzar')"
        >
          Bazzar
        </button>
      </div>

      <!-- 4. Template Style Toggle (Terbaru vs Modern vs Klasik) -->
      <div class="grid grid-cols-3 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.templateStyle === 'latest'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setTemplateStyle('latest')"
        >
          Terbaru
        </button>
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.templateStyle === 'modern'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setTemplateStyle('modern')"
        >
          Modern
        </button>
        <button
          type="button"
          class="py-1 rounded transition"
          :class="
            store.templateStyle === 'classic'
              ? 'bg-white text-gray-900 shadow-sm'
              : 'text-gray-600 hover:text-gray-900'
          "
          @click="store.setTemplateStyle('classic')"
        >
          Klasik
        </button>
      </div>

      <div class="border-t border-gray-100 pt-2 space-y-2.5">
        <!-- Size & Model Dropdown -->
        <SizeSelector />

        <!-- Manual Inputs -->
        <template v-if="store.inputMethod === 'manual'">
          <ItemAutocomplete />

          <InputText
            label="*Harga/UOM"
            :model-value="store.activePage.price"
            placeholder="contoh: 5000"
            numeric-only
            @update:model-value="store.updateActivePage({ price: $event })"
          />

          <!-- UOM Quick Buttons -->
          <div class="space-y-1">
            <label class="block text-[11px] font-medium text-gray-700">
              *UOM
            </label>
            <div class="grid grid-cols-3 gap-1.5">
              <button
                v-for="uom in UOM_OPTIONS"
                :key="uom"
                type="button"
                class="py-1.5 rounded text-[10px] font-bold tracking-wide transition"
                :class="
                  store.activePage.uom === uom
                    ? 'bg-[#48a842] text-white shadow-sm'
                    : 'bg-gray-300/80 text-gray-700 hover:bg-gray-300'
                "
                @click="store.updateActivePage({ uom })"
              >
                {{ uom }}
              </button>
            </div>
          </div>

          <InputText
            label="*Barcode"
            :model-value="store.activePage.barcode"
            :disabled="Boolean(store.activePage.isBarcodeLocked)"
            placeholder="Opsional (Tidak Harus Diisi)"
            @update:model-value="store.updateActivePage({ barcode: $event })"
          />

          <InputText
            label="*Cabang / Lokasi"
            :model-value="store.activePage.branch"
            placeholder="contoh: Tobo 2"
            @update:model-value="store.updateActivePage({ branch: $event })"
          />
        </template>

        <!-- Upload PDF Mode -->
        <template v-else>
          <div class="rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-4 text-center space-y-2">
            <FileUp class="w-6 h-6 text-gray-400 mx-auto" />
            <p class="text-[11px] text-gray-600">
              Unggah file PDF daftar harga untuk diproses ke bandrol.
            </p>
            <label
              class="inline-block cursor-pointer rounded bg-[#48a842] hover:bg-[#3d9438] text-white text-[11px] font-semibold px-3 py-1.5 transition"
            >
              Pilih File PDF
              <input
                type="file"
                accept="application/pdf"
                class="hidden"
                @change="handleFileUpload"
              />
            </label>
            <div
              v-if="uploadedFileName"
              class="flex items-center justify-center gap-1 text-[11px] text-green-700 font-medium pt-1"
            >
              <FileText class="w-3.5 h-3.5 shrink-0" />
              <span class="truncate">{{ uploadedFileName }}</span>
            </div>
          </div>
        </template>
      </div>
    </div>

    <!-- Branding Footer -->
    <div class="p-3 pt-2 border-t border-gray-100 flex flex-col items-start gap-1">
      <div class="w-24 h-14 flex items-center justify-start overflow-hidden">
        <DotLottieVue
          v-if="!lottieFailed"
          src="/lottie/Cat playing animation.lottie"
          autoplay
          loop
          class="w-24 h-16"
          @error="lottieFailed = true"
        />
        <img
          v-else
          src="~/assets/images/maskot-bina.svg"
          alt="Maskot BINA"
          class="h-14 w-auto object-contain"
        />
      </div>

      <div class="flex items-center gap-2">
        <img
          src="~/assets/images/logo-bina.jpg"
          alt="BINA Logo"
          class="w-7 h-7 rounded object-contain shrink-0"
        />
        <div class="text-[9px] leading-tight text-gray-600 font-medium">
          <div>Properties of Bram Innovation</div>
          <div>Network &amp; Access</div>
        </div>
      </div>
    </div>
  </aside>
</template>

