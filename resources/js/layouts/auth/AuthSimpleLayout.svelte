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
        metrics: Array<{
            label: string;
            value: string;
        }>;
        steps: Array<{
            title: string;
            description: string;
        }>;
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
            badge: 'ALADDIN CRM GUVENLIK',
            headline: 'Merkezi musteri yonetimi tek panelde.',
            summary: 'Guvenli kimlik dogrulama ile ekip, veri ve surec yonetimini ayni ekranda surdurun.',
            metrics: [
                { label: 'Canli Takip', value: '24/7' },
                { label: 'Otomatik Is Akisi', value: '%98' },
                { label: 'Yetkili Erisim', value: 'Rol Bazli' },
            ],
            steps: [
                { title: 'Kimlik Kontrolu', description: 'Kullanici bilgileri dogrulanir ve hesap durumu denetlenir.' },
                { title: 'Guvenlik Katmani', description: 'Sifre ve varsa iki adimli dogrulama birlikte islenir.' },
                { title: 'Oturum Acilisi', description: 'Guvenli oturum olusturulur ve panel verileri yuklenir.' },
            ],
        },
        login: {
            badge: 'GIRIS AKISI',
            headline: 'Giris yaparken arka planda neler oluyor?',
            summary: 'Tek sahnede sistemin yaptigi tum kritik adimlari canli akisla izleyin.',
            metrics: [
                { label: 'Oturum Suresi', value: '< 2 sn' },
                { label: 'Anlik Denetim', value: '%100' },
                { label: 'Veri Senkronu', value: 'Aninda' },
            ],
            steps: [
                { title: 'Kimlik Dogrulama', description: 'E-posta ve parola sifreli kanal uzerinden kontrol edilir.' },
                { title: 'Risk Taramasi', description: 'Supheli girisler cihaz ve oturum desenleriyle analiz edilir.' },
                { title: 'Yetki Yukleme', description: 'Rol bazli izinler ve ekip erisimleri sisteme uygulanir.' },
                { title: 'Dashboard Hazir', description: 'Pipeline, gorevler ve musteri kartlari ekrana getirilir.' },
            ],
        },
        register: {
            badge: 'HIZLI KAYIT',
            headline: 'Yeni ekip uye kaydi, kurumsal standartta.',
            summary: 'Kayit adimi tamamlandiginda hesap, guvenlik ve baslangic alanlari otomatik hazirlanir.',
            metrics: [
                { label: 'Kurulum', value: '< 1 dk' },
                { label: 'Hazir Moduller', value: '8+' },
                { label: 'Guvenlik Seviyesi', value: 'Yuksek' },
            ],
            steps: [
                { title: 'Hesap Olusturma', description: 'Kullanici temel bilgileri kaydedilir ve hesap olusturulur.' },
                { title: 'Guvenlik Profili', description: 'Sifre politikasi ve dogrulama kurallari atanir.' },
                { title: 'Calisma Alani', description: 'Varsayilan pipeline ve ekip alanlari otomatik acilir.' },
                { title: 'Sisteme Hazir', description: 'Kullanici paneli hemen kullanmaya baslayabilir.' },
            ],
        },
    };

    const currentScene = $derived(sceneMap[sceneType]);
    let activeStepIndex = $state(0);

    $effect(() => {
        activeStepIndex = 0;
        const totalSteps = currentScene.steps.length;

        const timer = setInterval(() => {
            activeStepIndex = (activeStepIndex + 1) % totalSteps;
        }, 2600);

        return () => clearInterval(timer);
    });
</script>

