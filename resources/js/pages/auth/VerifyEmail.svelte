<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Spinner } from '@/components/ui/spinner';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { logout } from '@/routes';
    import { send } from '@/routes/verification';

    let {
        status = '',
    }: {
        status?: string;
    } = $props();
</script>

<AppHead title="E-posta Dogrulamasi" />

<AuthLayout
    title="E-posta adresinizi dogrulayin"
    description="Az once gonderdigimiz e-postadaki baglantiya tiklayarak hesabinizi etkinlestirin."
>
    {#if status === 'verification-link-sent'}
        <div class="mb-4 text-center text-sm font-medium text-green-600">
            Kayit sirasinda girdiginiz e-posta adresine yeni bir dogrulama baglantisi gonderildi.
        </div>
    {/if}

    <Form {...send.form()} class="space-y-6 text-center">
        {#snippet children({ processing })}
            <Button type="submit" disabled={processing} variant="secondary">
                {#if processing}<Spinner />{/if}
                Dogrulama e-postasini tekrar gonder
            </Button>

            <TextLink href={logout()} as="button" class="mx-auto block text-sm">
                Cikis yap
            </TextLink>
        {/snippet}
    </Form>
</AuthLayout>
