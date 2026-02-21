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
            headline: 'Kurumsal musteri yonetimi tek panelde',
            summary: 'Satis, operasyon ve destek ekipleri ayni CRM omurgasi uzerinde birlikte calisir.',
            highlights: ['Musteri 360', 'Pipeline Takibi', 'Otomatik Gorevler'],
        },
        login: {
            badge: 'GUVENLI GIRIS',
            headline: 'Hesabiniza guvenli sekilde baglanin',
            summary: 'Yetkilendirme katmani ile ekip erisimleri guvenli dogrulama adimlarindan gecerek acilir.',
            highlights: ['Rol Bazli Erisim', 'Guvenli Oturum', 'Canli Veri Akisi'],
        },
        register: {
            badge: 'HIZLI BASLANGIC',
            headline: 'Dakikalar icinde CRM ortamina gecin',
            summary: 'Yeni hesap olusturulduktan sonra kurumsal is akislari ve ekip calisma alanlari otomatik hazirlanir.',
            highlights: ['Hazir Moduller', 'Anlik Kurulum', 'Esnek Yetkilendirme'],
        },
    };

    const currentScene = $derived(sceneMap[sceneType]);
</script>

<div class="relative min-h-svh overflow-hidden bg-slate-950 text-slate-100">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(34,211,238,0.16),_transparent_48%)]"></div>
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.16),_transparent_52%)]"></div>

    <div class="relative mx-auto grid min-h-svh w-full max-w-7xl gap-5 p-4 sm:p-6 lg:grid-cols-[minmax(0,460px)_minmax(0,1fr)] lg:p-8">
        <section class="flex items-center">
            <div class="w-full rounded-3xl border border-slate-200 bg-white/95 p-6 text-slate-900 shadow-2xl backdrop-blur sm:p-8">
                <Link href={home()} class="mb-7 inline-flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm">
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
                    <h1 class="text-2xl font-semibold tracking-tight">{title}</h1>
                    <p class="text-sm text-slate-600">{description}</p>
                </div>

                {@render children?.()}
            </div>
        </section>

        <aside class="relative hidden items-center lg:flex">
            <div class="relative w-full overflow-hidden rounded-3xl border border-white/20 bg-slate-900/75 p-8 shadow-2xl backdrop-blur-2xl">
                <div class="pointer-events-none absolute -top-24 -right-24 h-56 w-56 rounded-full bg-cyan-300/20 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-24 -left-24 h-56 w-56 rounded-full bg-blue-400/20 blur-3xl"></div>

                <div class="relative space-y-4">
                    <p class="text-xs font-semibold tracking-[0.2em] text-cyan-200">{currentScene.badge}</p>
                    <h2 class="text-3xl leading-tight font-semibold text-white">{currentScene.headline}</h2>
                    <p class="max-w-2xl text-sm leading-6 text-slate-200">{currentScene.summary}</p>

                    <div class="logo-canvas relative mt-6 overflow-hidden rounded-3xl border border-white/15 bg-white/6 p-6">
                        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(125,211,252,0.28),_transparent_60%)]"></div>
                        <div class="relative flex flex-col items-center gap-5 text-center">
                            <img
                                src="/brand/aladdin-crm-logo.svg"
                                alt="Aladdin CRM"
                                class="h-28 w-auto object-contain"
                                loading="lazy"
                                decoding="async"
                            />

                            <div class="grid w-full gap-2 sm:grid-cols-3">
                                {#each currentScene.highlights as highlight (highlight)}
                                    <div class="rounded-2xl border border-cyan-200/20 bg-slate-950/45 px-3 py-2 text-xs font-medium text-cyan-100">
                                        {highlight}
                                    </div>
                                {/each}
                            </div>

                            <p class="max-w-md rounded-2xl border border-white/10 bg-slate-900/65 px-4 py-3 text-sm text-slate-200">
                                Aladdin CRM ile firma genelindeki satis, teklif, musteri destek ve operasyon surecleri tek
                                bir merkezde yonetilir.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    @keyframes floatCard {
        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-6px);
        }
    }

    .logo-canvas {
        animation: floatCard 6.2s ease-in-out infinite;
    }
</style>
