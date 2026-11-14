<script setup lang="ts">
import { useBandrolStore } from '~/stores/bandrolStore'
import BandrolPage from '~/components/Canvas/BandrolPage.vue'
import PageThumbnails from '~/components/Canvas/PageThumbnails.vue'

const store = useBandrolStore()
</script>

<template>
  <div class="flex-1 flex flex-col min-w-0 min-h-0 relative print-area">
    <!-- Center Canvas Workspace -->
    <div
      class="flex-1 overflow-auto px-6 py-6 flex items-center justify-center print-area"
    >
      <template v-for="(page, index) in store.pages" :key="page.id">
        <div
          :class="
            index === store.activePageIndex
              ? 'relative'
              : 'fixed -left-[99999px] top-0 pointer-events-none print:static print:left-auto'
          "
        >
          <BandrolPage :page="page" :index="index" />
        </div>
      </template>
    </div>

    <!-- Bottom Page Navigation & Add Page Strip -->
    <PageThumbnails />
  </div>
</template>
