<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;

class AccountCreateResourceApiTest extends TestCase
{
    /**
     * Test account create resource api 
     *
     * @return void
     */
    public function testAccountCreateResourceApi()
    {
        $data = [
            'username' => 'my_username',
            'password' => 'my_password',
        ];
        $response = $this->json('POST','/api/account',$data);
        $response->assertStatus(201); // created successfully
    }

    /**
     * Test account create resource api public duplicate username
     *
     * @return void
     */
    public function testAccountCreateResourceApiDuplicateUsername()
    {
        $data = [
            'username' => 'my_username',
            'password' => 'my_password',
        ];
        $response = $this->json('POST','/api/account',$data);
        $response->assertStatus(409); // conflict. account already exists
    }
}
