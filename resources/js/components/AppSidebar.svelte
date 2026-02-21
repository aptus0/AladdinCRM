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
            title: 'Panel',
            href: dashboard(),
            icon: LayoutGrid,
            isActive: isDashboard && currentTab === 'overview',
        },
    ]);

    const crudNavItems = $derived<NavItem[]>([
        {
            title: 'Company',
            href: dashboard({ query: { tab: 'companies' } }),
            icon: Building2,
            isActive: isDashboard && currentTab === 'companies',
        },
        {
            title: 'Contact',
            href: dashboard({ query: { tab: 'contacts' } }),
            icon: UserRound,
            isActive: isDashboard && currentTab === 'contacts',
        },
        {
            title: 'Opportunity',
            href: dashboard({ query: { tab: 'opportunities' } }),
            icon: Briefcase,
            isActive: isDashboard && currentTab === 'opportunities',
        },
        {
            title: 'Quote',
            href: dashboard({ query: { tab: 'quotes' } }),
            icon: FileText,
            isActive: isDashboard && currentTab === 'quotes',
        },
        {
            title: 'Task',
            href: dashboard({ query: { tab: 'tasks' } }),
            icon: ListChecks,
            isActive: isDashboard && currentTab === 'tasks',
        },
        {
            title: 'Ticket',
            href: dashboard({ query: { tab: 'tickets' } }),
            icon: Headset,
            isActive: isDashboard && currentTab === 'tickets',
        },
    ]);

</script>

<Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
        <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" asChild>
                        {#snippet children(props)}
                            <Link {...props} href={toUrl(dashboard())} class={props.class}>
                                <AppLogo />
                            </Link>
                        {/snippet}
                    </SidebarMenuButton>
                </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
        <NavMain label="Platform" items={mainNavItems} />
        <NavMain label="CRM CRUD" items={crudNavItems} />
    </SidebarContent>

    <SidebarFooter>
        <NavUser />
    </SidebarFooter>
</Sidebar>
{@render children?.()}
