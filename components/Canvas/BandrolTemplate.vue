<script setup lang="ts">
import { computed } from 'vue'
import type { BandrolPageData, BandrolSizePreset, BrandType, ColorMode } from '~/types'
import { formatPriceId } from '~/utils/constants'
import QRCodeRender from '~/components/Canvas/QRCodeRender.vue'

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
  return `${Math.max(7, baseMm).toFixed(2)}mm`
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

  return `${Math.max(18, baseMm).toFixed(2)}mm`
})

const qrSizePx = computed(() => {
  const basePx = 150 * scaleFactor.value
  return Math.round(Math.max(52, basePx))
})
</script>

<template>
  <div
    class="w-full h-full bg-white flex flex-col justify-between p-[2.5mm] box-border select-none"
    :class="{ grayscale: colorMode === 'grayscale' }"
  >
    <!-- Outer crisp border frame -->
    <div
      class="w-full h-full border-[0.7mm] border-neutral-900 flex flex-col justify-between px-[5.5mm] py-[4mm] box-border bg-white relative overflow-hidden"
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
        class="border-b-[0.9mm] border-neutral-900 text-center shrink-0 flex items-center justify-center"
        :style="{ paddingBottom: `${(2.5 * scaleFactor).toFixed(2)}mm` }"
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
          gap: `${(4 * scaleFactor).toFixed(2)}mm`,
          paddingTop: `${(3 * scaleFactor).toFixed(2)}mm`,
          paddingBottom: `${(3 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <!-- RP./UOM Box (Laskar: Yellow/Black, Bazzar: Green/White) -->
        <div
          class="flex flex-col items-center justify-center shrink-0"
          :class="brand === 'laskar' ? 'bg-[#fff200] text-neutral-900' : 'bg-[#009846] text-white'"
          :style="{
            width: `${(52 * scaleFactor).toFixed(2)}mm`,
            height: `${(95 * scaleFactor).toFixed(2)}mm`,
            borderRadius: `${(3 * scaleFactor).toFixed(2)}mm`,
          }"
        >
          <span
            class="font-sans font-extrabold leading-none"
            :style="{ fontSize: `${Math.max(5, 14 * scaleFactor).toFixed(2)}mm` }"
          >
            RP.
          </span>
          <span
            class="font-sans font-extrabold leading-tight mt-1"
            :style="{ fontSize: `${Math.max(5, 14 * scaleFactor).toFixed(2)}mm` }"
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

        <!-- QR Code (Only rendered when barcode is non-empty) -->
        <QRCodeRender
          v-if="page.barcode && page.barcode.trim().length > 0"
          :value="page.barcode"
          :size="qrSizePx"
        />
      </div>

      <!-- Bottom Footer: Branch + Thick Yellow-Green-Red Ribbon + Brand Logo -->
      <div class="flex items-end justify-between shrink-0">
        <div
          class="font-display font-black uppercase text-neutral-900 tracking-tight leading-none"
          :style="{ fontSize: `${Math.max(4.5, 7 * scaleFactor).toFixed(2)}mm` }"
        >
          {{ page.branch?.trim() || 'BABAT 1' }}
        </div>

        <!-- Brand Ribbon & Logo -->
        <div
          class="flex items-center"
          :style="{ gap: `${(3 * scaleFactor).toFixed(2)}mm` }"
        >
          <!-- Left Ribbon (Laskar: Yellow-Green-Red, Bazzar: Red-Green) -->
          <div
            class="flex flex-col"
            :style="{ width: `${Math.max(18, 92 * scaleFactor).toFixed(2)}mm` }"
          >
            <template v-if="brand === 'laskar'">
              <div
                :style="{
                  height: `${Math.max(1, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#fde000',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(1, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#22a047',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(1, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef3b3b',
                }"
              />
            </template>
            <template v-else>
              <div
                :style="{
                  height: `${Math.max(1.5, 4.5 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef2b2d',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(1.5, 4.5 * scaleFactor).toFixed(2)}mm`,
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
            :style="{ height: `${Math.max(6, 16 * scaleFactor).toFixed(2)}mm` }"
          />
          <img
            v-else
            src="~/assets/images/bazzar-footer.png"
            alt="Bazzar"
            class="w-auto object-contain"
            :style="{ height: `${Math.max(6, 16 * scaleFactor).toFixed(2)}mm` }"
          />

          <!-- Right trailing ribbon accent -->
          <div
            class="flex flex-col"
            :style="{ width: `${Math.max(4, 12 * scaleFactor).toFixed(2)}mm` }"
          >
            <template v-if="brand === 'laskar'">
              <div
                :style="{
                  height: `${Math.max(1, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#fde000',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(1, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#22a047',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(1, 3 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef3b3b',
                }"
              />
            </template>
            <template v-else>
              <div
                :style="{
                  height: `${Math.max(1.5, 4.5 * scaleFactor).toFixed(2)}mm`,
                  backgroundColor: '#ef2b2d',
                }"
              />
              <div
                :style="{
                  height: `${Math.max(1.5, 4.5 * scaleFactor).toFixed(2)}mm`,
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
