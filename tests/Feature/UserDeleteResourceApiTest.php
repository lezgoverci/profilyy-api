<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\User;

class UserDeleteResourceApiTest extends TestCase
{
     /**
     * Test user delete resource api unauthenticated
     *
     * @return void
     */
    public function testUserDeleteResourceApiUnauthenticated()
    {
        $id = factory(User::class)->create()->id;
        $response = $this->json('DELETE', '/api/user');
        $response->assertStatus(401); // no token
    }

    /**
     * Test user delete resource api authenticated and unauthorized
     *
     * @return void
     */
    public function testUserDeleteResourceApiAuthenticatedUnauthorized()
    {
        $random = Str::random(40);
        $data = [
            'api_token' => $random,
            'role' => 'applicant',
            'id' => 1
        ];
        $user= factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE', '/api/user',$data);
        $response->assertStatus(403); // forbidden
    }

    /**
     * Test user delete resource api authenticated and authorized
     *
     * @return void
     */
    public function testUserDeleteResourceApiAuthenticatedAuthorized()
    {
        $random = Str::random(40);
        $data = [
            'api_token' => $random,
            'role' => 'admin',
            'id' => 1
        ];
        $user= factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE', '/api/user',$data);
        $response->assertStatus(204); // successfully deleted

        $deleted_user= User::find($data['id']);
        $this->assertEquals(null,$deleted_user);
    }
}
