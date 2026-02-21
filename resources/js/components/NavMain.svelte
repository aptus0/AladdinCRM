<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import {
        SidebarGroup,
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
    } from '@/components/ui/sidebar';
    import { currentUrlState } from '@/lib/currentUrl';
    import { toUrl } from '@/lib/utils';
    import type { NavItem } from '@/types';

    let {
        items = [],
        label = 'Platform',
    }: {
        items: NavItem[];
        label?: string;
    } = $props();

    const { currentUrl, isCurrentUrl } = currentUrlState();
</script>

<SidebarGroup class="px-2 py-1.5 group-data-[collapsible=icon]:px-1">
    <div class="mb-2 px-2 text-[10px] font-semibold tracking-[0.16em] text-sidebar-foreground/55 uppercase group-data-[collapsible=icon]:hidden">
        {label}
    </div>

    <SidebarMenu class="gap-1">
        {#each items as item (toUrl(item.href))}
            <SidebarMenuItem>
                <SidebarMenuButton
                    asChild
                    isActive={item.isActive ?? isCurrentUrl(item.href, $currentUrl)}
                    class="h-10 rounded-lg border border-transparent px-2.5 text-[13px] font-medium text-sidebar-foreground/85 transition-colors duration-150 hover:border-sidebar-border/70 hover:bg-sidebar-accent/55 hover:text-sidebar-foreground data-[active=true]:border-sidebar-border/75 data-[active=true]:bg-sidebar-accent/80 data-[active=true]:text-sidebar-foreground group-data-[collapsible=icon]:h-9 group-data-[collapsible=icon]:justify-center group-data-[collapsible=icon]:p-0"
                    tooltip={item.title}
                >
                    {#snippet children(props)}
                        <Link {...props} href={toUrl(item.href)} class={`group ${props.class ?? ''}`}>
                            {#if item.icon}
                                <item.icon class="size-4 shrink-0 text-violet-500/90 transition-colors duration-150 group-hover:text-violet-600 dark:text-violet-200/90 dark:group-hover:text-violet-100" />
                            {/if}
                            <span class="truncate group-data-[collapsible=icon]:hidden">{item.title}</span>
                        </Link>
                    {/snippet}
                </SidebarMenuButton>
            </SidebarMenuItem>
        {/each}
    </SidebarMenu>
</SidebarGroup>
