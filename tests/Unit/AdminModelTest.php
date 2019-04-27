<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Admin;


class AdminModelTest extends TestCase
{
    /**
     * Test Admin model exists
     *
     * @return void
     */
    public function testAdminModelExists()
    {
        $admin = factory(Admin::class)->create();
        $this->assertNotNull($admin);

        $admin->forceDelete();
    }
}
