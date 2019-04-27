<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Role;
use App\Account;
use App\User;

use Illuminate\Support\Str;

class AdminCreateResourceApiTest extends TestCase
{
    /**
     * Test create admin unauthenticated
     *
     * @return void
     */
    public function testCreateAdminUnauthenticated()
    {
        $account = factory(Account::class)->create();
        $role = factory(Role::class)->create();
        $data = [
            'api_token' => null,
            'account_id' => $account->id,
            'role_id' => $role->id
        ];

        $response = $this->json('POST','/api/admin',$data);
        $response->assertStatus(401); // unauthenticated

        $role->forceDelete();
        $account->forceDelete();

    }

    /**
     * Test create admin authenticated and unauthorized
     *
     * @return void
     */
    public function testCreateAdminAuthenticatedUnauthorized()
    {
        $account = factory(Account::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(60);
        $data = [
            'api_token' => $random,
            'account_id' => $account->id,
            'role_id' => $role->id
        ];

        $user = factory(User::class)->create(['api_token' => hash('sha256', $random)]);
        $response = $this->json('POST','/api/admin',$data);
        $response->assertStatus(403); // forbidden

        $user->forceDelete();
        $role->forceDelete();
        $account->forceDelete();
    }

    /**
     * Test create admin authenticated and authorized
     *
     * @return void
     */
    public function testCreateAdminAuthenticatedAuthorized()
    {
        $account = factory(Account::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $random = Str::random(60);
        $data = [
            'api_token' => $random,
            'account_id' => $account->id,
            'role_id' => $role->id
        ];

        $user = factory(User::class)->create(['api_token' => hash('sha256', $random)]);
        $response = $this->json('POST','/api/admin',$data);
        $response->assertStatus(201); // created

        $user->forceDelete();
        $role->forceDelete();
        $account->forceDelete();
    }
}
