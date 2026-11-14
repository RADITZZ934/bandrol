<script setup lang="ts">
import { computed } from 'vue'
import type { BandrolPageData, BandrolSizePreset, BrandType, ColorMode } from '~/types'
import { formatPriceId } from '~/utils/constants'

interface Props {
  page: BandrolPageData
  preset: BandrolSizePreset
  brand: BrandType
  colorMode: ColorMode
}

const props = defineProps<Props>()

const normalNumeric = computed(() => {
  const digits = (props.page.price || '0').replace(/\D/g, '')
  return Number(digits) || 0
})

const discountNumeric = computed(() => {
  const digits = (props.page.memberDiscount || '0').replace(/\D/g, '')
  return Number(digits) || 0
})

const memberNumeric = computed(() =>
  Math.max(0, normalNumeric.value - discountNumeric.value)
)

const formattedNormalPrice = computed(() =>
  formatPriceId(String(normalNumeric.value))
)
const formattedDiscount = computed(() =>
  formatPriceId(String(discountNumeric.value))
)
const formattedMemberPrice = computed(() =>
  formatPriceId(String(memberNumeric.value))
)

const scaleFactor = computed(() =>
  Math.min(props.preset.widthMm / 330, props.preset.heightMm / 210)
)

const titleFontSize = computed(() => {
  const len = (props.page.itemName || '').length
  let baseMm = 19 * scaleFactor.value
  if (len > 30) baseMm *= 0.78
  else if (len > 22) baseMm *= 0.88
  return `${Math.max(7, baseMm).toFixed(2)}mm`
})

const normalPriceFontSize = computed(() => {
  const len = formattedNormalPrice.value.length
  let baseMm = 68 * scaleFactor.value
  if (len >= 7) baseMm *= 0.72
  else if (len >= 6) baseMm *= 0.85
  return `${Math.max(16, baseMm).toFixed(2)}mm`
})

const memberPriceFontSize = computed(() => {
  const len = formattedMemberPrice.value.length
  let baseMm = 34 * scaleFactor.value
  if (len >= 7) baseMm *= 0.72
  else if (len >= 6) baseMm *= 0.86
  return `${Math.max(10, baseMm).toFixed(2)}mm`
})
</script>

