<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import CorporateLayout from '@/layouts/CorporateLayout.svelte';

    let {
        canRegister = true,
    }: {
        canRegister?: boolean;
    } = $props();

    const solutions = [
        {
            title: 'Satis Ekipleri',
            points: ['Pipeline yonetimi', 'Teklif ve firsat takibi', 'Hedef bazli performans panelleri'],
        },
        {
            title: 'Musteri Basari',
            points: ['Musteri yasam dongusu analizi', 'Talep onceliklendirme', 'Yenileme risk raporlari'],
        },
        {
            title: 'Operasyon ve Yonetim',
            points: ['KPI izleme', 'Rol bazli gorev dagitimi', 'Surec otomasyon kurallari'],
        },
    ];
</script>

<AppHead title="Cozumler" />

<CorporateLayout {canRegister}>
    <section class="mx-auto w-full max-w-7xl px-4 py-14 sm:px-6">
        <div class="max-w-3xl">
            <p class="text-xs font-semibold tracking-[0.14em] text-cyan-700">COZUMLER</p>
            <h1 class="mt-3 text-4xl leading-tight font-semibold tracking-tight text-slate-900 sm:text-5xl">
                Kurumsal ekipler icin CRM odakli cozumler
            </h1>
            <p class="mt-5 text-base leading-7 text-slate-600 sm:text-lg">
                Aladdin CRM modulleri, farkli departman ihtiyaclarini tek bir veri yapisi uzerinde birlestirir.
            </p>
        </div>

        <div class="mt-9 grid gap-4 md:grid-cols-3">
            {#each solutions as solution (solution.title)}
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">{solution.title}</h2>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        {#each solution.points as point (point)}
                            <li class="rounded-lg bg-slate-50 px-3 py-2">{point}</li>
                        {/each}
                    </ul>
                </article>
            {/each}
        </div>
    </section>
</CorporateLayout>
