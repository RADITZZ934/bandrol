<script setup lang="ts">
import { computed } from 'vue'
import type { BandrolPageData, BandrolSizePreset, BrandType, ColorMode } from '~/types'
import { formatPriceId } from '~/utils/constants'
import QRCodeRender from '~/components/Canvas/QRCodeRender.vue'
import LinearBarcodeRender from '~/components/Canvas/LinearBarcodeRender.vue'

interface Props {
  page: BandrolPageData
  preset: BandrolSizePreset
  brand: BrandType
  colorMode: ColorMode
}

const props = defineProps<Props>()

const formattedPrice = computed(() => formatPriceId(props.page.price || '0'))

// Scale proportionally relative to the 330x210mm F4 base
const scaleFactor = computed(() =>
  Math.min(props.preset.widthMm / 330, props.preset.heightMm / 210)
)

const titleFontSize = computed(() => {
  const len = (props.page.itemName || '').length
  let baseMm = 20 * scaleFactor.value
  if (len > 30) baseMm *= 0.78
  else if (len > 23) baseMm *= 0.88
  return `${Math.max(2.6, baseMm).toFixed(2)}mm`
})

const priceFontSize = computed(() => {
  const len = formattedPrice.value.length
  let baseMm = 88 * scaleFactor.value
  if (len >= 7) baseMm *= 0.64
  else if (len >= 6) baseMm *= 0.76
  else if (len >= 5) baseMm *= 0.92

  if (!props.page.barcode?.trim()) {
    baseMm *= 1.06
  }

  return `${Math.max(6.5, baseMm).toFixed(2)}mm`
})

const qrSizePx = computed(() => {
  const basePx = 150 * scaleFactor.value
  return Math.round(Math.max(18, basePx))
})
</script>

