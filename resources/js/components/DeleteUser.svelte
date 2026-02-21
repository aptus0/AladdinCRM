<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import Heading from '@/components/Heading.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import {
        Dialog,
        DialogClose,
        DialogContent,
        DialogDescription,
        DialogFooter,
        DialogTitle,
        DialogTrigger,
    } from '@/components/ui/dialog';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';

</script>

<div class="space-y-6">
    <Heading variant="small" title="Hesabi sil" description="Hesabinizi ve bagli tum verileri kalici olarak silin" />
    <div class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
        <div class="relative space-y-0.5 text-red-600 dark:text-red-100">
            <p class="font-medium">Dikkat</p>
            <p class="text-sm">Bu islem geri alinamaz. Lutfen dikkatli ilerleyin.</p>
        </div>
        <Dialog>
            <DialogTrigger>
                <Button variant="destructive" data-test="delete-user-button">Hesabi sil</Button>
            </DialogTrigger>
            <DialogContent>
                <Form
                    {...ProfileController.destroy.form()}
                    class="space-y-6"
                    options={{ preserveScroll: true }}
                >
                    {#snippet children({ errors, processing })}
                        <div class="space-y-3">
                            <DialogTitle>Hesabinizi silmek istediginizden emin misiniz?</DialogTitle>
                            <DialogDescription>
                                Hesabiniz silindiginde bagli tum kaynaklar ve veriler de kalici olarak silinir. Kalici
                                silme islemini onaylamak icin lutfen sifrenizi girin.
                            </DialogDescription>
                        </div>

                        <div class="grid gap-2">
                            <Label for="password" class="sr-only">Sifre</Label>
                            <Input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Sifrenizi girin"
                            />
                            <InputError message={errors.password} />
                        </div>

                        <DialogFooter class="gap-2">
                            <DialogClose>
                                <Button variant="secondary">
                                    Vazgec
                                </Button>
                            </DialogClose>

                            <Button
                                type="submit"
                                variant="destructive"
                                disabled={processing}
                                data-test="confirm-delete-user-button"
                            >
                                Hesabi kalici sil
                            </Button>
                        </DialogFooter>
                    {/snippet}
                </Form>
            </DialogContent>
        </Dialog>
    </div>
</div>
