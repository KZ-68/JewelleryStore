export interface Product {
    id: number
    name: string
    slug: string
    description: string
    reference: string
    ean13: string
    quantity: number
    price_ht: number
    retail_price: number
    cost_price: number
    image: string
    active: boolean
    created_at: string
    updated_at: string
}