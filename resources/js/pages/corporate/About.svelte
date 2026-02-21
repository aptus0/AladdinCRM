<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import CorporateLayout from '@/layouts/CorporateLayout.svelte';

    let {
        canRegister = true,
    }: {
        canRegister?: boolean;
    } = $props();

    const values = [
        {
            title: 'Guvenilir Altyapi',
            description: 'Kurumsal duzey guvenlik yaklasimi ile veri butunlugu ve erisim yonetimi saglanir.',
        },
        {
            title: 'Surec Odakli Mimari',
            description: 'Satis ve operasyon akislari gereksiz adimlardan arindirilmis sade bir deneyime donusturulur.',
        },
        {
            title: 'Olceklenebilirlik',
            description: 'Kucuk ekiplerden buyuk operasyonlara kadar farkli yapilara hizlica uyarlanir.',
        },
    ];
</script>

<AppHead title="Kurumsal" />

<CorporateLayout {canRegister}>
    <section class="mx-auto w-full max-w-7xl px-4 py-14 sm:px-6">
        <div class="max-w-3xl">
            <p class="text-xs font-semibold tracking-[0.14em] text-cyan-700">KURUMSAL</p>
            <h1 class="mt-3 text-4xl leading-tight font-semibold tracking-tight text-slate-900 sm:text-5xl">
                Is hedeflerini merkezde toplayan CRM vizyonu
            </h1>
            <p class="mt-5 text-base leading-7 text-slate-600 sm:text-lg">
                Aladdin CRM, ekiplerin musteri iliskilerini sadece kaydetmesini degil, stratejik kararlara donusturmesini
                hedefleyen kurumsal bir platformdur.
            </p>
        </div>

        <div class="mt-9 grid gap-4 md:grid-cols-3">
            {#each values as value (value.title)}
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">{value.title}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{value.description}</p>
                </article>
            {/each}
        </div>
    </section>
</CorporateLayout>
