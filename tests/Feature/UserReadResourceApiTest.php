<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

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
        $random = Str::random(40);
        $data = [
            'api_token' => $random,
            'role' => 'applicant'
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
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
        $random = Str::random(40);
        $data = [
            'api_token' => $random,
            'role' => 'admin'
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
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
        $random = Str::random(40);
        $data = [
            'api_token' => $random
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('GET','/api/user/2',$data);
        $response->assertStatus(200); // success
    }
}
