<script lang="ts">
    import AppearanceTabs from '@/components/AppearanceTabs.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import Heading from '@/components/Heading.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import SettingsLayout from '@/layouts/settings/Layout.svelte';
    import type { BreadcrumbItem } from '@/types';
    import { edit as editAppearance } from '@/routes/appearance';

    const breadcrumbItems: BreadcrumbItem[] = [
        {
            title: 'Gorunum ayarlari',
            href: editAppearance().url,
        },
    ];
</script>

<AppHead title="Gorunum ayarlari" />

<AppLayout breadcrumbs={breadcrumbItems}>
    <h1 class="sr-only">Gorunum ayarlari</h1>

    <SettingsLayout>
        <div class="space-y-6">
            <Heading variant="small" title="Gorunum ayarlari" description="Hesabinizin tema ve gorunum tercihlerini guncelleyin" />
            <AppearanceTabs />
        </div>
    </SettingsLayout>
</AppLayout>
