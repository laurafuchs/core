<?php

use Cachet\Cachet;
use Workbench\Database\Factories\UserFactory;

it('renders the theme toggle on the status page', function () {
    $this->get(route('cachet.status-page'))
        ->assertOk()
        ->assertSee('cachet-theme-toggle', escape: false)
        ->assertSee("localStorage.getItem('theme') ?? 'system'", escape: false);
});

it('renders the theme switcher in the dashboard topbar', function () {
    $user = UserFactory::new()->create([
        'is_admin' => true,
    ]);

    $this
        ->actingAs($user)
        ->get(Cachet::dashboardPath())
        ->assertOk()
        ->assertSee('fi-theme-switcher', escape: false);
});
