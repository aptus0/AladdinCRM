<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import Heading from '@/components/Heading.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import SettingsLayout from '@/layouts/settings/Layout.svelte';
    import type { BreadcrumbItem } from '@/types';
    import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController';
    import { edit } from '@/routes/user-password';

    const breadcrumbItems: BreadcrumbItem[] = [
        {
            title: 'Sifre ayarlari',
            href: edit().url,
        },
    ];
</script>

<AppHead title="Sifre ayarlari" />

<AppLayout breadcrumbs={breadcrumbItems}>
    <h1 class="sr-only">Sifre ayarlari</h1>

    <SettingsLayout>
        <div class="space-y-6">
            <Heading
                variant="small"
                title="Sifrenizi guncelleyin"
                description="Hesap guvenliginiz icin guclu ve tahmin edilmesi zor bir sifre kullanin"
            />

            <Form
                {...PasswordController.update.form()}
                class="space-y-6"
                options={{ preserveScroll: true }}
                resetOnSuccess
                resetOnError={['password', 'password_confirmation', 'current_password']}
            >
                {#snippet children({ errors, processing, recentlySuccessful })}
                    <div class="grid gap-2">
                        <Label for="current_password">Mevcut sifre</Label>
                        <Input
                            id="current_password"
                            name="current_password"
                            type="password"
                            class="mt-1 block w-full"
                            autocomplete="current-password"
                            placeholder="Mevcut sifrenizi girin"
                        />
                        <InputError message={errors.current_password} />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password">Yeni sifre</Label>
                        <Input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-full"
                            autocomplete="new-password"
                            placeholder="Yeni sifrenizi girin"
                        />
                        <InputError message={errors.password} />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation">Sifreyi dogrula</Label>
                        <Input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            autocomplete="new-password"
                            placeholder="Sifrenizi tekrar girin"
                        />
                        <InputError message={errors.password_confirmation} />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button type="submit" disabled={processing} data-test="update-password-button">
                            Sifreyi kaydet
                        </Button>

                        {#if recentlySuccessful}
                            <p class="text-sm text-neutral-600">Kaydedildi.</p>
                        {/if}
                    </div>
                {/snippet}
            </Form>
        </div>
    </SettingsLayout>
</AppLayout>
