<script lang="ts">
    import type { Snippet } from 'svelte';
    import AuthLayout from '@/layouts/auth/AuthSimpleLayout.svelte';

    type AuthSceneType = 'auth' | 'login' | 'register';

    let {
        title = '',
        description = '',
        sceneType = 'auth',
        children,
    }: {
        title?: string;
        description?: string;
        sceneType?: AuthSceneType;
        children?: Snippet;
    } = $props();
</script>

<AuthLayout {title} {description} {sceneType}>
    {@render children?.()}
</AuthLayout>
