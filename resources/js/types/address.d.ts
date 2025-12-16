export interface Address {
    id: number
    country_id: number
    customer_id: number
    manufacturer_id: number
    supplier_id: number
    address_line_1: string
    address_line_2: string
    city: string
    postal_code: string
    region: string
    district: string
    sub_district: string
    locality: string
    sub_locality:string
    created_at: string
    updated_at: string
    deleted_at: string
    country: Country
}