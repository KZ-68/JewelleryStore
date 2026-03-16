export interface Message {
    id: number
    from_email: string
    from_name: string
    to_email: string
    to_name: string
    subject: string
    content: string
    isReaded: boolean
    created_at: string
    updated_at: string
}