<template>
  <div
    class="w-full h-full bg-white p-[2.5mm] box-border select-none"
    :class="{ grayscale: colorMode === 'grayscale' }"
  >
    <!-- Crisp Outer Black Frame -->
    <div
      class="w-full h-full border-[0.9mm] border-black bg-white flex flex-col justify-between px-[5mm] py-[3.5mm] box-border relative overflow-hidden"
    >
      <!-- Top Header: Item Name + Solid Blue Divider -->
      <div class="shrink-0">
        <h1
          class="font-sans font-extrabold uppercase text-black text-center tracking-tight leading-none truncate w-full pb-[2.5mm]"
          :style="{ fontSize: titleFontSize }"
        >
          {{ page.itemName?.trim() || 'NAMA ITEM' }}
        </h1>
        <div
          class="w-full bg-[#0c4da2]"
          :style="{ height: `${Math.max(1.2, 2.4 * scaleFactor).toFixed(2)}mm` }"
        />
      </div>

      <!-- Middle Section: Yellow RP./UOM Box + Huge Blue Normal Price -->
      <div
        class="flex-1 flex items-center justify-between min-h-0"
        :style="{
          padding: `${(2 * scaleFactor).toFixed(2)}mm ${(4 * scaleFactor).toFixed(2)}mm`,
          gap: `${(6 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <!-- Yellow RP./UOM Box -->
        <div
          class="bg-[#fff200] flex flex-col items-center justify-center shrink-0"
          :style="{
            width: `${(40 * scaleFactor).toFixed(2)}mm`,
            height: `${(46 * scaleFactor).toFixed(2)}mm`,
            borderRadius: `${(3.5 * scaleFactor).toFixed(2)}mm`,
          }"
        >
          <span
            class="font-sans font-extrabold text-black leading-none"
            :style="{ fontSize: `${Math.max(5, 13 * scaleFactor).toFixed(2)}mm` }"
          >
            RP.
          </span>
          <span
            class="font-sans font-extrabold text-black leading-tight mt-0.5"
            :style="{ fontSize: `${Math.max(5, 13 * scaleFactor).toFixed(2)}mm` }"
          >
            /{{ page.uom }}
          </span>
        </div>

        <!-- Huge Blue Normal Price -->
        <div class="flex-1 flex items-center justify-center min-w-0">
          <span
            class="font-display font-black text-[#0c4da2] leading-[0.88] whitespace-nowrap"
            :style="{ fontSize: normalPriceFontSize }"
          >
            {{ formattedNormalPrice }}
          </span>
        </div>
      </div>

      <!-- Member Promo Bar (Blue | Yellow Member Price | Blue) -->
      <div
        class="w-full flex items-stretch shrink-0 overflow-hidden"
        :style="{ height: `${(50 * scaleFactor).toFixed(2)}mm` }"
      >
        <!-- Left Blue Block: MEMBER + DISC RP. -->
        <div
          class="bg-[#0c4da2] flex flex-col items-center justify-center px-[3mm] shrink-0"
          style="width: 39%"
        >
          <span
            class="font-sans font-extrabold text-white uppercase leading-none tracking-tight"
            :style="{ fontSize: `${Math.max(7, 21 * scaleFactor).toFixed(2)}mm` }"
          >
            MEMBER
          </span>
          <span
            class="font-sans font-extrabold text-[#fff200] uppercase leading-tight mt-[1.5mm]"
            :style="{ fontSize: `${Math.max(4, 9 * scaleFactor).toFixed(2)}mm` }"
          >
            DISC RP. {{ formattedDiscount }}
          </span>
        </div>

        <!-- Center Yellow Block: Red Member Price + Black RP./UOM -->
        <div
          class="bg-[#fff200] flex items-center justify-center gap-[2mm] px-[3mm] shrink-0"
          style="width: 36%"
        >
          <span
            class="font-display font-black text-[#ef3338] leading-[0.9] whitespace-nowrap"
            :style="{ fontSize: memberPriceFontSize }"
          >
            {{ formattedMemberPrice }}
          </span>
          <div class="flex flex-col items-start justify-center leading-none">
            <span
              class="font-sans font-extrabold text-black"
              :style="{ fontSize: `${Math.max(4, 8.5 * scaleFactor).toFixed(2)}mm` }"
            >
              RP.
            </span>
            <span
              class="font-sans font-extrabold text-black mt-0.5"
              :style="{ fontSize: `${Math.max(4, 8.5 * scaleFactor).toFixed(2)}mm` }"
            >
              /{{ page.uom }}
            </span>
          </div>
        </div>

        <!-- Right Solid Blue Block -->
        <div class="bg-[#0c4da2] flex-1" />
      </div>

      <!-- Bottom Footer: Branch + Brand Logo -->
      <div
        class="flex items-end justify-between shrink-0"
        :style="{ paddingTop: `${(2.5 * scaleFactor).toFixed(2)}mm` }"
      >
        <div
          class="font-display font-black uppercase text-black tracking-tight leading-none"
          :style="{ fontSize: `${Math.max(4.5, 7 * scaleFactor).toFixed(2)}mm` }"
        >
          {{ page.branch?.trim() || 'BABAT 1' }}
        </div>

        <img
          v-if="brand === 'laskar'"
          src="~/assets/images/laskar-footer.png"
          alt="Laskar Buah"
          class="w-auto object-contain"
          :style="{ height: `${Math.max(5, 11 * scaleFactor).toFixed(2)}mm` }"
        />
        <img
          v-else
          src="~/assets/images/bazzar-footer.png"
          alt="Bazzar"
          class="w-auto object-contain"
          :style="{ height: `${Math.max(5, 11 * scaleFactor).toFixed(2)}mm` }"
        />
      </div>
    </div>
  </div>
</template>

