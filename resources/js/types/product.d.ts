export interface Product {
    id: number
    name: string
    description: string,
    reference: string,
    ean13: string,
    quantity: number,
    retailPrice: number,
    active: boolean,
    created_at: string;
    updated_at: string;
}