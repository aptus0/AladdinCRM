<script lang="ts">
    import { onMount } from 'svelte';
    import { Link } from '@inertiajs/svelte';
    import Activity from 'lucide-svelte/icons/activity';
    import ArrowRight from 'lucide-svelte/icons/arrow-right';
    import BadgeCheck from 'lucide-svelte/icons/badge-check';
    import Briefcase from 'lucide-svelte/icons/briefcase';
    import Building2 from 'lucide-svelte/icons/building-2';
    import FileText from 'lucide-svelte/icons/file-text';
    import GalleryHorizontal from 'lucide-svelte/icons/gallery-horizontal';
    import Gauge from 'lucide-svelte/icons/gauge';
    import Headset from 'lucide-svelte/icons/headset';
    import History from 'lucide-svelte/icons/history';
    import Images from 'lucide-svelte/icons/images';
    import LockKeyhole from 'lucide-svelte/icons/lock-keyhole';
    import LogIn from 'lucide-svelte/icons/log-in';
    import ShieldCheck from 'lucide-svelte/icons/shield-check';
    import Sparkles from 'lucide-svelte/icons/sparkles';
    import UserRound from 'lucide-svelte/icons/user-round';
    import Users from 'lucide-svelte/icons/users';
    import Zap from 'lucide-svelte/icons/zap';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import CorporateLayout from '@/layouts/CorporateLayout.svelte';
    import { login, register } from '@/routes';

    type IconLike = any;

    type TrustItem = {
        title: string;
        description: string;
        icon: IconLike;
    };

    type FeatureItem = {
        key: string;
        title: string;
        description: string;
        icon: IconLike;
    };

    type StepItem = {
        title: string;
        description: string;
        icon: IconLike;
    };

    type UseCaseItem = {
        title: string;
        description: string;
        icon: IconLike;
    };

    type WhyCrmItem = {
        title: string;
        description: string;
        icon: IconLike;
    };

    type ProblemSolutionItem = {
        problem: string;
        impact: string;
        solution: string;
    };

    type ScreenItem = {
        key: string;
        title: string;
        description: string;
        src: string;
        alt: string;
    };

    type HeroStat = {
        label: string;
        value: string;
    };

    type Particle = {
        x: number;
        y: number;
        r: number;
        vx: number;
        vy: number;
        alpha: number;
        twinkle: number;
    };

    let {
        canRegister = true,
    }: {
        canRegister?: boolean;
    } = $props();

    const heroWords = [
        'Alladdin',
        'CRM',
        'ile',
        'musteri,',
        'satis',
        've',
        'destek',
        'operasyonunu',
        'tek',
        'panelde',
        'yonetin.',
    ];

    const heroStats: HeroStat[] = [
        { label: 'Aktif company', value: '124+' },
        { label: 'Aylik pipeline', value: 'TRY 3.2M' },
        { label: 'Ticket SLA', value: '%97' },
        { label: 'Tek panelde modul', value: '6' },
    ];

    const trustItems: TrustItem[] = [
        {
            title: 'Hizli Kurulum',
            description: 'Ilk ekip hesabini ac, rollerini belirle ve ayni gun icinde canliya gec.',
            icon: Zap,
        },
        {
            title: 'Guvenli Altyapi',
            description: 'Role-based access, activity log ve kontrol edilebilir API akisiyla guvenli operasyon.',
            icon: ShieldCheck,
        },
        {
            title: 'Olceklenebilir Yapi',
            description: 'Kucuk ekipten buyuyen satis organizasyonuna kadar ayni veri duzeniyle ilerler.',
            icon: Gauge,
        },
    ];

    const featureItems: FeatureItem[] = [
        {
            key: 'quote',
            title: 'Quote PDF',
            description: 'Kalem bazli teklif hazirla, indirim/KDV hesapla ve marka formatinda PDF olustur.',
            icon: FileText,
        },
        {
            key: 'pipeline',
            title: 'Pipeline',
            description: 'Lead, Qualified, Proposal ve Negotiation asamalarinda firsatlarini net takip et.',
            icon: Briefcase,
        },
        {
            key: 'kanban',
            title: 'Task Kanban',
            description: 'Gorevleri surukle-birak ile sirala, sorumluyu degistir ve terminleri kacirma.',
            icon: Activity,
        },
        {
            key: 'ticket',
            title: 'Ticket Yonetimi',
            description: 'Acik, beklemede ve kapali talepleri SLA odakli tek mesaj akisinda yonet.',
            icon: Headset,
        },
        {
            key: 'audit',
            title: 'Activity Log',
            description: 'Kim, neyi, ne zaman degistirdi sorusuna denetlenebilir ve geriye donuk yanit ver.',
            icon: History,
        },
        {
            key: 'access',
            title: 'Role-based Access',
            description: 'Admin ve Staff rollerine gore goruntuleme, duzenleme ve onay yetkilerini ayir.',
            icon: LockKeyhole,
        },
    ];

    const steps: StepItem[] = [
        {
            title: 'Musteriyi Ekle',
            description: 'Company ve Contact kayitlarini tek formda ac, not ve baglantilarla zenginlestir.',
            icon: UserRound,
        },
        {
            title: 'Firsat Ac',
            description: 'Opportunity kaydini tutar, kapanis tarihi ve stage bilgisiyle anlik takip et.',
            icon: Briefcase,
        },
        {
            title: 'Teklif & PDF Gonder',
            description: 'Quote olustur, PDF disa aktar ve musteriye profesyonel formatta ilet.',
            icon: FileText,
        },
    ];

    const useCases: UseCaseItem[] = [
        {
            title: 'Ajanslar',
            description: 'Coklu musteri portfoyunu, teklifleri ve destek taleplerini tek panelde toplar.',
            icon: Users,
        },
        {
            title: 'Freelancerlar',
            description: 'Kisisel operasyonunu kurumsal surece cevirir; teklif, gorev ve ticketi duzenli tutar.',
            icon: Sparkles,
        },
        {
            title: 'Kucuk Isletmeler',
            description: 'Satis, operasyon ve musteri destegi ekiplerini ortak veri modeliyle hizalar.',
            icon: Building2,
        },
    ];

    const whyCrmItems: WhyCrmItem[] = [
        {
            title: 'Daginik Veriye Son',
            description: 'Excel, WhatsApp ve e-posta yerine tum musteri kayitlarini tek yerde toplar.',
            icon: Users,
        },
        {
            title: 'Tahmin Edilebilir Satis',
            description: 'Pipeline asamalari sayesinde hangi firsatin ne zaman kapanacagi netlesir.',
            icon: Briefcase,
        },
        {
            title: 'Hizli Destek Donusu',
            description: 'Ticket ve mesaj akisiyla destek sureci olculebilir ve izlenebilir olur.',
            icon: Headset,
        },
        {
            title: 'Yonetilebilir Is Yuku',
            description: 'Kanban gorev yapisi ekip icindeki is dagilimini gorunur hale getirir.',
            icon: Activity,
        },
    ];

    const problemSolutionItems: ProblemSolutionItem[] = [
        {
            problem: 'Musteri kayitlari farkli araclarda tutuluyor',
            impact: 'Teklif hazirlama suresi uzuyor ve gecikmeli geri donusler olusuyor.',
            solution: 'Company + Contact yapisi ile tum musteri baglamini tek profil altinda toplar.',
        },
        {
            problem: 'Satis firsatlari takip edilemiyor',
            impact: 'Pipeline gorunmedigi icin tahmini gelir ve kapanis tarihi sapmasi artiyor.',
            solution: 'Opportunity stage akisiyla firsatlar lead den won asamasina kadar izleniyor.',
        },
        {
            problem: 'Destek talepleri kayboluyor',
            impact: 'SLA ihlalleri artiyor, musteri memnuniyeti ve ekip performansi dusuyor.',
            solution: 'Ticket + mesaj akisi ile her talep kayit altina alinip olculebilir hale geliyor.',
        },
    ];

    const screens: ScreenItem[] = [
        {
            key: 'dashboard',
            title: 'Dashboard',
            description: 'Gercek zamanli KPI, pipeline ve gunluk is listesi',
            src: '/images/landing/dashboard-overview.svg',
            alt: 'Alladdin CRM dashboard gorunumu',
        },
        {
            key: 'quotes',
            title: 'Quotes + PDF',
            description: 'Teklif kalemleri, toplam hesaplama ve PDF cikti akisi',
            src: '/images/landing/quotes-pdf.svg',
            alt: 'Alladdin CRM quote PDF gorunumu',
        },
        {
            key: 'kanban',
            title: 'Task Kanban',
            description: 'Surekli takip icin drag-drop task board deneyimi',
            src: '/images/landing/tasks-kanban.svg',
            alt: 'Alladdin CRM kanban gorunumu',
        },
        {
            key: 'tickets',
            title: 'Ticket Support',
            description: 'SLA odakli destek kutusu ve mesajlasma ekrani',
            src: '/images/landing/tickets-support.svg',
            alt: 'Alladdin CRM ticket gorunumu',
        },
    ];

    let activeScreen = $state(0);
    let heroTitleElement: HTMLElement | null = null;
    let heroMockElement: HTMLDivElement | null = null;
    let sparkleCanvas: HTMLCanvasElement | null = null;
    let reducedMotion = false;

    let autoSlideTimer: ReturnType<typeof setInterval> | null = null;
    let revealObserver: IntersectionObserver | null = null;

    function setActiveScreen(index: number): void {
        const safeIndex = ((index % screens.length) + screens.length) % screens.length;
        activeScreen = safeIndex;
    }

    function nextScreen(): void {
        setActiveScreen(activeScreen + 1);
    }

    function previousScreen(): void {
        setActiveScreen(activeScreen - 1);
    }

    function stopAutoSlide(): void {
        if (!autoSlideTimer) {
            return;
        }

        clearInterval(autoSlideTimer);
        autoSlideTimer = null;
    }

    function startAutoSlide(): void {
        if (reducedMotion || autoSlideTimer) {
            return;
        }

        autoSlideTimer = setInterval(() => {
            nextScreen();
        }, 4200);
    }

    function initializeRevealAnimations(): (() => void) | null {
        const revealItems = Array.from(document.querySelectorAll<HTMLElement>('[data-reveal]'));

        if (revealItems.length === 0) {
            return null;
        }

        if (reducedMotion) {
            for (const item of revealItems) {
                item.classList.add('is-visible');
            }

            return null;
        }

        revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const element = entry.target as HTMLElement;
                    element.classList.add('is-visible');
                    revealObserver?.unobserve(element);
                });
            },
            {
                root: null,
                threshold: 0.18,
                rootMargin: '0px 0px -5% 0px',
            },
        );

        revealItems.forEach((item) => revealObserver?.observe(item));

        return () => {
            revealObserver?.disconnect();
            revealObserver = null;
        };
    }

    function scrollToScreens(): void {
        const element = document.getElementById('ekranlar');
        if (!element) {
            return;
        }

        element.scrollIntoView({
            behavior: reducedMotion ? 'auto' : 'smooth',
            block: 'start',
        });
    }

    function runHeroStaggerAnimation(): void {
        if (!heroTitleElement) {
            return;
        }

        const words = Array.from(
            heroTitleElement.querySelectorAll<HTMLElement>('[data-hero-word]'),
        );

        if (reducedMotion) {
            for (const word of words) {
                word.style.opacity = '1';
                word.style.transform = 'translateY(0)';
            }

            return;
        }

        words.forEach((word, index) => {
            word.animate(
                [
                    { opacity: 0, transform: 'translateY(18px)' },
                    { opacity: 1, transform: 'translateY(0)' },
                ],
                {
                    duration: 620,
                    delay: index * 74,
                    easing: 'cubic-bezier(0.16, 1, 0.3, 1)',
                    fill: 'forwards',
                },
            );
        });
    }

    function initializeSparkles(): (() => void) | null {
        if (!sparkleCanvas || reducedMotion) {
            return null;
        }

        const canvas = sparkleCanvas;
        const context = canvas.getContext('2d');

        if (!context) {
            return null;
        }

        let animationFrame = 0;
        const particles: Particle[] = [];

        const spawnParticle = (width: number, height: number, fromBottom = false): Particle => ({
            x: Math.random() * width,
            y: fromBottom ? height + Math.random() * 80 : Math.random() * height,
            r: 0.7 + Math.random() * 1.7,
            vx: -0.12 + Math.random() * 0.24,
            vy: -0.2 - Math.random() * 0.38,
            alpha: 0.2 + Math.random() * 0.55,
            twinkle: Math.random() * Math.PI * 2,
        });

        const resizeCanvas = (): void => {
            const { width, height } = canvas.getBoundingClientRect();
            const ratio = window.devicePixelRatio || 1;

            canvas.width = Math.max(1, Math.floor(width * ratio));
            canvas.height = Math.max(1, Math.floor(height * ratio));
            context.setTransform(ratio, 0, 0, ratio, 0, 0);

            particles.length = 0;
            const particleCount = 30;
            for (let index = 0; index < particleCount; index += 1) {
                particles.push(spawnParticle(width, height));
            }
        };

        const drawFrame = (): void => {
            const width = canvas.clientWidth;
            const height = canvas.clientHeight;

            context.clearRect(0, 0, width, height);

            particles.forEach((particle, index) => {
                particle.x += particle.vx;
                particle.y += particle.vy;
                particle.twinkle += 0.06;

                if (particle.y < -16 || particle.x < -16 || particle.x > width + 16) {
                    particles[index] = spawnParticle(width, height, true);
                    return;
                }

                const alpha = particle.alpha * (0.6 + Math.sin(particle.twinkle) * 0.4);
                context.beginPath();
                context.fillStyle = `rgba(255,255,255,${Math.max(0.08, alpha)})`;
                context.arc(particle.x, particle.y, particle.r, 0, Math.PI * 2);
                context.fill();
            });

            animationFrame = window.requestAnimationFrame(drawFrame);
        };

        resizeCanvas();
        drawFrame();
        window.addEventListener('resize', resizeCanvas);

        return () => {
            window.cancelAnimationFrame(animationFrame);
            window.removeEventListener('resize', resizeCanvas);
            context.clearRect(0, 0, canvas.clientWidth, canvas.clientHeight);
        };
    }

    onMount(() => {
        reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        runHeroStaggerAnimation();
        startAutoSlide();

        const cleanupSparkles = initializeSparkles();
        const cleanupReveal = initializeRevealAnimations();

        const handlePointerEnter = (): void => stopAutoSlide();
        const handlePointerLeave = (): void => startAutoSlide();

        heroMockElement?.addEventListener('pointerenter', handlePointerEnter);
        heroMockElement?.addEventListener('pointerleave', handlePointerLeave);

        return () => {
            stopAutoSlide();
            cleanupSparkles?.();
            cleanupReveal?.();
            heroMockElement?.removeEventListener('pointerenter', handlePointerEnter);
            heroMockElement?.removeEventListener('pointerleave', handlePointerLeave);
        };
    });
