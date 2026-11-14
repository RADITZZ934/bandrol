<script setup lang="ts">
import { ref } from 'vue'
import * as XLSX from 'xlsx'
import { DotLottieVue } from '@lottiefiles/dotlottie-vue'
import { FileSpreadsheet, FileText, Lock } from 'lucide-vue-next'
import type { BandrolPageData, UomType } from '~/types'
import { useBandrolStore } from '~/stores/bandrolStore'
import { UOM_OPTIONS, formatPriceId } from '~/utils/constants'
import SizeSelector from '~/components/Sidebar/SizeSelector.vue'
import InputText from '~/components/Sidebar/InputText.vue'
import ItemAutocomplete from '~/components/Sidebar/ItemAutocomplete.vue'

const store = useBandrolStore()
const uploadedSummary = ref<string | null>(null)
const uploadError = ref<string | null>(null)
const lottieFailed = ref(false)

function normalizeUom(raw: unknown): UomType {
  const val = String(raw ?? '').trim().toUpperCase()
  if (val === 'PCS' || val === 'KG' || val === 'GRAM' || val === 'PACK') {
    return val
  }
  if (val === 'GR' || val === 'G') return 'GRAM'
  if (val === 'PC' || val === 'UNIT') return 'PCS'
  return 'KG'
}

function getField(row: Record<string, unknown>, keys: string[]): string {
  for (const key of keys) {
    if (row[key] !== undefined && row[key] !== null) {
      return String(row[key]).trim()
    }
  }
  const lowerMap = new Map(
    Object.entries(row).map(([k, v]) => [k.trim().toLowerCase(), v])
  )
  for (const key of keys) {
    const val = lowerMap.get(key.toLowerCase())
    if (val !== undefined && val !== null) {
      return String(val).trim()
    }
  }
  return ''
}

async function handleExcelUpload(event: Event) {
  const input = event.target as HTMLInputElement
  const files = input.files
  if (!files || files.length === 0) return

  uploadError.value = null
  uploadedSummary.value = null

  try {
    const imported: Array<Partial<BandrolPageData>> = []

    for (const file of Array.from(files)) {
      const buffer = await file.arrayBuffer()
      const workbook = XLSX.read(new Uint8Array(buffer), { type: 'array' })
      const sheetName = workbook.SheetNames[0]
      if (!sheetName) continue
      const sheet = workbook.Sheets[sheetName]
      const rows = XLSX.utils.sheet_to_json<Record<string, unknown>>(sheet)

      for (const row of rows) {
        const itemName = getField(row, ['Nama Produk', 'Nama Item', 'name'])
        const rawPrice = getField(row, ['Price', 'Harga', 'Harga/UOM'])
        const price = rawPrice ? String(Math.round(Number(rawPrice.replace(/[^\d.-]/g, '')) || 0)) : '0'
        const rawDiscount = getField(row, ['Discount Member', 'Potongan Harga', 'Diskon Member'])
        const memberDiscount = rawDiscount ? String(Math.round(Number(rawDiscount.replace(/[^\d.-]/g, '')) || 0)) : '0'
        const barcode = getField(row, ['Kode Produk', 'Barcode', 'Kode'])
        const uom = normalizeUom(getField(row, ['UOM', 'Satuan']))
        const branch = getField(row, ['Name Store', 'Nama Toko', 'Cabang', 'Kode Store'])

        if (itemName || barcode) {
          imported.push({
            itemName,
            price,
            memberDiscount,
            uom,
            barcode,
            branch: branch || undefined,
          })
        }
      }
    }

    if (imported.length === 0) {
      uploadError.value = 'Tidak ada data produk yang ditemukan di file Excel.'
      return
    }

    store.importPages(imported)
    const firstName = files[0].name.replace(/\.(xlsx|xls|csv)$/i, '')
    store.setFileName(`${firstName}.pdf`)
    uploadedSummary.value = `${imported.length} item dari ${files.length} file dimuat`
  } catch (err) {
    uploadError.value = 'Gagal membaca file Excel. Pastikan format .xls/.xlsx valid.'
    console.error('Excel import error:', err)
  } finally {
    input.value = ''
  }
}
</script>

