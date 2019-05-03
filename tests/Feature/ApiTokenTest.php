<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class ApiTokenTest extends TestCase
{
    /**
     * test token update invalid
     *
     * @return void
     */
    public function testTokenUpdateInvalid()
    {
        $input = [
            'email' => "myemail2@email.com",
            'password' => "mypassword2"
        ];
        $user = $this->json('POST','/api/register',$input);

        $data = [ 
            'email' => $input['email'],
            'password' =>  'wrongpassword',
            'api_token' => null
        ];

        $response = $this->json('POST','/api/authenticate',$data);

        $response->assertStatus(403);
        $response->assertSeeText("Invalid username or password");

        User::where('email', $data['email'])->first()->forceDelete();

    }

    /**
     * test token update
     *
     * @return void
     */
    public function testTokenUpdate()
    {
        $input = [
            'email' => "myemail2@email.com",
            'password' => "mypassword2"
        ];
        $user = $this->json('POST','/api/register',$input);

        $data = [ 
            'email' => $input['email'],
            'password' =>  $input['password'],
            'api_token' => null
        ];

        $response = $this->json('POST','/api/authenticate',$data);

        $response->assertSeeText("Token updated");
        $response->assertSeeText("access_token");

        User::where('email', $data['email'])->first()->forceDelete();
    }
}
