import { usePage } from '@inertiajs/vue3';

export function useTrans( value : string )
{
    const array = usePage().props.translations;

    return array[ value ] != null ? array[ value ] : value;
}

export function useRoute( value : string )
{
    return `/${usePage().props.locale}${value ?? ''}`;
}