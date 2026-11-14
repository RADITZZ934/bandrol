<script setup lang="ts">
import { Plus, X } from 'lucide-vue-next'
import { useBandrolStore } from '~/stores/bandrolStore'
import { getPresetById } from '~/utils/constants'
import BandrolTemplate from '~/components/Canvas/BandrolTemplate.vue'
import BandrolClassicTemplate from '~/components/Canvas/BandrolClassicTemplate.vue'
import BandrolLatestTemplate from '~/components/Canvas/BandrolLatestTemplate.vue'
import BandrolMemberTemplate from '~/components/Canvas/BandrolMemberTemplate.vue'

const store = useBandrolStore()

const MM_TO_PX = 3.7795275591
const THUMB_HEIGHT_PX = 64

function getThumbScale(sizeId: string): number {
  const preset = getPresetById(sizeId)
  return THUMB_HEIGHT_PX / (preset.heightMm * MM_TO_PX)
}

function getThumbBoxStyle(sizeId: string) {
  const preset = getPresetById(sizeId)
  const scale = getThumbScale(sizeId)
  return {
    width: `${Math.round(preset.widthMm * MM_TO_PX * scale)}px`,
    height: `${THUMB_HEIGHT_PX}px`,
  }
}
</script>

<template>
  <div
    class="no-print w-full px-6 pb-4 pt-2 flex items-center justify-center gap-3 overflow-x-auto shrink-0"
  >
    <TransitionGroup
      name="thumb-pop"
      tag="div"
      class="relative flex items-center gap-3"
    >
      <div
        v-for="(page, index) in store.pages"
        :key="page.id"
        class="group relative shrink-0 cursor-pointer rounded-md overflow-hidden bg-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 active:scale-95"
        :class="
          store.activePageIndex === index
            ? 'ring-2 ring-[#48a842] shadow-md scale-[1.03]'
            : 'ring-1 ring-gray-400/70 opacity-85 hover:opacity-100'
        "
        :style="getThumbBoxStyle(page.sizeId)"
        @click="store.setActivePageIndex(index)"
      >
        <!-- Miniature scaled bandrol preview -->
        <div
          class="origin-top-left pointer-events-none"
          :style="{ transform: `scale(${getThumbScale(page.sizeId)})` }"
        >
          <div
            :style="{
              width: `${getPresetById(page.sizeId).widthMm}mm`,
              height: `${getPresetById(page.sizeId).heightMm}mm`,
            }"
          >
            <BandrolMemberTemplate
              v-if="getPresetById(page.sizeId).isMemberPromo"
              :page="page"
              :preset="getPresetById(page.sizeId)"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolLatestTemplate
              v-else-if="store.templateStyle === 'latest'"
              :page="page"
              :preset="getPresetById(page.sizeId)"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolTemplate
              v-else-if="store.templateStyle === 'modern'"
              :page="page"
              :preset="getPresetById(page.sizeId)"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolClassicTemplate
              v-else
              :page="page"
              :preset="getPresetById(page.sizeId)"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
          </div>
        </div>

        <!-- Delete button (visible on hover when > 1 page) -->
        <button
          v-if="store.pages.length > 1"
          type="button"
          title="Hapus halaman"
          class="absolute top-0.5 right-0.5 w-4 h-4 rounded-full bg-red-600 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow"
          @click.stop="store.removePage(index)"
        >
          <X class="w-2.5 h-2.5" />
        </button>
      </div>
    </TransitionGroup>

    <!-- Add Page "+" Card -->
    <button
      type="button"
      title="Tambah Halaman Baru"
      class="shrink-0 w-24 h-16 rounded-md bg-neutral-600/80 hover:bg-neutral-700 text-gray-200 hover:text-white flex items-center justify-center shadow-sm transition-all duration-200 hover:-translate-y-0.5 active:scale-95"
      @click="store.addPage()"
    >
      <Plus class="w-7 h-7 stroke-[2.5]" />
    </button>
  </div>
</template>