<div class="relative min-h-svh overflow-hidden bg-slate-950 text-slate-100">
    <div class="pointer-events-none absolute -top-24 -left-20 h-72 w-72 rounded-full bg-cyan-400/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-16 bottom-0 h-80 w-80 rounded-full bg-blue-500/20 blur-3xl"></div>

    <div class="relative mx-auto grid min-h-svh w-full max-w-7xl gap-5 p-4 sm:p-6 lg:grid-cols-[minmax(0,460px)_minmax(0,1fr)] lg:p-8">
        <section class="flex items-center">
            <div class="w-full rounded-3xl border border-slate-200 bg-white/95 p-6 text-slate-900 shadow-2xl backdrop-blur sm:p-8">
                <Link href={home()} class="mb-7 inline-flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-white shadow-lg">
                        <AppLogoIcon class="size-6 fill-current text-white" />
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-[0.16em] text-slate-500">ALADDIN CRM</p>
                        <p class="text-sm font-medium text-slate-900">Musteri ve Surec Yonetimi</p>
                    </div>
                </Link>

                <div class="mb-7 space-y-2">
                    <h1 class="text-2xl font-semibold tracking-tight">{title}</h1>
                    <p class="text-sm text-slate-600">{description}</p>
                </div>

                {@render children?.()}
            </div>
        </section>

        <aside class="relative hidden items-center lg:flex">
            <div class="relative w-full overflow-hidden rounded-3xl border border-white/20 bg-white/10 p-7 shadow-2xl backdrop-blur-2xl">
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(34,211,238,0.22),_transparent_55%)]"></div>
                <div class="pointer-events-none absolute right-8 bottom-8 h-48 w-48 rounded-full border border-white/10"></div>

                <div class="relative">
                    <p class="text-xs font-semibold tracking-[0.2em] text-cyan-200">{currentScene.badge}</p>
                    <h2 class="mt-3 text-3xl leading-tight font-semibold text-white">{currentScene.headline}</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-200/85">{currentScene.summary}</p>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        {#each currentScene.metrics as metric, index (metric.label)}
                            <div
                                class="scene-float rounded-2xl border border-white/15 bg-slate-900/40 p-3"
                                style={`animation-delay: ${index * 200}ms;`}
                            >
                                <p class="text-xs tracking-[0.14em] text-slate-300">{metric.label}</p>
                                <p class="mt-1 text-lg font-semibold text-cyan-200">{metric.value}</p>
                            </div>
                        {/each}
                    </div>

                    <div class="mt-6 overflow-hidden rounded-2xl border border-white/15 bg-slate-900/60">
                        <div class="flex items-center gap-2 border-b border-white/10 px-4 py-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-rose-400"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-300"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                            <p class="ml-auto text-xs tracking-[0.16em] text-slate-300">CANLI PANEL ONIZLEME</p>
                        </div>
                        <div class="relative p-4">
                            <div class="scene-scan pointer-events-none absolute inset-x-4 top-0 h-12 rounded-2xl bg-linear-to-b from-cyan-300/20 to-transparent"></div>

                            <div class="grid gap-3">
                                <div class="rounded-xl border border-cyan-200/20 bg-cyan-200/10 p-3">
                                    <p class="text-xs text-cyan-100/80">Pipeline Durumu</p>
                                    <p class="mt-1 text-sm font-medium text-cyan-100">12 yeni musteri adayi hareket etti.</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="rounded-xl border border-white/10 bg-white/5 p-3">
                                        <p class="text-xs text-slate-300">Takvim</p>
                                        <p class="mt-1 text-sm font-medium text-white">8 toplanti bugun aktif.</p>
                                    </div>
                                    <div class="rounded-xl border border-white/10 bg-white/5 p-3">
                                        <p class="text-xs text-slate-300">Destek Talepleri</p>
                                        <p class="mt-1 text-sm font-medium text-white">3 oncelikli islem bekliyor.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-white/15 bg-slate-900/55 p-4">
                        <p class="text-xs font-semibold tracking-[0.18em] text-slate-300">ARKA PLAN ISLEYISI</p>
                        <div class="mt-3 space-y-2.5">
                            {#each currentScene.steps as step, index (step.title)}
                                <div
                                    class="process-step flex items-center gap-3 rounded-xl border border-white/10 px-3 py-2.5 transition-all duration-300 {index === activeStepIndex
                                        ? 'process-step--active'
                                        : ''}"
                                >
                                    <div class="step-dot flex h-7 w-7 items-center justify-center rounded-full text-xs font-semibold">
                                        {index + 1}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">{step.title}</p>
                                        <p class="truncate text-xs text-slate-300">{step.description}</p>
                                    </div>
                                    <span class="scene-glow h-2 w-2 rounded-full bg-emerald-300"></span>
                                </div>
                            {/each}
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
            transform: translateY(-5px);
        }
    }

    @keyframes scanLine {
        0% {
            transform: translateY(-130%);
        }

        100% {
            transform: translateY(230%);
        }
    }

    @keyframes glowPulse {
        0%,
        100% {
            opacity: 0.45;
            transform: scale(0.95);
        }

        50% {
            opacity: 1;
            transform: scale(1.1);
        }
    }

    .scene-float {
        animation: floatCard 7s ease-in-out infinite;
    }

    .scene-scan {
        animation: scanLine 4.5s linear infinite;
    }

    .scene-glow {
        animation: glowPulse 2.2s ease-in-out infinite;
    }

    .process-step--active {
        border-color: rgb(34 211 238 / 0.58);
        background-color: rgb(8 47 73 / 0.55);
    }

    .step-dot {
        background-color: rgb(51 65 85 / 0.7);
        color: rgb(226 232 240);
    }

    .process-step--active .step-dot {
        background-color: rgb(6 182 212 / 0.35);
        color: rgb(207 250 254);
    }
</style>
