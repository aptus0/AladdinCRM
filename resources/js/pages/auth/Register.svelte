<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Spinner } from '@/components/ui/spinner';
    import AuthBase from '@/layouts/AuthLayout.svelte';
    import { login } from '@/routes';
    import { store } from '@/routes/register';
</script>

<AppHead title="Kayit Ol" />

<AuthBase
    sceneType="register"
    title="Yeni hesap olusturun"
    description="Ekibiniz icin CRM erisimini baslatmak adina bilgileri doldurun"
>
    <Form
        {...store.form()}
        resetOnSuccess={['password', 'password_confirmation']}
        class="flex flex-col gap-6"
    >
        {#snippet children({ errors, processing })}
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Ad soyad</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autocomplete="name"
                        name="name"
                        placeholder="Ad Soyad"
                    />
                    <InputError message={errors.name} />
                </div>

                <div class="grid gap-2">
                    <Label for="email">E-posta adresi</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autocomplete="email"
                        name="email"
                        placeholder="ornek@firma.com"
                    />
                    <InputError message={errors.email} />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Sifre</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        name="password"
                        placeholder="Guclu bir sifre belirleyin"
                    />
                    <InputError message={errors.password} />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Sifreyi dogrula</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Sifrenizi tekrar girin"
                    />
                    <InputError message={errors.password_confirmation} />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full"
                    disabled={processing}
                    data-test="register-user-button"
                >
                    {#if processing}<Spinner />{/if}
                    Hesap olustur
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Zaten bir hesabiniz var mi?
                <TextLink href={login()} class="underline underline-offset-4">
                    Giris yap
                </TextLink>
            </div>
        {/snippet}
    </Form>
</AuthBase>
