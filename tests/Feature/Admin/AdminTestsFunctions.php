<?php

namespace Tests\Feature\Admin;

use App\Models\User;

trait AdminTestsFunctions
{
    protected function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    protected function getUser(string $role = 'admin'): User
    {
        return User::role($role)->first();
    }
}
