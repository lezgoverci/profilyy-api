<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

use App\User;

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
            'api_token' => Str::random(40)
        ];

        $user = factory(User::class)->create(['api_token' => hash('sha256',Str::random(40))]);
  
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
        $random = Str::random(40);
        $data = [
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe3@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
            'role' => 'applicant',
            'api_token' => $random
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
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
        $random = Str::random(40);
        $data = [
            'id' => 2,
            'fname' => 'Jane',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe4@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
            'role' => 'admin',
            'api_token' => $random
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)
                        ->json('PUT','/api/user',$data);
        $response->assertStatus(200); // created successfully
        $this->assertEquals('Jane', User::find($data['id'])->fname);
    }
    
}
