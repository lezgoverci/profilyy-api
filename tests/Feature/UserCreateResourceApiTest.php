<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;
use App\User;

class UserCreateResourceApiTest extends TestCase
{

    /**
     * Test user create resource api public
     *
     * @return void
     */
    public function testUserCreateResourceApiPublic()
    {
        $data = [
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe1@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
        ];
        $response = $this->json('POST','/api/user',$data);
        $response->assertStatus(401); // unauthorized
    }

    /**
     * Test user create resource api authenticated 
     *
     * @return void
     */
    public function testUserCreateResourceApiAuthenticated()
    {
        $random = Str::random(60);
        $data = [
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe1@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
            'api_token' => $random
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256', $random )]);
        $response = $this->actingAs($user)->json('POST','/api/user',$data);
        $response->assertStatus(201); // Successfully created

        $user->forceDelete();
    }

    /**
     * Test user create resource api authenticated duplicate email
     *
     * @return void
     */
    public function testUserCreateResourceApiAuthenticatedDuplicateEmail()
    {
        $random = Str::random(60);
        $data = [
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => 'Butuan City, Philippines',
            'email' => 'john.doe1@email.com',
            'phone' => '1234 567 8900',
            'gender' => 'male',
            'api_token' => $random
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256', $random )]);
        $response = $this->actingAs($user)->json('POST','/api/user',$data);
        $response->assertStatus(409); // conflict. account already exists

        $user->forceDelete();
    }

}
