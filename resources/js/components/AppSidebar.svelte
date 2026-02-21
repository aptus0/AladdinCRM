<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import Briefcase from 'lucide-svelte/icons/briefcase';
    import Building2 from 'lucide-svelte/icons/building-2';
    import FileText from 'lucide-svelte/icons/file-text';
    import Headset from 'lucide-svelte/icons/headset';
    import ListChecks from 'lucide-svelte/icons/list-checks';
    import LayoutGrid from 'lucide-svelte/icons/layout-grid';
    import UserRound from 'lucide-svelte/icons/user-round';
    import type { Snippet } from 'svelte';
    import AppLogo from '@/components/AppLogo.svelte';
    import NavMain from '@/components/NavMain.svelte';
    import NavUser from '@/components/NavUser.svelte';
    import {
        Sidebar,
        SidebarContent,
        SidebarFooter,
        SidebarHeader,
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
    } from '@/components/ui/sidebar';
    import { toUrl } from '@/lib/utils';
    import type { NavItem } from '@/types';
    import { dashboard } from '@/routes';

    let {
        children,
    }: {
        children?: Snippet;
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
    const isDashboard = $derived(currentPath === dashboard().url);

    const mainNavItems = $derived<NavItem[]>([
        {
            title: 'Genel Bakis',
            href: dashboard(),
            icon: LayoutGrid,
            isActive: isDashboard && currentTab === 'overview',
        },
    ]);

    const crudNavItems = $derived<NavItem[]>([
        {
            title: 'Sirketler',
            href: dashboard({ query: { tab: 'companies' } }),
            icon: Building2,
            isActive: isDashboard && currentTab === 'companies',
        },
        {
            title: 'Kisiler',
            href: dashboard({ query: { tab: 'contacts' } }),
            icon: UserRound,
            isActive: isDashboard && currentTab === 'contacts',
        },
        {
            title: 'Firsatlar',
            href: dashboard({ query: { tab: 'opportunities' } }),
            icon: Briefcase,
            isActive: isDashboard && currentTab === 'opportunities',
        },
        {
            title: 'Teklifler',
            href: dashboard({ query: { tab: 'quotes' } }),
            icon: FileText,
            isActive: isDashboard && currentTab === 'quotes',
        },
        {
            title: 'Gorevler',
            href: dashboard({ query: { tab: 'tasks' } }),
            icon: ListChecks,
            isActive: isDashboard && currentTab === 'tasks',
        },
        {
            title: 'Destek',
            href: dashboard({ query: { tab: 'tickets' } }),
            icon: Headset,
            isActive: isDashboard && currentTab === 'tickets',
        },
    ]);

</script>

<Sidebar collapsible="icon" variant="inset">
    <SidebarHeader class="px-3 pb-1 pt-3">
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton
                    size="lg"
                    asChild
                    class="h-auto min-h-[3.25rem] rounded-xl border border-sidebar-border/65 bg-background/80 px-2.5 py-2 shadow-sm transition-colors hover:bg-sidebar-accent/40 group-data-[collapsible=icon]:size-10 group-data-[collapsible=icon]:p-0"
                >
                    {#snippet children(props)}
                        <Link {...props} href={toUrl(dashboard())} class={props.class}>
                            <AppLogo />
                        </Link>
                    {/snippet}
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>

        <p class="mt-2 px-2 text-[10px] font-medium tracking-[0.13em] text-sidebar-foreground/55 uppercase group-data-[collapsible=icon]:hidden">
            CRM Kontrol Paneli
        </p>
    </SidebarHeader>

    <SidebarContent class="px-2 pb-2 pt-1">
        <NavMain label="Genel" items={mainNavItems} />
        <NavMain label="CRM Modulleri" items={crudNavItems} />
    </SidebarContent>

    <SidebarFooter class="border-t border-sidebar-border/60 px-3 pb-3 pt-2">
        <NavUser />
    </SidebarFooter>
</Sidebar>
{@render children?.()}
