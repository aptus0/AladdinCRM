<script lang="ts">
    import AppLogoIcon from '@/components/AppLogoIcon.svelte';
</script>

<div class="flex aspect-square size-9 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm">
    <AppLogoIcon class="size-8" alt="Aladdin CRM ikon" />
</div>
<div class="ml-2 grid flex-1 text-left text-sm leading-tight">
    <img
        src="/brand/aladdin-crm-logo.svg"
        alt="Aladdin CRM logo"
        class="h-8 w-auto max-w-[170px] object-contain group-data-[collapsible=icon]:hidden"
        loading="lazy"
        decoding="async"
    />
    <span class="truncate text-[11px] text-slate-500 group-data-[collapsible=icon]:hidden">Akilli CRM Platformu</span>
</div>
