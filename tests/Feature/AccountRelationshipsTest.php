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
