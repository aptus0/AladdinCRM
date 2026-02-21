<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import ShieldBan from 'lucide-svelte/icons/shield-ban';
    import ShieldCheck from 'lucide-svelte/icons/shield-check';
    import { onDestroy } from 'svelte';
    import AppHead from '@/components/AppHead.svelte';
    import Heading from '@/components/Heading.svelte';
    import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.svelte';
    import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.svelte';
    import { Badge } from '@/components/ui/badge';
    import { Button } from '@/components/ui/button';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import SettingsLayout from '@/layouts/settings/Layout.svelte';
    import { twoFactorAuthState } from '@/lib/twoFactorAuth.svelte';
    import type { BreadcrumbItem } from '@/types';
    import { disable, enable, show } from '@/routes/two-factor';

    let {
        requiresConfirmation = false,
        twoFactorEnabled = false,
    }: {
        requiresConfirmation?: boolean;
        twoFactorEnabled?: boolean;
    } = $props();

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Iki asamali dogrulama',
            href: show.url(),
        },
    ];

    const twoFactorAuth = twoFactorAuthState();
    let showSetupModal = $state(false);

    onDestroy(() => {
        twoFactorAuth.clearTwoFactorAuthData();
    });
</script>

<AppHead title="Iki asamali dogrulama" />

<AppLayout breadcrumbs={breadcrumbs}>
    <h1 class="sr-only">Iki asamali dogrulama ayarlari</h1>

    <SettingsLayout>
        <div class="space-y-6">
            <Heading
                variant="small"
                title="Iki asamali dogrulama"
                description="Hesabinizin iki asamali dogrulama ayarlarini yonetin"
            />

            {#if !twoFactorEnabled}
                <div class="flex flex-col items-start justify-start space-y-4">
                    <Badge variant="destructive">Kapali</Badge>

                    <p class="text-muted-foreground">
                        Iki asamali dogrulamayi etkinlestirdiginizde, giris sirasinda telefonunuzdaki TOTP uyumlu
                        uygulamadan alacaginiz kod istenir.
                    </p>

                    <div>
                        {#if twoFactorAuth.hasSetupData()}
                            <Button onclick={() => (showSetupModal = true)}>
                                <ShieldCheck class="size-4" />Kuruluma devam et
                            </Button>
                        {:else}
                            <Form
                                {...enable.form()}
                                onSuccess={() => (showSetupModal = true)}
                            >
                                {#snippet children({ processing })}
                                    <Button type="submit" disabled={processing}>
                                        <ShieldCheck class="size-4" />2FA'yi etkinlestir
                                    </Button>
                                {/snippet}
                            </Form>
                        {/if}
                    </div>
                </div>
            {:else}
                <div class="flex flex-col items-start justify-start space-y-4">
                    <Badge variant="default">Etkin</Badge>

                    <p class="text-muted-foreground">
                        Iki asamali dogrulama etkin oldugunda, giris sirasinda telefonunuzdaki TOTP uygulamasindan
                        uretilen guvenli kodu girmeniz gerekir.
                    </p>

                    <TwoFactorRecoveryCodes />

                    <div class="relative inline">
                        <Form {...disable.form()}>
                            {#snippet children({ processing })}
                                <Button variant="destructive" type="submit" disabled={processing}>
                                    <ShieldBan class="size-4" />
                                    2FA'yi kapat
                                </Button>
                            {/snippet}
                        </Form>
                    </div>
                </div>
            {/if}

            <TwoFactorSetupModal
                bind:isOpen={showSetupModal}
                {requiresConfirmation}
                {twoFactorEnabled}
            />
        </div>
    </SettingsLayout>
</AppLayout>
