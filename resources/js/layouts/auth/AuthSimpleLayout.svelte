<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';
    import AppLogoIcon from '@/components/AppLogoIcon.svelte';
    import { home } from '@/routes';

    type AuthSceneType = 'auth' | 'login' | 'register';

    type AuthSceneContent = {
        badge: string;
        headline: string;
        summary: string;
        highlights: string[];
        flow: string[];
    };

    let {
        title = '',
        description = '',
        sceneType = 'auth',
        children,
    }: {
        title?: string;
        description?: string;
        sceneType?: AuthSceneType;
        children?: Snippet;
    } = $props();

    const sceneMap: Record<AuthSceneType, AuthSceneContent> = {
        auth: {
            badge: 'ALADDIN CRM',
            headline: 'Tum musteri sureclerini tek bir platformdan yonetin',
            summary: 'Satis, teklif, destek ve gorev operasyonlari tek panelde duzenli sekilde yonetilir.',
            highlights: ['Musteri 360', 'Pipeline Takibi', 'Destek Sureci'],
            flow: ['Kimlik dogrulama', 'Rol bazli yetki', 'Modul veri yukleme'],
        },
        login: {
            badge: 'GUVENLI GIRIS',
            headline: 'Ekibinizin CRM paneline guvenli baglanti',
            summary: 'Kullanici dogrulanir, yetkiler kontrol edilir ve dashboard verileri oturum icinde yuklenir.',
            highlights: ['Guvenli Oturum', 'Policy Kontrolu', 'Canli Dashboard'],
            flow: ['Email + sifre kontrolu', 'Yetki dogrulamasi', 'Dashboard acilisi'],
        },
        register: {
            badge: 'HIZLI KURULUM',
            headline: 'Dakikalar icinde kurumsal CRM baslangici',
            summary: 'Hesap olusturulduktan sonra ekip rolleri ve temel moduller hazir sekilde acilir.',
            highlights: ['Hesap Kurulumu', 'Rol Yapisi', 'Hazir Moduller'],
            flow: ['Kayit dogrulama', 'Ilk rol atama', 'Calisma alani olusturma'],
        },
    };

    const currentScene = $derived(sceneMap[sceneType]);
</script>

<div class="relative min-h-svh overflow-hidden bg-[#f7f2ff] text-slate-900">
    <div class="mx-auto grid min-h-svh w-full lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)]">
        <section class="relative min-h-[40svh] overflow-hidden bg-[#1f0f45] text-slate-100 lg:min-h-svh">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_15%_10%,_rgba(167,139,250,0.26),_transparent_45%)]"></div>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_86%_86%,_rgba(250,204,21,0.18),_transparent_48%)]"></div>
            <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(150deg,rgba(22,9,54,0.8),rgba(49,22,108,0.86))]"></div>

            <div class="relative mx-auto flex h-full w-full max-w-3xl flex-col justify-between gap-8 px-6 py-8 sm:px-10 lg:px-14 lg:py-12">
                <Link href={home()} class="inline-flex items-center gap-3">
                    <img
                        src="/brand/aladdin-crm-logo.svg"
                        alt="Aladdin CRM logo"
                        class="h-11 w-auto object-contain"
                        loading="lazy"
                        decoding="async"
                    />
                </Link>

                <div class="space-y-5">
                    <p class="auth-title text-xs font-semibold tracking-[0.22em] text-amber-200">{currentScene.badge}</p>
                    <h2 class="auth-title text-3xl leading-tight font-semibold text-white sm:text-4xl">{currentScene.headline}</h2>
                    <p class="max-w-xl text-sm leading-6 text-violet-100 sm:text-base">{currentScene.summary}</p>

                    <div class="grid gap-2 sm:grid-cols-3">
                        {#each currentScene.highlights as highlight (highlight)}
                            <div class="rounded-xl border border-violet-300/35 bg-violet-950/40 px-3 py-2 text-center text-xs font-medium text-violet-100">
                                {highlight}
                            </div>
                        {/each}
                    </div>

                    <div class="mt-2 rounded-2xl border border-violet-300/35 bg-violet-950/35 p-4 sm:p-5">
                        <p class="mb-3 text-xs font-semibold tracking-[0.16em] text-amber-200">GUVENLI GIRIS AKISI</p>
                        <div class="space-y-2">
                            {#each currentScene.flow as step, index (step)}
                                <div class="flex items-center gap-3 rounded-xl border border-violet-300/30 bg-violet-950/45 px-3 py-2.5 text-sm text-violet-100">
                                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-amber-300 text-xs font-semibold text-violet-950">
                                        {index + 1}
                                    </span>
                                    <span>{step}</span>
                                </div>
                            {/each}
                        </div>
                    </div>
                </div>

                <p class="text-xs text-violet-100/70">
                    Guvenli kimlik dogrulama, rol bazli yetkilendirme ve izlenebilir CRM operasyonlari.
                </p>
            </div>
        </section>

        <section class="relative flex min-h-svh items-center justify-center bg-[#fbf9ff] px-4 py-8 sm:px-8 lg:px-10">
            <div class="w-full max-w-md rounded-3xl border border-violet-100 bg-white p-6 shadow-[0_18px_50px_-28px_rgba(76,29,149,0.28)] sm:p-8">
                <Link href={home()} class="mb-6 inline-flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-amber-200 bg-amber-50">
                        <AppLogoIcon class="size-8" />
                    </div>
                    <span class="auth-title text-sm font-semibold tracking-[0.08em] text-violet-700">ALLADDIN CRM</span>
                </Link>

                <div class="mb-7 space-y-2">
                    <h1 class="auth-title text-2xl font-semibold tracking-tight text-slate-900">{title}</h1>
                    <p class="text-sm leading-6 text-slate-600">{description}</p>
                </div>

                {@render children?.()}
            </div>
        </section>
    </div>
</div>

<style>
    .auth-title {
        font-family: 'Sora', 'Manrope', 'Segoe UI', sans-serif;
    }
</style>
