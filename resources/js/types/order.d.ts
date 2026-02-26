export interface Order {
    id: number
    carrier_id: number
    customer_id: number
    reference: string
    gift: boolean
    gift_message: string
    note: string
    valid: boolean
    returned: boolean
    invoice_date: string
    delivery_date: string
    created_at: string
    updated_at: string
}