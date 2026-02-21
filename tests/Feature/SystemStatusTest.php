<?php

use App\Models\User;

test('guests are redirected from system status endpoint', function () {
    $response = $this->get(route('api.system.status'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view system status', function () {
    config()->set('app.version', '1.0.0-test');
    config()->set('license.enabled', false);
    config()->set('version.check_url', null);

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->getJson(route('api.system.status'));

    $response->assertOk();
    $response->assertJsonPath('app.version', '1.0.0-test');
    $response->assertJsonPath('license.enabled', false);
    $response->assertJsonStructure([
        'app' => ['name', 'version', 'environment'],
        'license' => ['enabled', 'valid', 'enforced', 'source', 'message', 'key_last4', 'checked_at'],
        'version' => ['current_version', 'latest_version', 'update_available', 'source', 'message', 'download_url', 'notes_url', 'checked_at'],
    ]);
});
