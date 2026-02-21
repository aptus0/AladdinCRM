<script lang="ts">
    import AppLogoIcon from '@/components/AppLogoIcon.svelte';
</script>

<div
    class="flex aspect-square size-10 items-center justify-center rounded-2xl border border-violet-300/60 bg-[linear-gradient(150deg,#2a1550,#4f2491)] shadow-[0_16px_34px_-20px_rgba(18,8,36,0.85)]"
>
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
    <span class="truncate text-[11px] text-sidebar-foreground/65 group-data-[collapsible=icon]:hidden">
        Satis ve Destek Operasyon Merkezi
    </span>
</div>
