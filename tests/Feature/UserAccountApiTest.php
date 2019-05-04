<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Account;
use App\User;

class UserAccountApiTest extends TestCase
{
    /**
     * Test user account
     *
     * @return void
     */
    public function testUserAccount()
    {
    
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create(['user_id' => $user->id]);
        
        $data = [
            'api_token' => $user->api_token,
            'user_id'=> $user->id
        ];

        $response = $this->json('POST','/api/user/account', $data);
        
        $response->assertStatus(200);
        $response->assertSeeText("fname");

        $user->forceDelete();
        $account->forceDelete();
    }
}
