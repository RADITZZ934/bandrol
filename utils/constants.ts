import type { BandrolSizePreset, UomType } from '~/types'

export const BANDROL_SIZE_PRESETS: BandrolSizePreset[] = [
  {
    id: 'f4-landscape',
    label: '1. F4 Landscape (330x210 mm)',
    widthMm: 330,
    heightMm: 210,
    orientation: 'landscape',
  },
  {
    id: 'f4-2-landscape',
    label: '15. F4 2 Landscape (330x105 mm)',
    widthMm: 330,
    heightMm: 105,
    orientation: 'landscape',
  },
  {
    id: 'f4-2-portrait',
    label: '3. F4 2 Portrait (210x165 mm)',
    widthMm: 210,
    heightMm: 165,
    orientation: 'portrait',
  },
  {
    id: 'f4-4-portrait',
    label: '7. F4 4 Portrait (210x82 mm)',
    widthMm: 210,
    heightMm: 82,
    orientation: 'landscape',
  },
  {
    id: 'f4-10-landscape',
    label: '4. F4 10 Landscape (330x175 mm)',
    widthMm: 330,
    heightMm: 175,
    orientation: 'landscape',
  },
  {
    id: 'f4-18-portrait',
    label: '11. F4 18 Portrait (330x113 mm)',
    widthMm: 330,
    heightMm: 113,
    orientation: 'landscape',
  },
  {
    id: 'f4-promo-landscape',
    label: '13. F4 Promo Landscape (4× F4: 660×420 mm)',
    widthMm: 660,
    heightMm: 420,
    orientation: 'landscape',
    isPromo: true,
    tileCols: 2,
    tileRows: 2,
  },
  {
    id: 'f4-2-promo-portrait',
    label: '9. F4 2 Promo Portrait (2× F4: 420×330 mm)',
    widthMm: 420,
    heightMm: 330,
    orientation: 'portrait',
    isPromo: true,
    tileCols: 2,
    tileRows: 1,
  },
  {
    id: 'bandrol-promo-member',
    label: 'BANDROL PROMO MEMBER (330×210 mm)',
    widthMm: 330,
    heightMm: 210,
    orientation: 'landscape',
    isMemberPromo: true,
  },
  {
    id: 'mini-mikro',
    label: 'Bandrol kecil mini mikro (65×35 mm)',
    widthMm: 65,
    heightMm: 35,
    orientation: 'landscape',
  },
]

export const UOM_OPTIONS: UomType[] = ['PCS', 'KG', 'GRAM', 'PACK']

export const DEFAULT_BRANCH = 'BABAT 1'

export function getPresetById(id: string): BandrolSizePreset {
  return BANDROL_SIZE_PRESETS.find((p) => p.id === id) ?? BANDROL_SIZE_PRESETS[0]
}

export function formatPriceId(raw: string): string {
  const digits = raw.replace(/\D/g, '')
  if (!digits) return '0'
  return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

export interface F4LayoutInfo {
  sheetWidthMm: number
  sheetHeightMm: number
  cols: number
  rows: number
  totalSlots: number
  isTiledPoster: boolean
  tileCols: number
  tileRows: number
  sheetsPerPage: number
}

export function getF4LayoutInfo(preset: BandrolSizePreset): F4LayoutInfo {
  const isPortrait = preset.orientation === 'portrait'
  const sheetWidthMm = isPortrait ? 210 : 330
  const sheetHeightMm = isPortrait ? 330 : 210

  const tileCols = preset.tileCols ?? 1
  const tileRows = preset.tileRows ?? 1
  const isTiledPoster = tileCols > 1 || tileRows > 1

  if (isTiledPoster) {
    return {
      sheetWidthMm,
      sheetHeightMm,
      cols: 1,
      rows: 1,
      totalSlots: 1,
      isTiledPoster: true,
      tileCols,
      tileRows,
      sheetsPerPage: tileCols * tileRows,
    }
  }

  const cols = Math.max(1, Math.floor((sheetWidthMm + 1) / preset.widthMm))
  const rows = Math.max(1, Math.floor((sheetHeightMm + 1) / preset.heightMm))

  return {
    sheetWidthMm,
    sheetHeightMm,
    cols,
    rows,
    totalSlots: cols * rows,
    isTiledPoster: false,
    tileCols: 1,
    tileRows: 1,
    sheetsPerPage: 1,
  }
}

