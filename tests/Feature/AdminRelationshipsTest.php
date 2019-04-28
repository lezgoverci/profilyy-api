<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Admin;
use App\Account;
use App\Role;

class AdminRelationshipsTest extends TestCase
{
    /**
     * Test admin account relationship
     *
     * @return void
     */
    public function testAdminAccountRelationship()
    {
        $admin = factory(Admin::class)->create();
        $account = factory(Account::class)->create();

        $admin->account()->associate($account);

        $this->assertEquals($account->username, $admin->account->username);

        $admin->forceDelete();
        $account->forceDelete();
    }

    /**
     * Test admin role relationship
     *
     * @return void
     */
    public function testAdminRoleRelationship()
    {
        $admin = factory(Admin::class)->create();
        $role = factory(Role::class)->create();

        $admin->role_id = $role->id;


        $this->assertEquals($role->name, $admin->role->name);

        $admin->forceDelete();
        $role->forceDelete();
    }
}
