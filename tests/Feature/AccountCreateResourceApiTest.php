<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
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

        $user = factory(User::class)->create();

        $data = [
            'fname' => 'my_fname',
            'lname' => 'my_lname',
            'address' => 'my_address',
            'phone' => 'my_phone',
            'gender' => 'male',
            'api_token' => $user->api_token
        ];
        $response = $this->json('POST','/api/account',$data);
     
        $response->assertStatus(201); // created successfully

        $user->forceDelete();
    }

    /**
     * Test account create resource api public duplicate username
     *
     * @return void
     */
    public function testAccountCreateResourceApiDuplicate()
    {
        $user = factory(User::class)->create(['account_id' => 1]);

        $data = [
            'fname' => 'my_fname',
            'lname' => 'my_lname',
            'address' => 'my_address',
            'phone' => 'my_phone',
            'gender' => 'male',
            'api_token' => $user->api_token
        ];
        $response = $this->json('POST','/api/account',$data);
        $response->assertStatus(409); // conflict. account already exists
    
        $user->forceDelete();
    }

}
