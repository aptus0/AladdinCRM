<script lang="ts">
    import { page } from '@inertiajs/svelte';
    import ChevronsUpDown from 'lucide-svelte/icons/chevrons-up-down';
    import {
        DropdownMenu,
        DropdownMenuContent,
        DropdownMenuTrigger,
    } from '@/components/ui/dropdown-menu';
    import {
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
        useSidebar,
    } from '@/components/ui/sidebar';
    import UserInfo from '@/components/UserInfo.svelte';
    import UserMenuContent from '@/components/UserMenuContent.svelte';

    const user = $derived($page.props.auth.user);
    const { isMobile, state: sidebarState } = useSidebar();
</script>

<SidebarMenu>
    <SidebarMenuItem>
        <DropdownMenu class="w-full">
            <DropdownMenuTrigger asChild>
                {#snippet children(props)}
                    <SidebarMenuButton
                        size="lg"
                        class="h-11 rounded-lg border border-sidebar-border/70 bg-background/85 px-2.5 transition-colors duration-150 hover:bg-sidebar-accent/55 data-[state=open]:bg-sidebar-accent/70 data-[state=open]:text-sidebar-accent-foreground group-data-[collapsible=icon]:size-9 group-data-[collapsible=icon]:justify-center group-data-[collapsible=icon]:p-0"
                        data-test="sidebar-menu-button"
                        onclick={props.onclick}
                        aria-expanded={props['aria-expanded']}
                        data-state={props['data-state']}
                    >
                        <UserInfo {user} />
                        <ChevronsUpDown class="ml-auto size-4 text-sidebar-foreground/70 group-data-[collapsible=icon]:hidden" />
                    </SidebarMenuButton>
                {/snippet}
            </DropdownMenuTrigger>
            <DropdownMenuContent
                class="w-[min(18rem,90vw)] min-w-0 rounded-xl border border-sidebar-border/70 bg-popover/95 p-1 shadow-xl backdrop-blur-sm"
                side={$sidebarState === 'collapsed' && !$isMobile ? 'left' : 'top'}
                align="end"
                sideOffset={4}
            >
                <UserMenuContent {user} />
            </DropdownMenuContent>
        </DropdownMenu>
    </SidebarMenuItem>
</SidebarMenu>
