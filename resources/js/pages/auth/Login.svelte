<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Checkbox } from '@/components/ui/checkbox';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Spinner } from '@/components/ui/spinner';
    import AuthBase from '@/layouts/AuthLayout.svelte';
    import { register } from '@/routes';
    import { store } from '@/routes/login';
    import { request } from '@/routes/password';

    let {
        status = '',
        canResetPassword,
        canRegister,
    }: {
        status?: string;
        canResetPassword: boolean;
        canRegister: boolean;
    } = $props();
</script>

<AppHead title="Giris Yap" />

<AuthBase
    sceneType="login"
    title="Hesabiniza giris yapin"
    description="CRM panelinize erismek icin e-posta ve sifrenizi girin"
>
    {#if status}
        <div class="mb-4 text-center text-sm font-medium text-green-600">
            {status}
        </div>
    {/if}

    <Form
        {...store.form()}
        resetOnSuccess={['password']}
        class="flex flex-col gap-6"
    >
        {#snippet children({ errors, processing })}
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">E-posta adresi</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autocomplete="email"
                        placeholder="ornek@firma.com"
                    />
                    <InputError message={errors.email} />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Sifre</Label>
                        {#if canResetPassword}
                            <TextLink href={request()} class="text-sm">
                                Sifremi unuttum
                            </TextLink>
                        {/if}
                    </div>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Sifrenizi girin"
                    />
                    <InputError message={errors.password} />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" name="remember" />
                        <span>Beni hatirla</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    disabled={processing}
                    data-test="login-button"
                >
                    {#if processing}<Spinner />{/if}
                    Giris yap
                </Button>
            </div>

            {#if canRegister}
                <div class="text-center text-sm text-muted-foreground">
                    Hesabiniz yok mu?
                    <TextLink href={register()}>Kayit ol</TextLink>
                </div>
            {/if}
        {/snippet}
    </Form>
</AuthBase>
