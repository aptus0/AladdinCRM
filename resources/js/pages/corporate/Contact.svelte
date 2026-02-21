<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import CorporateLayout from '@/layouts/CorporateLayout.svelte';

    let {
        canRegister = true,
    }: {
        canRegister?: boolean;
    } = $props();
</script>

<AppHead title="Iletisim" />

<CorporateLayout {canRegister}>
    <section class="mx-auto w-full max-w-7xl px-4 py-14 sm:px-6">
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold tracking-[0.14em] text-violet-700">ILETISIM</p>
                <h1 class="mt-3 text-3xl leading-tight font-semibold tracking-tight text-slate-900 sm:text-4xl">
                    Kurumsal ekibimizle iletisime gecin
                </h1>
                <p class="mt-4 text-sm leading-7 text-slate-600 sm:text-base">
                    Demo talebi, fiyatlandirma ve teknik entegrasyon surecleriniz icin CRM danisman ekibimizle birebir
                    gorusme planlayabilirsiniz.
                </p>

                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <p><span class="font-semibold text-slate-900">E-posta:</span> kurumsal@aladdincrm.com</p>
                    <p><span class="font-semibold text-slate-900">Telefon:</span> +90 (212) 000 00 00</p>
                    <p><span class="font-semibold text-slate-900">Adres:</span> Istanbul Teknoloji Merkezi, Sariyer</p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">CRM odakli destek basliklari</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <p class="rounded-lg bg-slate-50 px-3 py-2">Kurulum ve onboarding planlamasi</p>
                    <p class="rounded-lg bg-slate-50 px-3 py-2">Veri tasima ve entegrasyon analizi</p>
                    <p class="rounded-lg bg-slate-50 px-3 py-2">Ekibinize ozel pipeline tasarimi</p>
                    <p class="rounded-lg bg-slate-50 px-3 py-2">Raporlama ve performans gostergeleri taslagi</p>
                </div>
            </div>
        </div>
    </section>
</CorporateLayout>
