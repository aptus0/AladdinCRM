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
            summary: 'Satis, teklif, destek ve gorev operasyonlari kurumsal duzende ayni panelde birlesir.',
            highlights: ['Musteri 360', 'Pipeline Takibi', 'Destek Sureci'],
            flow: ['Kimlik dogrulama', 'Rol bazli yetki', 'Modul veri yukleme'],
        },
        login: {
            badge: 'GUVENLI GIRIS',
            headline: 'Ekibinizin CRM paneline guvenli baglanti',
            summary: 'Kullanici dogrulanir, policy kontrolleri calisir ve dashboard verileri oturum icinde acilir.',
            highlights: ['Guvenli Oturum', 'Policy Kontrolu', 'Canli Dashboard'],
            flow: ['Email + sifre kontrolu', 'Yetki dogrulamasi', 'Dashboard acilisi'],
        },
        register: {
            badge: 'HIZLI KURULUM',
            headline: 'Dakikalar icinde kurumsal CRM baslangici',
            summary: 'Hesap olusturulduktan sonra ekip rol yapisi ve temel moduller otomatik hazirlanir.',
            highlights: ['Hesap Kurulumu', 'Rol Yapisi', 'Hazir Moduller'],
            flow: ['Kayit dogrulama', 'Ilk rol atama', 'Calisma alani olusturma'],
        },
    };

    const currentScene = $derived(sceneMap[sceneType]);
</script>

<div class="relative min-h-svh overflow-hidden bg-[#f3f8ff] text-slate-900">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.2),_transparent_48%)]"></div>
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,_rgba(2,132,199,0.14),_transparent_52%)]"></div>

    <div class="relative mx-auto grid min-h-svh w-full max-w-7xl gap-5 p-4 sm:p-6 lg:grid-cols-[minmax(0,480px)_minmax(0,1fr)] lg:p-8">
        <section class="flex items-center">
            <div class="w-full rounded-[28px] border border-sky-100 bg-white p-6 shadow-[0_26px_80px_-34px_rgba(14,116,210,0.45)] sm:p-8">
                <Link href={home()} class="mb-7 inline-flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-sky-100 bg-white shadow-sm">
                        <AppLogoIcon class="size-9" />
                    </div>
                    <img
                        src="/brand/aladdin-crm-logo.svg"
                        alt="Aladdin CRM logo"
                        class="h-10 w-auto object-contain"
                        loading="lazy"
                        decoding="async"
                    />
                </Link>

                <div class="mb-7 space-y-2">
                    <h1 class="auth-title text-2xl font-semibold tracking-tight">{title}</h1>
                    <p class="text-sm leading-6 text-slate-600">{description}</p>
                </div>

                {@render children?.()}

                <div class="mt-6 grid gap-2 sm:grid-cols-3">
                    {#each currentScene.highlights as highlight (highlight)}
                        <div class="rounded-xl border border-sky-100 bg-sky-50 px-3 py-2 text-center text-xs font-medium text-sky-800">
                            {highlight}
                        </div>
                    {/each}
                </div>
            </div>
        </section>

        <aside class="relative hidden items-center lg:flex">
            <div class="hero-panel relative w-full overflow-hidden rounded-[30px] border border-sky-200/70 bg-[linear-gradient(145deg,#0369a1,#0284c7_45%,#0ea5e9)] p-8 text-white shadow-[0_34px_90px_-36px_rgba(3,105,161,0.7)]">
                <div class="pointer-events-none absolute -top-24 -right-24 h-64 w-64 rounded-full bg-white/18 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-cyan-200/20 blur-3xl"></div>

                <div class="relative space-y-4">
                    <p class="auth-title text-xs font-semibold tracking-[0.24em] text-cyan-100/95">{currentScene.badge}</p>
                    <h2 class="auth-title text-3xl leading-tight font-semibold text-white">{currentScene.headline}</h2>
                    <p class="max-w-2xl text-sm leading-6 text-sky-50/95">{currentScene.summary}</p>

                    <div class="scene-board relative mt-6 overflow-hidden rounded-3xl border border-white/25 bg-white/10 p-6 backdrop-blur-sm">
                        <div class="scene-logo rounded-2xl border border-white/30 bg-white/15 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <img
                                    src="/brand/aladdin-crm-logo.svg"
                                    alt="Aladdin CRM"
                                    class="h-14 w-auto object-contain"
                                    loading="lazy"
                                    decoding="async"
                                />
                                <div class="flex items-center gap-1.5">
                                    <span class="status-dot"></span>
                                    <span class="status-dot"></span>
                                    <span class="status-dot"></span>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-sky-50/90">Cloud CRM Workbench: Sales, Task, Support, Quote</p>
                        </div>

                        <div class="mt-3 grid gap-2 sm:grid-cols-3">
                            {#each currentScene.highlights as highlight (highlight)}
                                <div class="rounded-xl border border-white/25 bg-sky-950/35 px-3 py-2 text-center text-xs font-semibold text-cyan-50">
                                    {highlight}
                                </div>
                            {/each}
                        </div>

                        <div class="mt-4 space-y-2 rounded-2xl border border-white/20 bg-sky-950/30 p-3">
                            <p class="text-xs font-semibold tracking-[0.16em] text-cyan-100">CRM LOGIN FLOW</p>
                            {#each currentScene.flow as step, index (step)}
                                <div class="flow-item flex items-center gap-3 rounded-xl border border-white/15 bg-white/10 px-3 py-2 text-sm text-sky-50">
                                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/25 text-xs font-semibold text-white">
                                        {index + 1}
                                    </span>
                                    <span>{step}</span>
                                </div>
                            {/each}
                        </div>

                        <p class="mt-4 rounded-2xl border border-white/20 bg-sky-950/35 px-4 py-3 text-sm text-sky-50/95">
                            Aladdin CRM, Salesforce benzeri kurumsal is akislarini sade bir arayuzde hizli ve izlenebilir hale getirir.
                        </p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    .auth-title {
        font-family: 'Sora', 'Manrope', 'Segoe UI', sans-serif;
    }

    @keyframes floatSoft {
        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-7px);
        }
    }

    @keyframes pulseDot {
        0%,
        100% {
            opacity: 0.5;
            transform: scale(1);
        }

        50% {
            opacity: 1;
            transform: scale(1.14);
        }
    }

    @keyframes cardSlide {
        from {
            opacity: 0;
            transform: translateX(18px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .hero-panel {
        animation: floatSoft 6s ease-in-out infinite;
    }

    .scene-logo {
        animation: floatSoft 5.4s ease-in-out infinite;
    }

    .status-dot {
        width: 0.52rem;
        height: 0.52rem;
        border-radius: 999px;
        background: #f8fafc;
        box-shadow: 0 0 0.4rem rgba(255, 255, 255, 0.7);
        animation: pulseDot 1.8s ease-in-out infinite;
    }

    .status-dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .status-dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    .flow-item {
        animation: cardSlide 0.55s ease both;
    }

    .flow-item:nth-child(2) {
        animation-delay: 0.08s;
    }

    .flow-item:nth-child(3) {
        animation-delay: 0.16s;
    }

    .flow-item:nth-child(4) {
        animation-delay: 0.24s;
    }
</style>
