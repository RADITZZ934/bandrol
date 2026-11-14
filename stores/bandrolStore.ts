import { defineStore } from 'pinia'
import type {
  BandrolPageData,
  BrandType,
  ColorMode,
  InputMethod,
  TemplateStyle,
} from '~/types'
import { DEFAULT_BRANCH, getPresetById } from '~/utils/constants'

function createPage(overrides: Partial<BandrolPageData> = {}): BandrolPageData {
  return {
    id: `page-${Date.now()}-${Math.random().toString(36).slice(2, 7)}`,
    itemName: 'ALPUKAT MENTEGA REPACK',
    price: '5000',
    uom: 'KG',
    barcode: '5703140',
    branch: DEFAULT_BRANCH,
    sizeId: 'f4-landscape',
    ...overrides,
  }
}

export const useBandrolStore = defineStore('bandrol', {
  state: () => ({
    colorMode: 'colour' as ColorMode,
    inputMethod: 'manual' as InputMethod,
    brand: 'laskar' as BrandType,
    templateStyle: 'latest' as TemplateStyle,
    fileName: 'Namabandrol_tanggal.pdf',
    zoom: 1,
    activePageIndex: 0,
    pages: [createPage()] as BandrolPageData[],
  }),

  getters: {
    activePage(state): BandrolPageData {
      return state.pages[state.activePageIndex] ?? state.pages[0]
    },
    activePreset(): ReturnType<typeof getPresetById> {
      return getPresetById(this.activePage.sizeId)
    },
  },

  actions: {
    setColorMode(mode: ColorMode) {
      this.colorMode = mode
    },
    setInputMethod(method: InputMethod) {
      this.inputMethod = method
    },
    setBrand(brand: BrandType) {
      this.brand = brand
    },
    setTemplateStyle(style: TemplateStyle) {
      this.templateStyle = style
    },
    setFileName(name: string) {
      this.fileName = name
    },
    setZoom(val: number) {
      this.zoom = Math.min(1.5, Math.max(0.5, Number(val.toFixed(2))))
    },
    zoomIn() {
      this.setZoom(this.zoom + 0.1)
    },
    zoomOut() {
      this.setZoom(this.zoom - 0.1)
    },
    setActivePageIndex(index: number) {
      if (index >= 0 && index < this.pages.length) {
        this.activePageIndex = index
      }
    },
    updateActivePage(patch: Partial<BandrolPageData>) {
      const current = this.pages[this.activePageIndex]
      if (!current) return
      this.pages[this.activePageIndex] = { ...current, ...patch }
    },
    addPage() {
      const current = this.activePage
      const nextPage = createPage({
        itemName: '',
        price: '',
        uom: current.uom,
        barcode: '',
        branch: current.branch,
        sizeId: current.sizeId,
      })
      this.pages.push(nextPage)
      this.activePageIndex = this.pages.length - 1
    },
    removePage(index: number) {
      if (this.pages.length <= 1) return
      this.pages.splice(index, 1)
      if (this.activePageIndex >= this.pages.length) {
        this.activePageIndex = this.pages.length - 1
      }
    },
    getSnapshot(): string {
      return JSON.stringify({
        colorMode: this.colorMode,
        brand: this.brand,
        templateStyle: this.templateStyle,
        fileName: this.fileName,
        activePageIndex: this.activePageIndex,
        pages: this.pages,
      })
    },
    applySnapshot(raw: string) {
      try {
        const parsed = JSON.parse(raw)
        if (parsed.colorMode) this.colorMode = parsed.colorMode
        if (parsed.brand) this.brand = parsed.brand
        if (parsed.templateStyle) this.templateStyle = parsed.templateStyle
        if (typeof parsed.fileName === 'string') this.fileName = parsed.fileName
        if (Array.isArray(parsed.pages) && parsed.pages.length > 0) {
          this.pages = parsed.pages
          this.activePageIndex = Math.min(
            parsed.activePageIndex ?? 0,
            this.pages.length - 1
          )
        }
      } catch {
        // Ignore malformed snapshot
      }
    },
  },
})