<template>
  <aside
    class="no-print w-64 shrink-0 bg-white border-r border-gray-200 flex flex-col justify-between overflow-y-auto z-10"
  >
    <div class="p-3 space-y-3">
      <!-- 1. Theme / Color Mode Toggle -->
      <div class="relative grid grid-cols-2 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <div
          class="pointer-events-none absolute inset-y-0.5 left-0.5 w-[calc(50%-2px)] rounded bg-white shadow-sm transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
          :style="{ transform: store.colorMode === 'colour' ? 'translateX(100%)' : 'translateX(0%)' }"
        />
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.colorMode === 'grayscale' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setColorMode('grayscale')"
        >
          Grayscale
        </button>
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.colorMode === 'colour' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setColorMode('colour')"
        >
          Colour
        </button>
      </div>

      <!-- 2. Input Method Toggle -->
      <div class="relative grid grid-cols-2 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <div
          class="pointer-events-none absolute inset-y-0.5 left-0.5 w-[calc(50%-2px)] rounded bg-white shadow-sm transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
          :style="{ transform: store.inputMethod === 'upload-excel' ? 'translateX(100%)' : 'translateX(0%)' }"
        />
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.inputMethod === 'manual' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setInputMethod('manual')"
        >
          Manual
        </button>
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.inputMethod === 'upload-excel' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setInputMethod('upload-excel')"
        >
          Upload Excel
        </button>
      </div>

      <!-- 3. Brand Identity Toggle -->
      <div class="relative grid grid-cols-2 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <div
          class="pointer-events-none absolute inset-y-0.5 left-0.5 w-[calc(50%-2px)] rounded bg-white shadow-sm transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
          :style="{ transform: store.brand === 'bazzar' ? 'translateX(100%)' : 'translateX(0%)' }"
        />
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.brand === 'laskar' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setBrand('laskar')"
        >
          Laskar
        </button>
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.brand === 'bazzar' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setBrand('bazzar')"
        >
          Bazzar
        </button>
      </div>

      <!-- 4. Template Style Toggle (Terbaru vs Modern vs Klasik) -->
      <div class="relative grid grid-cols-3 rounded-md border border-gray-300 bg-gray-200 p-0.5 text-[11px] font-medium">
        <div
          class="pointer-events-none absolute inset-y-0.5 left-0.5 w-[calc(33.333%-1.33px)] rounded bg-white shadow-sm transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
          :style="{
            transform:
              store.templateStyle === 'latest'
                ? 'translateX(0%)'
                : store.templateStyle === 'modern'
                  ? 'translateX(100%)'
                  : 'translateX(200%)',
          }"
        />
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.templateStyle === 'latest' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setTemplateStyle('latest')"
        >
          Terbaru
        </button>
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.templateStyle === 'modern' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setTemplateStyle('modern')"
        >
          Modern
        </button>
        <button
          type="button"
          class="relative z-10 py-1 rounded transition-colors duration-200"
          :class="store.templateStyle === 'classic' ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900'"
          @click="store.setTemplateStyle('classic')"
        >
          Klasik
        </button>
      </div>

      <div class="border-t border-gray-100 pt-2 space-y-2.5">
        <!-- Size & Model Dropdown -->
        <SizeSelector />

        <!-- Manual / Upload Excel Swap -->
        <Transition name="panel-swap" mode="out-in">
          <div v-if="store.inputMethod === 'manual'" key="manual" class="space-y-2.5">
            <ItemAutocomplete />

            <InputText
              label="*Harga/UOM"
              :model-value="store.activePage.price"
              placeholder="contoh: 22000"
              numeric-only
              @update:model-value="store.updateActivePage({ price: $event })"
            />

            <!-- Potongan Harga Member (Khusus BANDROL PROMO MEMBER) -->
            <div
              v-if="store.activePreset.isMemberPromo"
              class="space-y-1 rounded-md bg-blue-50/80 border border-blue-200 p-2"
            >
              <InputText
                label="*Potongan Harga (Member)"
                :model-value="store.activePage.memberDiscount || ''"
                placeholder="contoh: 2000"
                numeric-only
                @update:model-value="store.updateActivePage({ memberDiscount: $event })"
              />
              <div class="text-[10px] font-semibold text-blue-800 flex justify-between px-0.5">
                <span>Harga Member:</span>
                <span>
                  Rp {{
                    formatPriceId(
                      String(
                        Math.max(
                          0,
                          (Number((store.activePage.price || '0').replace(/\D/g, '')) || 0) -
                            (Number((store.activePage.memberDiscount || '0').replace(/\D/g, '')) || 0)
                        )
                      )
                    )
                  }}
                </span>
              </div>
            </div>

            <!-- UOM Quick Buttons -->
            <div class="space-y-1">
              <div class="flex items-center justify-between">
                <label class="block text-[11px] font-medium text-gray-700">
                  *UOM
                </label>
                <span
                  v-if="store.activePage.isBarcodeLocked"
                  class="inline-flex items-center gap-0.5 text-[9px] font-medium text-amber-700"
                >
                  <Lock class="w-2.5 h-2.5" />
                  Terkunci
                </span>
              </div>
              <div class="grid grid-cols-3 gap-1.5">
                <button
                  v-for="uom in UOM_OPTIONS"
                  :key="uom"
                  type="button"
                  :disabled="Boolean(store.activePage.isBarcodeLocked)"
                  class="py-1.5 rounded text-[10px] font-bold tracking-wide transition-all duration-200"
                  :class="[
                    store.activePage.uom === uom
                      ? 'bg-[#48a842] text-white shadow-sm'
                      : 'bg-gray-300/80 text-gray-700 hover:bg-gray-300',
                    store.activePage.isBarcodeLocked
                      ? 'opacity-70 cursor-not-allowed'
                      : 'active:scale-95',
                  ]"
                  @click="store.updateActivePage({ uom })"
                >
                  {{ uom }}
                </button>
                <button
                  v-if="!UOM_OPTIONS.includes(store.activePage.uom)"
                  type="button"
                  disabled
                  class="py-1.5 rounded text-[10px] font-bold tracking-wide bg-[#48a842] text-white shadow-sm opacity-85 cursor-not-allowed"
                >
                  {{ store.activePage.uom }}
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
          </div>

          <div
            v-else
            key="upload-excel"
            class="rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-3.5 text-center space-y-2"
          >
            <FileSpreadsheet class="w-6 h-6 text-green-600 mx-auto" />
            <p class="text-[11px] text-gray-600 leading-snug">
              Unggah file Excel (<span class="font-mono">.xls / .xlsx</span>). Bisa pilih lebih dari satu file.
            </p>
            <p class="text-[10px] text-gray-400 leading-tight">
              Kolom: Kode Produk, Nama Produk, Price, UOM, Name Store
            </p>
            <label
              class="inline-block cursor-pointer rounded bg-[#48a842] hover:bg-[#3d9438] text-white text-[11px] font-semibold px-3 py-1.5 transition-all duration-200 active:scale-95"
            >
              Pilih File Excel
              <input
                type="file"
                accept=".xls,.xlsx,.csv"
                multiple
                class="hidden"
                @change="handleExcelUpload"
              />
            </label>
            <div
              v-if="uploadedSummary"
              class="flex items-center justify-center gap-1 text-[11px] text-green-700 font-semibold pt-1"
            >
              <FileText class="w-3.5 h-3.5 shrink-0" />
              <span>{{ uploadedSummary }}</span>
            </div>
            <p
              v-if="uploadError"
              class="text-[11px] text-red-600 font-medium pt-1"
            >
              {{ uploadError }}
            </p>
          </div>
        </Transition>
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
          src="~/assets/images/bram.png"
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