</script>

<AppHead title="Alladdin CRM - Satis ve Destek Platformu" />

<CorporateLayout {canRegister}>
    <div class="landing-surface relative overflow-hidden">
        <canvas bind:this={sparkleCanvas} class="sparkle-layer pointer-events-none absolute inset-0 z-0" aria-hidden="true"></canvas>
        <div class="gold-line gold-line-one pointer-events-none absolute -left-24 top-20 z-0 h-[2px] w-[30rem] rotate-12"></div>
        <div class="gold-line gold-line-two pointer-events-none absolute right-[-6rem] top-[18rem] z-0 h-[2px] w-[22rem] -rotate-12"></div>
        <div class="smoke-layer smoke-one pointer-events-none absolute -top-30 left-[-14rem] z-0 h-96 w-96 rounded-full"></div>
        <div class="smoke-layer smoke-two pointer-events-none absolute top-70 right-[-16rem] z-0 h-[30rem] w-[30rem] rounded-full"></div>
        <div class="smoke-layer smoke-three pointer-events-none absolute bottom-[-10rem] left-[28%] z-0 h-[26rem] w-[26rem] rounded-full"></div>

        <section data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pt-14 pb-14 sm:px-6 lg:pt-20 lg:pb-20">
            <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div class="space-y-7">
                    <span class="inline-flex rounded-full border border-violet-300/60 bg-violet-300/10 px-3 py-1 text-xs font-semibold tracking-[0.14em] text-violet-100">
                        ALLADDIN CRM | MODERN CRM PLATFORM
                    </span>

                    <h1 bind:this={heroTitleElement} class="hero-title text-4xl leading-tight font-semibold tracking-tight text-slate-50 sm:text-5xl">
                        {#each heroWords as word, index (index)}
                            <span class="hero-word" data-hero-word>{word}</span>{' '}
                        {/each}
                    </h1>

                    <p class="max-w-2xl text-base leading-7 text-slate-100 sm:text-lg">
                        Musteri iliskileri, satis firsatlari, teklifler ve destek operasyonunu tek panelde birlestir.
                        Alladdin CRM, kucuk ekiplerin duzenli ve olceklenebilir calismasi icin tasarlandi.
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <Button
                            size="lg"
                            class="rounded-full bg-amber-300 px-7 text-violet-950 shadow-[0_14px_30px_-18px_rgba(245,158,11,0.9)] hover:bg-amber-200"
                            onclick={scrollToScreens}
                        >
                            Canli demoyu incele
                        </Button>

                        <Link href={login()}>
                            <Button size="lg" variant="outline" class="rounded-full border-slate-300/70 bg-white/10 px-7 text-white hover:bg-white/20">
                                <LogIn class="mr-2 size-4" />
                                Giris paneli
                            </Button>
                        </Link>

                        {#if canRegister}
                            <Link href={register()}>
                                <Button size="lg" variant="outline" class="rounded-full border-slate-300/70 bg-white/5 px-7 text-slate-100 hover:bg-white/10">
                                    Hemen hesap ac
                                </Button>
                            </Link>
                        {/if}
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        {#each heroStats as stat (stat.label)}
                            <article class="rounded-2xl border border-white/18 bg-white/10 px-4 py-3 backdrop-blur">
                                <p class="text-[11px] font-medium tracking-[0.08em] text-slate-200 uppercase">{stat.label}</p>
                                <p class="mt-1 text-lg font-semibold text-white">{stat.value}</p>
                            </article>
                        {/each}
                    </div>
                </div>

                <div
                    bind:this={heroMockElement}
                    class="relative rounded-3xl border border-violet-200/70 bg-white/95 p-4 shadow-[0_28px_90px_-38px_rgba(124,58,237,0.58)] backdrop-blur"
                >
                    <div class="browser-frame overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <div class="flex items-center gap-2 border-b border-slate-200 bg-slate-50 px-4 py-2.5">
                            <span class="h-2.5 w-2.5 rounded-full bg-red-400"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-violet-400"></span>
                            <span class="ml-2 rounded-full border border-slate-200 bg-white px-3 py-0.5 text-[11px] text-slate-500">
                                app.alladdincrm.test/dashboard
                            </span>
                        </div>

                        <img
                            src={screens[activeScreen].src}
                            alt={screens[activeScreen].alt}
                            class="hero-shot floating-screen h-auto w-full object-cover"
                            decoding="async"
                            loading="eager"
                        />
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{screens[activeScreen].title}</p>
                            <p class="text-xs text-slate-600">{screens[activeScreen].description}</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="rounded-full border border-violet-200 bg-white px-3 py-1.5 text-xs font-medium text-violet-800 hover:bg-violet-50"
                                onclick={previousScreen}
                                aria-label="Onceki ekran"
                            >
                                Onceki
                            </button>
                            <button
                                type="button"
                                class="rounded-full border border-violet-700 bg-violet-700 px-3 py-1.5 text-xs font-medium text-white hover:bg-violet-600"
                                onclick={nextScreen}
                                aria-label="Sonraki ekran"
                            >
                                Sonraki
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pb-8 sm:px-6">
            <div class="section-pop rounded-2xl border border-slate-200/80 bg-white/90 p-4 backdrop-blur sm:p-6">
                <p class="eyebrow mb-2 text-xs font-semibold tracking-[0.14em] text-violet-700">TRUSTED FRAMEWORK</p>
                <p class="section-text mb-4 text-sm font-medium text-slate-700">
                    Ilk gunden itibaren kontrollu, guvenli ve olceklenebilir kullanim
                </p>
                <div class="grid gap-4 md:grid-cols-3">
                    {#each trustItems as item (item.title)}
                        <article class="pop-tile rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                            <div class="mb-2 inline-flex rounded-lg border border-amber-200 bg-amber-100 p-2 text-amber-700">
                                <item.icon class="size-4" />
                            </div>
                            <h2 class="section-title text-sm font-semibold text-slate-900">{item.title}</h2>
                            <p class="section-muted mt-1 text-xs leading-5 text-slate-600">{item.description}</p>
                        </article>
                    {/each}
                </div>
            </div>
        </section>

        <section data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pt-6 pb-8 sm:px-6">
            <div class="section-pop rounded-3xl border border-violet-200/70 p-6 sm:p-8">
                <div class="grid gap-7 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div>
                        <p class="eyebrow text-xs font-semibold tracking-[0.14em]">NEDEN CRM?</p>
                        <h2 class="section-title mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">
                            Duzensiz operasyon, buyume hizini dusurur
                        </h2>
                        <p class="section-text mt-3 max-w-2xl text-sm leading-6 sm:text-base">
                            Ekip buyudukce musteri bilgisinin daginik kalmasi, satis firsatlarinin kacmasi ve
                            destek taleplerinin gecikmesi daha sik gorulur. CRM kullanimi, bu surecleri olculebilir
                            hale getirerek karar almayi hizlandirir.
                        </p>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            {#each whyCrmItems as item (item.title)}
                                <article class="pop-tile rounded-2xl border border-violet-200/60 p-4">
                                    <div class="mb-2 inline-flex rounded-lg border border-amber-200 bg-amber-100/90 p-2 text-amber-700">
                                        <item.icon class="size-4" />
                                    </div>
                                    <h3 class="section-title text-sm font-semibold">{item.title}</h3>
                                    <p class="section-muted mt-1 text-xs leading-5">{item.description}</p>
                                </article>
                            {/each}
                        </div>
                    </div>

                    <div class="pop-tile globe-card rounded-3xl border border-violet-200/60 p-5 sm:p-6">
                        <div class="globe-stage mx-auto">
                            <div class="globe">
                                <span class="globe-ring globe-ring-a"></span>
                                <span class="globe-ring globe-ring-b"></span>
                                <span class="globe-ring globe-ring-c"></span>
                            </div>
                            <div class="globe-shadow"></div>
                        </div>

                        <p class="section-text mt-5 text-sm leading-6">
                            CRM sadece kayit tutmak degil, ekipler arasi senkronizasyonu kurmaktir.
                            Alladdin CRM ile satis, operasyon ve destek birimleri ayni veri dilinde calisir.
                        </p>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    {#each problemSolutionItems as item (item.problem)}
                        <article class="pop-tile rounded-2xl border border-violet-200/60 p-5">
                            <p class="eyebrow text-[11px] font-semibold tracking-[0.14em]">PROBLEM</p>
                            <h3 class="section-title mt-2 text-base font-semibold">{item.problem}</h3>
                            <p class="section-muted mt-3 text-xs leading-5">
                                <span class="font-semibold">Etkisi:</span> {item.impact}
                            </p>
                            <p class="section-text mt-3 text-xs leading-5">
                                <span class="solution-label font-semibold">Alladdin cozum:</span> {item.solution}
                            </p>
                        </article>
                    {/each}
                </div>
            </div>
        </section>

        <section data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pt-8 pb-8 sm:px-6">
            <div class="mb-5 flex items-end justify-between gap-3">
                <div>
                    <p class="eyebrow text-xs font-semibold tracking-[0.14em] text-violet-700">FEATURES</p>
                    <h2 class="section-title mt-2 text-2xl font-semibold tracking-tight text-slate-900">
                        Satistan destege tum surecler tek platformda
                    </h2>
                </div>
                <span class="section-muted hidden text-sm text-slate-500 md:inline">Company + Opportunity + Quote + Task + Ticket + Log</span>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                {#each featureItems as feature (feature.key)}
                    <article class="feature-card pop-tile group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-violet-300 hover:shadow-lg">
                        <div class="mb-3 inline-flex rounded-lg border border-violet-200 bg-violet-100 p-2 text-violet-700 transition-colors group-hover:border-violet-300 group-hover:bg-violet-200">
                            <feature.icon class="size-4" />
                        </div>
                        <h3 class="section-title text-base font-semibold text-slate-900">{feature.title}</h3>
                        <p class="section-muted mt-2 text-sm leading-6 text-slate-600">{feature.description}</p>

                        {#if feature.key === 'quote'}
                            <div class="quote-mini mt-4 rounded-xl border border-rose-200/70 bg-rose-50/70 p-3">
                                <div class="mb-2 flex items-center justify-between">
                                    <p class="text-xs font-semibold text-rose-800">Canli quote onizleme</p>
                                    <span class="rounded-full bg-rose-200 px-2 py-0.5 text-[10px] font-semibold text-rose-700">LIVE</span>
                                </div>
                                <div class="quote-sheet rounded-lg border border-rose-200 bg-white p-2">
                                    <div class="mb-1 h-2.5 w-24 rounded bg-rose-200"></div>
                                    <div class="mb-1 h-2 w-full rounded bg-rose-100"></div>
                                    <div class="mb-1 h-2 w-[86%] rounded bg-rose-100"></div>
                                    <div class="h-2 w-[70%] rounded bg-rose-100"></div>
                                </div>
                            </div>
                        {/if}
                    </article>
                {/each}
            </div>
        </section>

        <section data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pt-10 pb-8 sm:px-6">
            <div class="section-pop rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-sm sm:p-8">
                <p class="eyebrow text-xs font-semibold tracking-[0.14em] text-violet-700">HOW IT WORKS</p>
                <h2 class="section-title mt-2 text-2xl font-semibold tracking-tight text-slate-900">3 adimda operasyonu canliya al</h2>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    {#each steps as step, index (step.title)}
                        <article class="pop-tile rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="mb-3 flex items-center justify-between">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-violet-700 text-xs font-semibold text-white">
                                    {index + 1}
                                </span>
                                <step.icon class="size-4 text-violet-700" />
                            </div>
                            <h3 class="section-title text-sm font-semibold text-slate-900">{step.title}</h3>
                            <p class="section-muted mt-1 text-xs leading-5 text-slate-600">{step.description}</p>
                        </article>
                    {/each}
                </div>
            </div>
        </section>

        <section id="ekranlar" data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pt-10 pb-8 sm:px-6">
            <div class="mb-5 flex items-end justify-between gap-3">
                <div>
                    <p class="eyebrow text-xs font-semibold tracking-[0.14em] text-violet-700">APP SCREENSHOTS</p>
                    <h2 class="section-title mt-2 text-2xl font-semibold tracking-tight text-slate-900">
                        Gercek operasyon verileriyle urun ekranlari
                    </h2>
                </div>
                <div class="section-text inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs text-slate-600">
                    <GalleryHorizontal class="size-3.5" />
                    4 ekranlik canli slider
                </div>
            </div>

            <div class="section-pop rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="browser-frame overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    <div class="flex items-center gap-2 border-b border-slate-200 bg-slate-50 px-4 py-2.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-400"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-violet-400"></span>
                        <span class="ml-2 text-[11px] text-slate-500">Alladdin CRM | {screens[activeScreen].title}</span>
                    </div>

                    <div class="overflow-hidden">
                        <img
                            src={screens[activeScreen].src}
                            alt={screens[activeScreen].alt}
                            class="gallery-shot h-auto w-full object-cover"
                            decoding="async"
                        />
                    </div>
                </div>

                <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    {#each screens as screen, index (screen.key)}
                        <button
                            type="button"
                            class="group rounded-xl border p-2 text-left transition {index === activeScreen
                                ? 'border-violet-400 bg-violet-50'
                                : 'border-slate-200 bg-white hover:border-violet-300 hover:bg-violet-50/40'}"
                            onclick={() => setActiveScreen(index)}
                        >
                            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                <img
                                    src={screen.src}
                                    alt={screen.alt}
                                    class="thumb-shot h-20 w-full object-cover"
                                    decoding="async"
                                    loading="lazy"
                                />
                            </div>
                            <p class="section-title mt-2 text-xs font-semibold text-slate-900">{screen.title}</p>
                            <p class="section-muted text-[11px] text-slate-600">{screen.description}</p>
                        </button>
                    {/each}
                </div>
            </div>
        </section>

        <section data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pt-10 pb-8 sm:px-6">
            <div class="mb-5">
                <p class="eyebrow text-xs font-semibold tracking-[0.14em] text-violet-700">USE CASES</p>
                <h2 class="section-title mt-2 text-2xl font-semibold tracking-tight text-slate-900">
                    Hangi ekipler icin en uygun?
                </h2>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                {#each useCases as item (item.title)}
                    <article class="pop-tile rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="mb-3 inline-flex rounded-lg border border-violet-200 bg-violet-50 p-2 text-violet-700">
                            <item.icon class="size-4" />
                        </div>
                        <h3 class="section-title text-base font-semibold text-slate-900">{item.title}</h3>
                        <p class="section-muted mt-2 text-sm leading-6 text-slate-600">{item.description}</p>
                    </article>
                {/each}
            </div>
        </section>

        <section data-reveal class="reveal-item relative z-10 mx-auto w-full max-w-7xl px-4 pt-10 pb-12 sm:px-6">
            <div class="cta-banner overflow-hidden rounded-3xl border border-violet-200 bg-[linear-gradient(140deg,#261447,#48207f_52%,#6d28d9)] px-6 py-8 text-white sm:px-8">
                <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <p class="text-xs font-semibold tracking-[0.16em] text-amber-200">TRY ALLADDIN CRM</p>
                        <h2 class="mt-2 text-2xl font-semibold tracking-tight">Demo ortami ile ayni gun kullanmaya basla</h2>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-200">
                            Satis ve destek sureclerini tek panelde gor, quote PDF akislarini test et ve ekibin icin
                            hazir operasyon iskeletini hemen devreye al.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <Link href={login()}>
                            <Button size="lg" class="rounded-full bg-amber-300 px-7 text-violet-950 hover:bg-amber-200">
                                Giris yap
                                <ArrowRight class="ml-2 size-4" />
                            </Button>
                        </Link>
                        {#if canRegister}
                            <Link href={register()}>
                                <Button size="lg" variant="outline" class="rounded-full border-slate-300/80 bg-white/5 px-7 text-white hover:bg-white/12">
                                    Ucretsiz hesap ac
                                </Button>
                            </Link>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="section-pop mt-8 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-xs text-slate-600 sm:px-5">
                <div class="section-text inline-flex items-center gap-2">
                    <Images class="size-3.5 text-violet-700" />
                    Kurumsal sayfalar: Kurumsal, Cozumler, Iletisim
                </div>
                <div class="section-text inline-flex items-center gap-2">
                    <BadgeCheck class="size-3.5 text-violet-700" />
                    Oncelikli destek ve demo talebi icin
                    <a class="font-semibold text-amber-300 hover:underline" href="/iletisim">iletisim ekibine ulas</a>
                </div>
            </div>
        </section>
    </div>
</CorporateLayout>

<style>
    .landing-surface {
        --panel-bg: rgba(24, 14, 44, 0.7);
        --panel-border: rgba(196, 170, 246, 0.45);
        --tile-bg: rgba(34, 20, 62, 0.82);
        --tile-border: rgba(205, 180, 248, 0.38);
        --title-color: #ffffff;
        --text-color: rgba(244, 239, 255, 0.95);
        --muted-color: rgba(224, 214, 244, 0.82);
        --eyebrow-color: #f5c542;
        --solution-color: #f8d56b;
    }

    :global(.dark) .landing-surface {
        --panel-bg: rgba(18, 10, 35, 0.82);
        --panel-border: rgba(179, 140, 248, 0.36);
        --tile-bg: rgba(28, 16, 52, 0.86);
        --tile-border: rgba(178, 145, 237, 0.34);
        --title-color: #ffffff;
        --text-color: rgba(236, 231, 247, 0.96);
        --muted-color: rgba(203, 191, 230, 0.84);
        --eyebrow-color: #f7cd5c;
        --solution-color: #f7d57b;
    }

    .landing-surface {
        background:
            repeating-linear-gradient(
                to right,
                rgba(240, 232, 255, 0.06) 0 1px,
                transparent 1px 34px
            ),
            repeating-linear-gradient(
                to bottom,
                rgba(240, 232, 255, 0.06) 0 1px,
                transparent 1px 34px
            ),
            repeating-linear-gradient(
                to right,
                rgba(245, 197, 66, 0.14) 0 1px,
                transparent 1px 170px
            ),
            repeating-linear-gradient(
                to bottom,
                rgba(245, 197, 66, 0.14) 0 1px,
                transparent 1px 170px
            ),
            radial-gradient(circle at 12% 12%, rgba(245, 197, 66, 0.14), transparent 42%),
            radial-gradient(circle at 90% 20%, rgba(167, 139, 250, 0.2), transparent 40%),
            linear-gradient(160deg, #140b28 0%, #261447 45%, #3f1c6a 100%);
    }

    .section-pop {
        background: var(--panel-bg) !important;
        border-color: var(--panel-border) !important;
        box-shadow:
            0 28px 70px -42px rgba(17, 9, 32, 0.88),
            inset 0 1px 0 rgba(255, 255, 255, 0.07);
        transform: perspective(1600px) translateZ(0);
        transition:
            transform 0.38s ease,
            box-shadow 0.38s ease,
            border-color 0.38s ease;
    }

    .section-pop:hover {
        transform: perspective(1600px) translateY(-6px) translateZ(26px);
        box-shadow:
            0 44px 95px -48px rgba(8, 4, 20, 0.95),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .pop-tile {
        background: var(--tile-bg) !important;
        border-color: var(--tile-border) !important;
        box-shadow:
            0 18px 46px -34px rgba(8, 4, 20, 0.76),
            inset 0 1px 0 rgba(255, 255, 255, 0.07);
        transform: translateZ(0);
        transition:
            transform 0.35s ease,
            box-shadow 0.35s ease,
            border-color 0.35s ease;
    }

    .pop-tile:hover {
        transform: translateY(-4px) translateZ(12px);
        box-shadow:
            0 28px 56px -38px rgba(8, 4, 20, 0.9),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .section-title {
        color: var(--title-color) !important;
    }

    .section-text {
        color: var(--text-color) !important;
    }

    .section-muted {
        color: var(--muted-color) !important;
    }

    .eyebrow {
        color: var(--eyebrow-color) !important;
    }

    .solution-label {
        color: var(--solution-color);
    }

    .globe-card {
        background:
            radial-gradient(circle at 20% 20%, rgba(245, 197, 66, 0.17), transparent 48%),
            linear-gradient(165deg, rgba(109, 40, 217, 0.24), rgba(17, 10, 35, 0.2));
    }

    .globe-stage {
        position: relative;
        width: 220px;
        height: 220px;
        perspective: 1000px;
    }

    .globe {
        position: absolute;
        inset: 0;
        border-radius: 999px;
        overflow: hidden;
        background:
            radial-gradient(circle at 32% 28%, rgba(255, 244, 179, 0.36), transparent 34%),
            radial-gradient(circle at 72% 70%, rgba(179, 114, 255, 0.34), transparent 42%),
            linear-gradient(145deg, #47218c 8%, #2b1654 56%, #1b1037 100%);
        box-shadow:
            inset -28px -24px 46px rgba(10, 5, 20, 0.56),
            inset 22px 14px 36px rgba(255, 255, 255, 0.08),
            0 34px 56px -34px rgba(7, 4, 17, 0.9);
        animation: globeRotate 16s linear infinite;
    }

    .globe::before {
        content: '';
        position: absolute;
        inset: -24% -12%;
        background: repeating-linear-gradient(
            to right,
            rgba(255, 255, 255, 0) 0 16px,
            rgba(245, 197, 66, 0.32) 16px 19px
        );
        opacity: 0.46;
        animation: globeBands 18s linear infinite;
    }

    .globe::after {
        content: '';
        position: absolute;
        inset: 16px;
        border-radius: inherit;
        border: 1px solid rgba(255, 255, 255, 0.26);
    }

    .globe-ring {
        position: absolute;
        inset: 18%;
        border-radius: 999px;
        border: 1px solid rgba(245, 197, 66, 0.45);
        transform-style: preserve-3d;
    }

    .globe-ring-a {
        transform: rotateX(70deg);
    }

    .globe-ring-b {
        transform: rotateY(70deg);
    }

    .globe-ring-c {
        transform: rotateX(15deg) rotateY(18deg);
    }

    .globe-shadow {
        position: absolute;
        left: 50%;
        bottom: -14px;
        width: 150px;
        height: 30px;
        border-radius: 999px;
        background: rgba(7, 4, 17, 0.48);
        filter: blur(8px);
        transform: translateX(-50%);
        animation: globeShadowPulse 5s ease-in-out infinite;
    }

    .hero-title {
        font-family: 'Sora', 'Manrope', 'Instrument Sans', 'Segoe UI', sans-serif;
    }

    .hero-word {
        display: inline-block;
        opacity: 0;
        transform: translateY(18px);
    }

    .smoke-layer {
        filter: blur(36px);
        opacity: 0.28;
        background: radial-gradient(circle, rgba(148, 163, 184, 0.45), rgba(51, 65, 85, 0.04));
    }

    .gold-line {
        background: linear-gradient(90deg, rgba(245, 197, 66, 0), rgba(245, 197, 66, 0.78), rgba(245, 197, 66, 0));
        opacity: 0.6;
        filter: blur(0.2px);
    }

    .gold-line-one {
        animation: shimmerOne 11s ease-in-out infinite;
    }

    .gold-line-two {
        animation: shimmerTwo 13s ease-in-out infinite;
    }

    .reveal-item {
        opacity: 0;
        transform: translateY(22px);
        transition:
            opacity 0.6s ease,
            transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    :global(.reveal-item.is-visible) {
        opacity: 1;
        transform: translateY(0);
    }

    .smoke-one {
        animation: smokeDriftOne 17s ease-in-out infinite;
    }

    .smoke-two {
        animation: smokeDriftTwo 22s ease-in-out infinite;
    }

    .smoke-three {
        animation: smokeDriftThree 26s ease-in-out infinite;
    }

    .browser-frame {
        box-shadow: 0 18px 46px -34px rgba(15, 44, 87, 0.55);
    }

    .floating-screen {
        animation: floatWave 7.4s ease-in-out infinite;
    }

    .hero-shot,
    .gallery-shot,
    .thumb-shot {
        transition: transform 0.45s ease;
    }

    .browser-frame:hover .hero-shot,
    .browser-frame:hover .gallery-shot {
        transform: scale(1.02);
    }

    .group:hover .thumb-shot {
        transform: scale(1.04);
    }

    .quote-mini .quote-sheet {
        animation: quotePulse 2.4s ease-in-out infinite;
    }

    .cta-banner {
        box-shadow: 0 28px 72px -42px rgba(8, 45, 88, 0.86);
    }

    @keyframes shimmerOne {
        0%,
        100% {
            transform: translateX(0) rotate(12deg);
            opacity: 0.45;
        }

        50% {
            transform: translateX(14px) rotate(12deg);
            opacity: 0.85;
        }
    }

    @keyframes shimmerTwo {
        0%,
        100% {
            transform: translateX(0) rotate(-12deg);
            opacity: 0.35;
        }

        50% {
            transform: translateX(-16px) rotate(-12deg);
            opacity: 0.78;
        }
    }

    @keyframes smokeDriftOne {
        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        50% {
            transform: translate(34px, 24px) scale(1.08);
        }
    }

    @keyframes smokeDriftTwo {
        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        50% {
            transform: translate(-42px, -22px) scale(1.1);
        }
    }

    @keyframes smokeDriftThree {
        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        50% {
            transform: translate(20px, -34px) scale(1.05);
        }
    }

    @keyframes quotePulse {
        0%,
        100% {
            transform: translateY(0);
            box-shadow: 0 0 0 rgba(244, 114, 182, 0);
        }

        50% {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -20px rgba(244, 114, 182, 0.8);
        }
    }

    @keyframes floatWave {
        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-7px);
        }
    }

    @keyframes globeRotate {
        0% {
            transform: rotateY(0deg);
        }

        100% {
            transform: rotateY(360deg);
        }
    }

    @keyframes globeBands {
        0% {
            transform: rotate(-8deg) translateX(-18px);
        }

        100% {
            transform: rotate(-8deg) translateX(20px);
        }
    }

    @keyframes globeShadowPulse {
        0%,
        100% {
            opacity: 0.56;
            transform: translateX(-50%) scaleX(1);
        }

        50% {
            opacity: 0.82;
            transform: translateX(-50%) scaleX(1.08);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .hero-word {
            opacity: 1;
            transform: none;
        }

        .reveal-item {
            opacity: 1;
            transform: none;
            transition: none;
        }

        .gold-line-one,
        .gold-line-two,
        .smoke-one,
        .smoke-two,
        .smoke-three,
        .quote-mini .quote-sheet,
        .floating-screen,
        .globe,
        .globe::before,
        .globe-shadow {
            animation: none;
        }

        .hero-shot,
        .gallery-shot,
        .thumb-shot {
            transition: none;
        }
    }
</style>
