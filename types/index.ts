export type ColorMode = 'grayscale' | 'colour'
export type InputMethod = 'manual' | 'upload-excel'
export type BrandType = 'laskar' | 'bazzar'
export type TemplateStyle = 'latest' | 'modern' | 'classic'
export type UomType = 'PCS' | 'KG' | 'GRAM' | 'PACK' | (string & {})

export interface BandrolSizePreset {
  id: string
  label: string
  widthMm: number
  heightMm: number
  orientation: 'landscape' | 'portrait'
  isPromo?: boolean
  isMemberPromo?: boolean
  tileCols?: number
  tileRows?: number
}

export interface ProductItem {
  code: string
  name: string
  uom: string
  price?: string
}

export interface BandrolPageData {
  id: string
  itemName: string
  price: string
  memberDiscount?: string
  uom: UomType
  barcode: string
  isBarcodeLocked?: boolean
  branch: string
  sizeId: string
}

export interface BandrolState {
  colorMode: ColorMode
  inputMethod: InputMethod
  brand: BrandType
  templateStyle: TemplateStyle
  fileName: string
  activePageIndex: number
  pages: BandrolPageData[]
}

