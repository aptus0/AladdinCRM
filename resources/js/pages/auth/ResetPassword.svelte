<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Spinner } from '@/components/ui/spinner';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { update } from '@/routes/password';

    let {
        token,
        email,
    }: {
        token: string;
        email: string;
    } = $props();
</script>

<AppHead title="Sifre Sifirlama" />

<AuthLayout title="Sifreyi sifirla" description="Yeni sifrenizi asagidan belirleyin">
    <Form
        {...update.form()}
        transform={(data) => ({ ...data, token, email })}
        resetOnSuccess={['password', 'password_confirmation']}
    >
        {#snippet children({ errors, processing })}
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">E-posta</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="email"
                        value={email}
                        class="mt-1 block w-full"
                        readonly
                    />
                    <InputError message={errors.email} class="mt-2" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Yeni sifre</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder="Yeni sifrenizi girin"
                    />
                    <InputError message={errors.password} />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Sifreyi dogrula</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder="Sifrenizi tekrar girin"
                    />
                    <InputError message={errors.password_confirmation} />
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    disabled={processing}
                    data-test="reset-password-button"
                >
                    {#if processing}<Spinner />{/if}
                    Sifreyi sifirla
                </Button>
            </div>
        {/snippet}
    </Form>
</AuthLayout>
