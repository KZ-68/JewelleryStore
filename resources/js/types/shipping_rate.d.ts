export interface ShippingRate {
    id: number
    carrier_id: number
    country_id: number
    min_total: number
    max_total: number
    price: number
    created_at: string
    updated_at: string
}