<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Account;
use App\User;

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

    /**
     * Test Account user relationship
     *
     * @return void
     */
    public function testAccountRelationshipUser()
    {
        $user = factory(User::class)->create(['fname' => 'my_fname']);
        $account = factory(Account::class)->create(['user_id' => $user->id]);
        $this->assertEquals('my_fname',$account->user->fname);

        $account->forceDelete();
        $user->forceDelete();
    }
}
