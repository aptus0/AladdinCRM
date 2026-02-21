<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Spinner } from '@/components/ui/spinner';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { login } from '@/routes';
    import { email } from '@/routes/password';

    let {
        status = '',
    }: {
        status?: string;
    } = $props();
</script>

<AppHead title="Sifremi Unuttum" />

<AuthLayout
    title="Sifrenizi mi unuttunuz?"
    description="Sifre yenileme baglantisi almak icin e-posta adresinizi girin"
>
    {#if status}
        <div class="mb-4 text-center text-sm font-medium text-green-600">
            {status}
        </div>
    {/if}

    <div class="space-y-6">
        <Form {...email.form()}>
            {#snippet children({ errors, processing })}
            <div class="grid gap-2">
                    <Label for="email">E-posta adresi</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="off"
                        placeholder="ornek@firma.com"
                    />
                    <InputError message={errors.email} />
                </div>

                <div class="my-6 flex items-center justify-start">
                    <Button
                        type="submit"
                        class="w-full"
                        disabled={processing}
                        data-test="email-password-reset-link-button"
                    >
                        {#if processing}<Spinner />{/if}
                        Sifre yenileme baglantisi gonder
                    </Button>
                </div>
            {/snippet}
        </Form>

        <div class="space-x-1 text-center text-sm text-muted-foreground">
            <span>Veya</span>
            <TextLink href={login()}>giris ekranina don</TextLink>
        </div>
    </div>
</AuthLayout>
