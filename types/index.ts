export type ColorMode = 'grayscale' | 'colour'
export type InputMethod = 'manual' | 'upload-pdf'
export type BrandType = 'laskar' | 'bazzar'
export type TemplateStyle = 'latest' | 'modern' | 'classic'
export type UomType = 'PCS' | 'KG' | 'GRAM' | 'PACK'

export interface BandrolSizePreset {
  id: string
  label: string
  widthMm: number
  heightMm: number
  orientation: 'landscape' | 'portrait'
  isPromo?: boolean
}

export interface ProductItem {
  code: string
  name: string
}

export interface BandrolPageData {
  id: string
  itemName: string
  price: string
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

