<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Account;

class AccountRelationshipsTest extends TestCase
{
    /**
     * Test Account role relationship
     *
     * @return void
     */
    public function testAccountRelationshipRole()
    {
        $account = factory(Account::class)->create(['role_id' => 1]);
        $this->assertEquals('admin',$account->role->name);

        $account->forceDelete();
    }
}
