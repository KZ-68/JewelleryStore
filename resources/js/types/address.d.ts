export interface Address {
    id: number
    country_id: number|null
    customer_id: number|null
    manufacturer_id: number|null
    supplier_id: number|null
    name: string
    address_line_1: string
    address_line_2: string
    city: string
    postal_code: string
    region: string
    district: string
    sub_district: string
    locality: string
    sub_locality:string
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    country: Country|object
}