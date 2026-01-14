export interface Product {
    id: number
    name: string
    slug: string
    description: string
    reference: string
    ean13: string
    quantity: number
    price_ht: number
    cost_price: number
    active: boolean
    created_at: string
    updated_at: string
}