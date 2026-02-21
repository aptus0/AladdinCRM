<script lang="ts">
    import { Form, page } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import DeleteUser from '@/components/DeleteUser.svelte';
    import Heading from '@/components/Heading.svelte';
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import SettingsLayout from '@/layouts/settings/Layout.svelte';
    import type { BreadcrumbItem } from '@/types';
    import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
    import { edit } from '@/routes/profile';
    import { send } from '@/routes/verification';

    let {
        mustVerifyEmail,
        status = '',
    }: {
        mustVerifyEmail: boolean;
        status?: string;
    } = $props();

    const breadcrumbItems: BreadcrumbItem[] = [
        {
            title: 'Profil ayarlari',
            href: edit().url,
        },
    ];

    const user = $derived($page.props.auth.user);
</script>

<AppHead title="Profil ayarlari" />

<AppLayout breadcrumbs={breadcrumbItems}>
    <h1 class="sr-only">Profil ayarlari</h1>

    <SettingsLayout>
        <div class="flex flex-col space-y-6">
            <Heading variant="small" title="Profil bilgileri" description="Adinizi ve e-posta adresinizi guncelleyin" />

            <Form
                {...ProfileController.update.form()}
                class="space-y-6"
                options={{ preserveScroll: true }}
            >
                {#snippet children({ errors, processing, recentlySuccessful })}
                    <div class="grid gap-2">
                        <Label for="name">Ad soyad</Label>
                        <Input
                            id="name"
                            name="name"
                            class="mt-1 block w-full"
                            value={user.name}
                            required
                            autocomplete="name"
                            placeholder="Ad Soyad"
                        />
                        <InputError class="mt-2" message={errors.name} />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">E-posta adresi</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            class="mt-1 block w-full"
                            value={user.email}
                            required
                            autocomplete="username"
                            placeholder="ornek@firma.com"
                        />
                        <InputError class="mt-2" message={errors.email} />
                    </div>

                    {#if mustVerifyEmail && !user.email_verified_at}
                        <div>
                            <p class="-mt-4 text-sm text-muted-foreground">
                                E-posta adresiniz henuz dogrulanmadi.
                                <TextLink href={send()} as="button">
                                    Dogrulama e-postasini yeniden gondermek icin tiklayin.
                                </TextLink>
                            </p>

                            {#if status === 'verification-link-sent'}
                                <div class="mt-2 text-sm font-medium text-green-600">
                                    E-posta adresinize yeni bir dogrulama baglantisi gonderildi.
                                </div>
                            {/if}
                        </div>
                    {/if}

                    <div class="flex items-center gap-4">
                        <Button type="submit" disabled={processing} data-test="update-profile-button">Kaydet</Button>

                        {#if recentlySuccessful}
                            <p class="text-sm text-neutral-600">Kaydedildi.</p>
                        {/if}
                    </div>
                {/snippet}
            </Form>
        </div>

        <DeleteUser />
    </SettingsLayout>
</AppLayout>
