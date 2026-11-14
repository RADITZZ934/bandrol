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
    memberDiscount: '2000',
    uom: 'KG',
    barcode: '5703140',
    branch: DEFAULT_BRANCH,
    sizeId: 'f4-landscape',
    ...overrides,
  }
}

const SESSION_STORAGE_KEY = 'bandrol-maker-session'

function slugPart(val: string, fallback: string, separator = '-'): string {
  const cleaned = val
    .trim()
    .toUpperCase()
    .replace(/[\\/:*?"<>|]+/g, '')
    .replace(/\s+/g, separator)
  return cleaned || fallback
}

function getTodayCompact(): string {
  const now = new Date()
  const y = now.getFullYear()
  const m = String(now.getMonth() + 1).padStart(2, '0')
  const d = String(now.getDate()).padStart(2, '0')
  return `${y}${m}${d}`
}

function buildAutoFileName(page: BandrolPageData): string {
  const itemSlug = slugPart(page.itemName, 'ITEM', '-')
  const branchSlug = slugPart(page.branch, 'CABANG', '')
  return `Bandrol_${itemSlug}_${branchSlug}_${getTodayCompact()}.pdf`
}

function createDefaultState() {
  const firstPage = createPage()
  return {
    colorMode: 'colour' as ColorMode,
    inputMethod: 'upload-excel' as InputMethod,
    brand: 'laskar' as BrandType,
    templateStyle: 'modern' as TemplateStyle,
    fileName: buildAutoFileName(firstPage),
    isCustomFileName: false,
    zoom: 1,
    activePageIndex: 0,
    pages: [firstPage] as BandrolPageData[],
  }
}

function loadSessionState() {
  const defaults = createDefaultState()
  if (typeof window === 'undefined') return defaults
  try {
    const navEntries = window.performance?.getEntriesByType?.('navigation') as
      | PerformanceNavigationTiming[]
      | undefined
    if (navEntries?.[0]?.type === 'reload') {
      window.sessionStorage.removeItem(SESSION_STORAGE_KEY)
      return defaults
    }

    const raw = window.sessionStorage.getItem(SESSION_STORAGE_KEY)
    if (!raw) return defaults
    const parsed = JSON.parse(raw)
    return {
      colorMode: parsed.colorMode ?? defaults.colorMode,
      inputMethod: parsed.inputMethod ?? defaults.inputMethod,
      brand: parsed.brand ?? defaults.brand,
      templateStyle: parsed.templateStyle ?? defaults.templateStyle,
      fileName:
        typeof parsed.fileName === 'string'
          ? parsed.fileName
          : defaults.fileName,
      isCustomFileName: Boolean(parsed.isCustomFileName),
      zoom: typeof parsed.zoom === 'number' ? parsed.zoom : defaults.zoom,
      activePageIndex:
        Array.isArray(parsed.pages) && parsed.pages.length > 0
          ? Math.min(parsed.activePageIndex ?? 0, parsed.pages.length - 1)
          : 0,
      pages:
        Array.isArray(parsed.pages) && parsed.pages.length > 0
          ? (parsed.pages as BandrolPageData[])
          : defaults.pages,
    }
  } catch {
    return defaults
  }
}

export const useBandrolStore = defineStore('bandrol', {
  state: () => loadSessionState(),

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
      this.isCustomFileName = name.trim().length > 0
    },
    syncAutoFileName() {
      if (!this.isCustomFileName) {
        this.fileName = buildAutoFileName(this.activePage)
      }
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
        this.syncAutoFileName()
      }
    },
    updateActivePage(patch: Partial<BandrolPageData>) {
      const current = this.pages[this.activePageIndex]
      if (!current) return
      this.pages[this.activePageIndex] = { ...current, ...patch }
      this.syncAutoFileName()
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
      this.syncAutoFileName()
    },
    removePage(index: number) {
      if (this.pages.length <= 1) return
      this.pages.splice(index, 1)
      if (this.activePageIndex >= this.pages.length) {
        this.activePageIndex = this.pages.length - 1
      }
    },
    importPages(items: Array<Partial<BandrolPageData>>) {
      if (items.length === 0) return
      const currentSizeId = this.activePage.sizeId
      const currentBranch = this.activePage.branch
      this.pages = items.map((item) =>
        createPage({
          itemName: item.itemName ?? '',
          price: item.price ?? '0',
          memberDiscount: item.memberDiscount ?? '0',
          uom: item.uom ?? 'KG',
          barcode: item.barcode ?? '',
          isBarcodeLocked: Boolean(item.barcode),
          branch: item.branch || currentBranch,
          sizeId: currentSizeId,
        })
      )
      this.activePageIndex = 0
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

