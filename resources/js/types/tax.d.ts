export interface Tax {
    id: number
    name: string
    slug: string
    rate: number
    applicable: boolean
    type: string
    description: string
    created_at: string
    updated_at: string
}