<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUpdateResourceApiTest extends TestCase
{
     /**
     * Test user update resource api unauthenticated
     *
     * @return void
     */
    public function testUserUpdateResourceApiUnauthenticated()
    {
        $data = [
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe2@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
            'role' => 'applicant',
            'api_token' => 'wrong_token'
        ];

        $user = factory(\App\User::class)->create(['api_token' => hash('sha256','my_token')]);
  
        $response = $this->actingAs($user)
                        ->json('PUT','/api/user',$data);
        $response->assertStatus(401); // unauthorized

    }

    /**
     * Test user update resource api authenticated and unauthorized
     *
     * @return void
     */
    public function testUserUpdateResourceApiAuthenticatedUnauthorized()
    {
        $data = [
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe3@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
            'role' => 'applicant',
            'api_token' => 'correct_token'
        ];
        $user = factory(\App\User::class)->create(['api_token' => hash('sha256','correct_token')]);
        $response = $this->actingAs($user)
                        ->json('PUT','/api/user',$data);
        $response->assertStatus(403); //forbidden
    }

    /**
     * Test user update resource api authenticated and authorized
     *
     * @return void
     */
    public function testUserUpdateResourceApiAuthenticatedAuthorized()
    {
        $data = [
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe4@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
            'role' => 'admin',
            'api_token' => 'authorized_token'
        ];
        $user = factory(\App\User::class)->create(['api_token' => hash('sha256','authorized_token')]);
        $response = $this->actingAs($user)
                        ->json('PUT','/api/user',$data);
        $response->assertStatus(201); // created successfully
    }
    
}
