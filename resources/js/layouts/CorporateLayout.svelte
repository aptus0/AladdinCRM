<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';
    import { home, login, register } from '@/routes';

    let {
        canRegister = true,
        children,
    }: {
        canRegister?: boolean;
        children?: Snippet;
    } = $props();

    const navItems: Array<{ label: string; href: string }> = [
        { label: 'Ana Sayfa', href: '/' },
        { label: 'Kurumsal', href: '/kurumsal' },
        { label: 'Cozumler', href: '/cozumler' },
        { label: 'Iletisim', href: '/iletisim' },
    ];

    const activePath = $derived($page.url.split('?')[0] || '/');
    const year = new Date().getFullYear();
</script>

<div class="min-h-svh bg-slate-50 text-slate-900">
    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex h-20 w-full max-w-7xl items-center justify-between gap-4 px-4 sm:px-6">
            <Link href={home()} class="flex items-center gap-3">
                <img
                    src="/brand/aladdin-crm-icon.svg"
                    alt="Aladdin CRM ikon"
                    class="h-10 w-10 rounded-xl border border-slate-200 bg-white p-1 shadow-sm"
                    loading="lazy"
                    decoding="async"
                />
                <img
                    src="/brand/aladdin-crm-logo.svg"
                    alt="Aladdin CRM logo"
                    class="h-9 w-auto object-contain"
                    loading="lazy"
                    decoding="async"
                />
            </Link>

            <nav class="hidden items-center gap-1 rounded-full border border-slate-200 bg-white px-2 py-1.5 lg:flex">
                {#each navItems as item (item.href)}
                    <Link
                        href={item.href}
                        class="rounded-full px-4 py-2 text-sm font-medium transition-colors {activePath === item.href
                            ? 'bg-slate-900 text-white'
                            : 'text-slate-700 hover:bg-slate-100'}"
                    >
                        {item.label}
                    </Link>
                {/each}
            </nav>

            <div class="flex items-center gap-2">
                <Link
                    href={login()}
                    class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-100"
                >
                    Giris Yap
                </Link>
                {#if canRegister}
                    <Link
                        href={register()}
                        class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition-opacity hover:opacity-90"
                    >
                        Ucretsiz Basla
                    </Link>
                {/if}
            </div>
        </div>
    </header>

    <main>
        {@render children?.()}
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto grid w-full max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3">
            <div class="space-y-3">
                <img
                    src="/brand/aladdin-crm-logo.svg"
                    alt="Aladdin CRM"
                    class="h-10 w-auto"
                    loading="lazy"
                    decoding="async"
                />
                <p class="max-w-sm text-sm text-slate-600">
                    Aladdin CRM, kurumsal ekiplerin satis, musteri iliskileri ve operasyon sureclerini tek merkezde
                    yonetmesini saglar.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Kurumsal</h3>
                <div class="mt-3 space-y-2 text-sm text-slate-600">
                    <Link href="/kurumsal" class="block hover:text-slate-900">Hakkimizda</Link>
                    <Link href="/cozumler" class="block hover:text-slate-900">Cozumler</Link>
                    <Link href="/iletisim" class="block hover:text-slate-900">Iletisim</Link>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Urun</h3>
                <div class="mt-3 space-y-2 text-sm text-slate-600">
                    <p>Musteri 360 Takibi</p>
                    <p>Pipeline ve Firsat Yonetimi</p>
                    <p>Raporlama ve Otomasyon</p>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 px-4 py-4 text-center text-xs text-slate-500 sm:px-6">
            © {year} Aladdin CRM. Tum haklari saklidir.
        </div>
    </footer>
</div>
