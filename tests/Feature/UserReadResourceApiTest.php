<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class UserReadResourceApiTest extends TestCase
{
     /**
     * Test user read all resource api unauthenticated
     *
     * @return void
     */
    public function testUserReadAllResourceApiUnauthenticated()
    {
        $response = $this->json('GET','/api/user');
        $response->assertStatus(401); // no api token
    }

    /**
     * Test user read all resource api authenticated and unauthorized
     *
     * @return void
     */
    public function testUserReadAllResourceApiAuthenticatedUnauthorized()
    {
        $data = [
            'api_token' => 'my_token',
            'role' => 'applicant'
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256','my_token')]);
        $response = $this->actingAs($user)->json('GET','/api/user',$data);
        $response->assertStatus(403); // forbidden
    }

    /**
     * Test user read all resource api authenticated and authorized
     *
     * @return void
     */
    public function testUserReadAllResourceApiAuthenticatedAuthorized()
    {
        $data = [
            'api_token' => 'admin_token',
            'role' => 'admin'
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256','admin_token')]);
        $response = $this->actingAs($user)->json('GET','/api/user',$data);
        $response->assertStatus(200); // success
    }

    /**
     * Test user read one resource api unauthenticated
     *
     * @return void
     */
    public function testUserReadOneResourceApiUnauthenticated()
    {
        $response = $this->json('GET','/api/user/1');
        $response->assertStatus(401); // no api token
    }

    /**
     * Test user read one resource api authenticated 
     *
     * @return void
     */
    public function testUserReadOneResourceApiAuthenticated()
    {
        $data = [
            'api_token' => 'any_token'
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256','any_token')]);
        $response = $this->actingAs($user)->json('GET','/api/user/1',$data);
        $response->assertStatus(200); // success
    }
}
