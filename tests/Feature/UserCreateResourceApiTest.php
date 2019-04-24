<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCreateResourceApiTest extends TestCase
{
    //CREATE  

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
        $response->assertStatus(201); // created successfully
    }

    /**
     * Test user create resource api public duplicate email
     *
     * @return void
     */
    public function testUserCreateResourceApiPublicDuplicateEmail()
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
        $response->assertStatus(409); // conflict. account already exists
    }

}
