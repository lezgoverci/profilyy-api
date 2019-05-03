<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

use App\User;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{

    /**
     * Test register
     *
     * @return void
     */
    public function testRegister()
    {

        $data = [
            'email' => "myemail@email.com",
            'password' => "mypassword"
        ];
        $response = $this->json('POST','/api/register',$data);
        $response->assertStatus(201);
        $response->assertSeeText("created_at");

        User::where('email', $data['email'])->first()->forceDelete();

    }
    
    /**
     * Test login
     *
     * @return void
     */
    public function testLogin()
    {

        $data = [
            'email' => "myemail2@email.com",
            'password' => "mypassword2"
        ];
        $user = $this->json('POST','/api/register',$data);
        $user_data = $user->getData();

        $data2 = [
            'email' => 'myemail2@email.com',
            'password' => 'mypassword2',
            'api_token' => $user_data->access_token,
        ];

        $response = $this->json('POST','/api/login',$data2);

        $response->assertStatus(200);
        $this->assertTrue(Auth::check());

        User::where('email', $data['email'])->first()->forceDelete();


    }

     /**
     * Test login unauthenticated
     *
     * @return void
     */
    public function testLoginUnauthenticated()
    {

        $data = [
            'email' => "myemail3@email.com",
            'password' => "mypassword2"
        ];
        $user = $this->json('POST','/api/register',$data);
        $user_data = $user->getData();
        $data2 = [
            'email' => 'myemail3@email.com',
            'password' => 'mypassword2',
            'api_token' => null,
        ];

        $response = $this->json('POST','/api/login',$data2);

        $response->assertStatus(401);


        User::where('email', $data['email'])->first()->forceDelete();


    }

     /**
     * Test login unauthorized
     *
     * @return void
     */
    public function testLoginUnauthorized()
    {

        $user1_input = [
            'email' => "myemail4@email.com",
            'password' => "mypassword4"
        ];
        $user1 = $this->json('POST','/api/register',$user1_input);

       // $user1_data = $user->getData();

        $user2_input = [
            'email' => "myemail5@email.com",
            'password' => "mypassword5"
        ];
        $user2 = $this->json('POST','/api/register',$user2_input);

        $user2_data = $user2->getData();

        $data = [
            'email' => $user1_input['email'],
            'password' =>  $user1_input['password'],
            'api_token' => $user2_data->access_token
        ];

        $response = $this->json('POST','/api/login',$data);
        $response->assertStatus(403);
        $response->assertSeeText("Unauthorized");


        User::where('email', $user1_input['email'])->first()->forceDelete();
        User::where('email', $user2_input['email'])->first()->forceDelete();


    }

    /**
     * Test login email not found
     *
     * @return void
     */
    public function testLoginEmailNotFound()
    {

        $input = [
            'email' => "myemail6@email.com",
            'password' => "mypassword6"
        ];
        $user = $this->json('POST','/api/register',$input);

        $user_data = $user->getData();

        $data = [
            'email' => "wrongemail@email.com",
            'password' =>  $input['password'],
            'api_token' => $user_data->access_token
        ];

        $response = $this->json('POST','/api/login',$data);
        $response->assertStatus(404);
        $response->assertSeeText("Email not found");


        User::where('email', $input['email'])->first()->forceDelete();

    }

    

}
