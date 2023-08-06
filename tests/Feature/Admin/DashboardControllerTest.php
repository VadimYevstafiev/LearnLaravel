<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use AdminTestsFunctions;

    public function test_allow_see_dashboard_with_role_admin()
    {
        $response = $this->actingAs($this->getUser())->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_do_not_allow_see_dashboard_with_role_customer()
    {
        $response = $this->actingAs($this->getUser('customer'))->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }
}
