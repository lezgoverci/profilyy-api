<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\User;
use App\Account;

class AccountDeleteResourceApiTest extends TestCase
{
     /**
     * Test account delete resource api unauthenticated
     *
     * @return void
     */
    public function testAccountDeleteResourceApiUnauthenticated()
    {
        $account = factory(Account::class)->create();
        $data = [
            'api_token' => null,
            'role' => 'applicant',
            'id' => $account->id
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',Str::random(60))]);
        $response = $this->actingAs($user)->json('DELETE', '/api/account',$data);
        $response->assertStatus(401); // no token

        $user->forceDelete();
        $account->forceDelete();
    }

     /**
     * Test account delete resource api authenticated and unauthorized
     *
     * @return void
     */
    public function testAccountDeleteResourceApiAuthenticatedUnauthorized()
    {
        $account = factory(Account::class)->create();
        $data = [
            'api_token' => Str::random(60),
            'role' => 'hr',
            'id' => $account->id
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',Str::random(60))]);
        $response = $this->actingAs($user)->json('DELETE', '/api/account',$data);
        $response->assertStatus(401); // wrong token

        $user->forceDelete();
        $account->forceDelete();
    }

     /**
     * Test account delete resource api authenticated and authorized
     *
     * @return void
     */
    public function testAccountDeleteResourceApiAuthenticatedAuthorized()
    {
        $random = Str::random(60);
        $account = factory(Account::class)->create();
        $data = [
            'api_token' => $random,
            'role' => 'admin',
            'id' => $account->id
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE', '/api/account',$data);
        $response->assertStatus(204); // success

        $deleted_account = Account::find($data['id']);
        $this->assertEquals(null,$deleted_account);

        $user->forceDelete();
        $account->forceDelete();
    }
}
