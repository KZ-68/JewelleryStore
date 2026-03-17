export interface TaxRule {
    id: number
    tax_id: number
    country_id: number
    tax_rule_group_id: number
    behavior: string
    rate_order: number
}