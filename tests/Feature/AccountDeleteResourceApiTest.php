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
        $id = factory(Account::class)->create()->id;
        $data = [
            'api_token' => null,
            'role' => 'applicant',
            'id' => $id
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',Str::random(60))]);
        $response = $this->actingAs($user)->json('DELETE', '/api/account',$data);
        $response->assertStatus(401); // no token
    }

     /**
     * Test account delete resource api authenticated and unauthorized
     *
     * @return void
     */
    public function testAccountDeleteResourceApiAuthenticatedUnauthorized()
    {
        $id = factory(Account::class)->create()->id;
        $data = [
            'api_token' => Str::random(60),
            'role' => 'hr',
            'id' => $id
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',Str::random(60))]);
        $response = $this->actingAs($user)->json('DELETE', '/api/account',$data);
        $response->assertStatus(401); // wrong token
    }

     /**
     * Test account delete resource api authenticated and authorized
     *
     * @return void
     */
    public function testAccountDeleteResourceApiAuthenticatedAuthorized()
    {
        $random = Str::random(60);
        $id = factory(Account::class)->create()->id;
        $data = [
            'api_token' => $random,
            'role' => 'admin',
            'id' => $id
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE', '/api/account',$data);
        $response->assertStatus(204); // success

        $deleted_account = Account::find($data['id']);
        $this->assertEquals(null,$deleted_account);
    }
}
