<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import CorporateLayout from '@/layouts/CorporateLayout.svelte';
    import { login, register } from '@/routes';

    let {
        canRegister = true,
    }: {
        canRegister?: boolean;
    } = $props();

    const cards = [
        {
            title: 'Musteri 360',
            description: 'Tum gorusmeler, teklifler ve islem gecmisi tek musteri kartinda.',
        },
        {
            title: 'Satis Pipeline',
            description: 'Firsatlari asama bazli yonetin ve kayip-risk noktalarini aninda gorun.',
        },
        {
            title: 'Operasyon Takibi',
            description: 'Gorevleri, ekip sorumluluklarini ve teslim sureclerini merkezden takip edin.',
        },
    ];
</script>

<AppHead title="Kurumsal CRM Platformu" />

<CorporateLayout {canRegister}>
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.15),_transparent_46%)]"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,_rgba(30,64,175,0.12),_transparent_48%)]"></div>

        <div class="relative mx-auto grid w-full max-w-7xl gap-8 px-4 pt-14 pb-14 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:pt-20 lg:pb-20">
            <div class="space-y-6">
                <span class="inline-flex rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-xs font-semibold tracking-[0.14em] text-cyan-700">
                    ALADDIN CRM PLATFORMU
                </span>

                <h1 class="text-4xl leading-tight font-semibold tracking-tight text-slate-900 sm:text-5xl">
                    Kurumsal musteri yonetiminde hiz, netlik ve kontrol
                </h1>

                <p class="max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                    Aladdin CRM, satis ekipleri ve operasyon birimlerinin musteri yolculugunu tek ekrandan yonetmesini
                    saglayan modern bir kurumsal platformdur.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <Link href={login()}><Button size="lg" class="rounded-full px-7">Demo Girisi</Button></Link>
                    {#if canRegister}
                        <Link href={register()}>
                            <Button size="lg" variant="outline" class="rounded-full border-slate-300 px-7">Hemen Basla</Button>
                        </Link>
                    {/if}
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <img
                        src="/brand/aladdin-crm-logo.svg"
                        alt="Aladdin CRM"
                        class="mx-auto h-32 w-auto max-w-full object-contain"
                        decoding="async"
                    />

                    <div class="mt-4 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-xl border border-cyan-200/70 bg-cyan-50 p-3">
                            <p class="text-xs text-slate-500">Aktif Musteri</p>
                            <p class="mt-1 text-lg font-semibold text-slate-900">2.430</p>
                        </div>
                        <div class="rounded-xl border border-blue-200/70 bg-blue-50 p-3">
                            <p class="text-xs text-slate-500">Aylik Pipeline</p>
                            <p class="mt-1 text-lg font-semibold text-slate-900">18.6M</p>
                        </div>
                        <div class="rounded-xl border border-indigo-200/70 bg-indigo-50 p-3">
                            <p class="text-xs text-slate-500">Tamamlanan Gorev</p>
                            <p class="mt-1 text-lg font-semibold text-slate-900">9.840</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto w-full max-w-7xl px-4 pb-20 sm:px-6">
        <div class="grid gap-4 md:grid-cols-3">
            {#each cards as card (card.title)}
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">{card.title}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{card.description}</p>
                </article>
            {/each}
        </div>
    </section>
</CorporateLayout>
