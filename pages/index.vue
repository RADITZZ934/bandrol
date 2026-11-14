<script setup lang="ts">
import { useBandrolStore } from '~/stores/bandrolStore'
import BandrolPage from '~/components/Canvas/BandrolPage.vue'
import PageThumbnails from '~/components/Canvas/PageThumbnails.vue'

const store = useBandrolStore()
</script>

<template>
  <div class="flex-1 flex flex-col min-w-0 min-h-0 relative print-area">
    <!-- Center Canvas Workspace (Animated Active Page) -->
    <div
      class="flex-1 overflow-auto px-6 py-6 flex items-center justify-center print-area"
    >
      <Transition name="page-switch" mode="out-in">
        <div :key="store.activePage.id" class="relative">
          <BandrolPage
            :page="store.activePage"
            :index="store.activePageIndex"
          />
        </div>
      </Transition>

      <!-- Inactive Pages (Off-screen for PDF Export & Print) -->
      <template v-for="(page, index) in store.pages" :key="`offscreen-${page.id}`">
        <div
          v-if="index !== store.activePageIndex"
          class="fixed -left-[99999px] top-0 pointer-events-none print:static print:left-auto"
        >
          <BandrolPage :page="page" :index="index" />
        </div>
      </template>
    </div>

    <!-- Bottom Page Navigation & Add Page Strip -->
    <PageThumbnails />
  </div>
</template>
