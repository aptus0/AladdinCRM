<script lang="ts">
    let {
        class: className = '',
        alt = 'Aladdin CRM',
        ...rest
    }: {
        class?: string;
        alt?: string;
        [key: string]: unknown;
    } = $props();
</script>

<img
    src="/brand/aladdin-crm-icon.svg"
    {alt}
    class={className}
    loading="lazy"
    decoding="async"
    {...rest}
/>
