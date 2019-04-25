<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Role;
use App\Account;

class RoleModelTest extends TestCase
{
     /**
     * Test Role model exists
     *
     * @return void
     */
    public function testRoleModelExists()
    {
        $role = factory(Role::class)->make();
        $this->assertNotNull($role);
    }

     /**
     * Test Role relationship from Account
     *
     * @return void
     */
    public function testRoleRelationshipAccount()
    {
        $account = factory(Account::class)->create(['role_id' => 1]);
        $role = factory(Role::class)->create(['name' => 'admin']);
        $this->assertEquals('admin', $account->role->name);

    }

}