<template>
  <div
    class="w-full h-full bg-white flex flex-col justify-between box-border select-none"
    :class="{ grayscale: colorMode === 'grayscale' }"
    :style="{ padding: `${Math.max(0.6, 2.5 * scaleFactor).toFixed(2)}mm` }"
  >
    <!-- Outer crisp border frame -->
    <div
      class="w-full h-full border-neutral-900 flex flex-col justify-between box-border bg-white relative overflow-hidden"
      :style="{
        borderWidth: `${Math.max(0.3, 0.7 * scaleFactor).toFixed(2)}mm`,
        borderStyle: 'solid',
        padding: `${Math.max(0.8, 4 * scaleFactor).toFixed(2)}mm ${Math.max(1.2, 5.5 * scaleFactor).toFixed(2)}mm`,
      }"
    >
      <!-- Optional Promo Badge -->
      <div
        v-if="preset.isPromo"
        class="absolute top-0 right-0 bg-red-600 text-white font-display font-black text-xs px-3 py-0.5 tracking-widest uppercase"
      >
        PROMO
      </div>

      <!-- Top Header: Item Name -->
      <div
        class="border-neutral-900 text-center shrink-0 flex items-center justify-center"
        :style="{
          borderBottomWidth: `${Math.max(0.3, 0.9 * scaleFactor).toFixed(2)}mm`,
          borderBottomStyle: 'solid',
          paddingBottom: `${Math.max(0.5, 2.5 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <h1
          class="font-sans font-extrabold uppercase text-neutral-900 tracking-tight leading-none truncate w-full"
          :style="{ fontSize: titleFontSize }"
        >
          {{ page.itemName?.trim() || 'NAMA ITEM' }}
        </h1>
      </div>

      <!-- Middle Section: Tall Yellow UOM Badge + Massive Price + QR Code -->
      <div
        class="flex-1 flex items-center justify-between min-h-0"
        :style="{
          gap: `${Math.max(1, 4 * scaleFactor).toFixed(2)}mm`,
          paddingTop: `${Math.max(0.5, 3 * scaleFactor).toFixed(2)}mm`,
          paddingBottom: `${Math.max(0.5, 3 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <!-- RP./UOM Box (Laskar: Yellow/Black, Bazzar: Green/White) -->
        <div
          class="flex flex-col items-center justify-center shrink-0"
          :class="brand === 'laskar' ? 'bg-[#fff200] text-neutral-900' : 'bg-[#009846] text-white'"
          :style="{
            width: `${(52 * scaleFactor).toFixed(2)}mm`,
            height: `${(88 * scaleFactor).toFixed(2)}mm`,
            borderRadius: `${Math.max(0.8, 3 * scaleFactor).toFixed(2)}mm`,
          }"
        >
          <span
            class="font-sans font-extrabold leading-none"
            :style="{ fontSize: `${Math.max(1.8, 14 * scaleFactor).toFixed(2)}mm` }"
          >
            RP.
          </span>
          <span
            class="font-sans font-extrabold leading-tight mt-0.5"
            :style="{ fontSize: `${Math.max(1.8, 14 * scaleFactor).toFixed(2)}mm` }"
          >
            /{{ page.uom }}
          </span>
        </div>

        <!-- Massive Clean Sans-Condensed Price (not cramped, minimal gap) -->
        <div class="flex-1 flex items-center justify-center min-w-0">
          <span
            class="font-display font-black leading-[0.88] whitespace-nowrap"
            :class="brand === 'laskar' ? 'text-[#ef1c24]' : 'text-[#ef2b2d]'"
            :style="{
              fontSize: priceFontSize,
              letterSpacing: '-0.01em',
            }"
          >
            {{ formattedPrice }}
          </span>
        </div>

        <!-- Barcode: Linear 1D for mini-mikro, QR Code for other sizes -->
        <template v-if="page.barcode && page.barcode.trim().length > 0">
          <LinearBarcodeRender
            v-if="preset.id === 'mini-mikro'"
            :value="page.barcode"
            :scale-factor="scaleFactor"
          />
          <QRCodeRender
            v-else
            :value="page.barcode"
            :size="qrSizePx"
          />
        </template>
      </div>

      <!-- Bottom Footer: Branch + Thick Yellow-Green-Red Ribbon + Brand Logo -->
      <div class="flex items-end justify-between shrink-0">
        <div
          class="font-display font-black uppercase text-neutral-900 tracking-tight leading-none"
          :style="{ fontSize: `${Math.max(1.8, 7 * scaleFactor).toFixed(2)}mm` }"
        >
          {{ page.branch?.trim() || 'BABAT 1' }}
        </div>

        <!-- Brand Ribbon & Logo -->
        <div
          class="flex items-center"
          :style="{ gap: `${Math.max(0.6, 3 * scaleFactor).toFixed(2)}mm` }"
        >
          <!-- Left Ribbon (Laskar: Yellow-Green-Red, Bazzar: Red-Green) -->
          <div
            class="flex flex-col"
            :style="{ width: `${Math.max(5, 92 * scaleFactor).toFixed(2)}mm` }"
          >
            <template v-if="brand === 'laskar'">
              <div
                :style="{
                  height: `${Math.max(0.45, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#fde000',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(0.45, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#22a047',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(0.45, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef3b3b',
                }"
              />
            </template>
            <template v-else>
              <div
                :style="{
                  height: `${Math.max(0.65, 4.5 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef2b2d',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(0.65, 4.5 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#009846',
                }"
              />
            </template>
          </div>

          <!-- Brand Logo -->
          <img
            v-if="brand === 'laskar'"
            src="~/assets/images/laskar-footer.png"
            alt="Laskar Buah"
            class="w-auto object-contain"
            :style="{ height: `${Math.max(2.5, 16 * scaleFactor).toFixed(2)}mm` }"
          />
          <img
            v-else
            src="~/assets/images/bazzar-footer.png"
            alt="Bazzar"
            class="w-auto object-contain"
            :style="{ height: `${Math.max(2.5, 16 * scaleFactor).toFixed(2)}mm` }"
          />

          <!-- Right trailing ribbon accent -->
          <div
            class="flex flex-col"
            :style="{ width: `${Math.max(2, 12 * scaleFactor).toFixed(2)}mm` }"
          >
            <template v-if="brand === 'laskar'">
              <div
                :style="{
                  height: `${Math.max(0.45, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#fde000',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(0.45, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#22a047',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(0.45, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef3b3b',
                }"
              />
            </template>
            <template v-else>
              <div
                :style="{
                  height: `${Math.max(0.65, 4.5 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef2b2d',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(0.65, 4.5 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#009846',
                }"
              />
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
