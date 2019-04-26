<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Account;

class AccountUpdateResourceApiTest extends TestCase
{
     /**
     * Test account update resource api unauthenticated
     *
     * @return void
     */
    public function testAccountUpdateResourceApiUnauthenticated()
    {
        $data = [
            'password' => 'new_password',
            'id' => 1
        ];
  
        $response = $this->json('PUT','/api/account',$data);
        $response->assertStatus(401); // unauthorized
        

    }

     /**
     * Test account update resource api unauthorized
     *
     * @return void
     */
    public function testAccountUpdateResourceApiUnauthorized()
    {
        $data = [
            'password' => 'new_password',
            'id' => 1,
            'api_token' => Str::random(40)
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',Str::random(40))]);
        $response = $this->actingAs($user)->json('PUT','/api/account',$data);
        $response->assertStatus(401); // unauthorized

        $user->forceDelete();
        

    }

    /**
     * Test account update resource api authorized
     *
     * @return void
     */
    public function testAccountUpdateResourceApiAuthorized()
    {
        $account = factory(Account::class)->create();
        $random = Str::random(40);
        $data = [
            'password' => 'new_password',
            'id' => $account->id,
            'api_token' => $random
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('PUT','/api/account',$data);
        $account->refresh();
        $response->assertStatus(200); // success
        $this->assertTrue(Hash::check('new_password',$account->password));

        $user->forceDelete();
        $account->forceDelete();
        

    }
}
