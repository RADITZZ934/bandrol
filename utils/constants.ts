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
    label: '13. F4 Promo Landscape (330x210 mm)',
    widthMm: 330,
    heightMm: 210,
    orientation: 'landscape',
    isPromo: true,
  },
  {
    id: 'f4-2-promo-portrait',
    label: '9. F4 2 Promo Portrait (330x260 mm)',
    widthMm: 330,
    heightMm: 260,
    orientation: 'landscape',
    isPromo: true,
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

