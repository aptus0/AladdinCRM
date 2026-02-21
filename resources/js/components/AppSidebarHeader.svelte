<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import Briefcase from 'lucide-svelte/icons/briefcase';
    import Building2 from 'lucide-svelte/icons/building-2';
    import FileText from 'lucide-svelte/icons/file-text';
    import Headset from 'lucide-svelte/icons/headset';
    import LayoutGrid from 'lucide-svelte/icons/layout-grid';
    import ListChecks from 'lucide-svelte/icons/list-checks';
    import UserRound from 'lucide-svelte/icons/user-round';
    import Breadcrumbs from '@/components/Breadcrumbs.svelte';
    import { dashboard } from '@/routes';
    import { toUrl } from '@/lib/utils';
    import { SidebarTrigger } from '@/components/ui/sidebar';
    import type { BreadcrumbItem } from '@/types';

    let {
        breadcrumbs = [],
    }: {
        breadcrumbs?: BreadcrumbItem[];
    } = $props();

    function parseCurrentPath(urlString: string): string {
        const origin = typeof window === 'undefined' ? 'http://localhost' : window.location.origin;

        try {
            return new URL(urlString, origin).pathname;
        } catch {
            return urlString;
        }
    }

    function parseCurrentTab(urlString: string): string {
        const origin = typeof window === 'undefined' ? 'http://localhost' : window.location.origin;

        try {
            return new URL(urlString, origin).searchParams.get('tab') ?? 'overview';
        } catch {
            return 'overview';
        }
    }

    const currentPath = $derived(parseCurrentPath($page.url));
    const currentTab = $derived(parseCurrentTab($page.url));
    const isDashboardPage = $derived(currentPath === dashboard().url);

    const crudLinks = [
        { tab: 'overview', label: 'Panel', icon: LayoutGrid },
        { tab: 'companies', label: 'Company', icon: Building2 },
        { tab: 'contacts', label: 'Contact', icon: UserRound },
        { tab: 'opportunities', label: 'Opportunity', icon: Briefcase },
        { tab: 'quotes', label: 'Quote', icon: FileText },
        { tab: 'tasks', label: 'Task', icon: ListChecks },
        { tab: 'tickets', label: 'Ticket', icon: Headset },
    ] as const;
</script>

<header
    class="shrink-0 border-b border-sidebar-border/70 px-6 py-2 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:py-1 md:px-4"
>
    <div class="flex w-full flex-col gap-2">
        <div class="flex min-h-10 items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            {#if breadcrumbs && breadcrumbs.length > 0}
                <Breadcrumbs {breadcrumbs} />
            {/if}
        </div>

        {#if isDashboardPage}
            <div class="flex flex-wrap items-center gap-2">
                {#each crudLinks as item (item.tab)}
                    <Link
                        href={toUrl(
                            item.tab === 'overview'
                                ? dashboard()
                                : dashboard({ query: { tab: item.tab } }),
                        )}
                        class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium transition {currentTab === item.tab
                            ? 'border-slate-900 bg-slate-900 text-white'
                            : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100'}"
                    >
                        <item.icon class="size-3.5" />
                        <span>{item.label}</span>
                    </Link>
                {/each}
            </div>
        {/if}
    </div>
</header>
