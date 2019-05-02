<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    /**
     * Test login
     *
     * @return void
     */
    public function testLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'testemail',
            'password' => 'testpassword',
            'api_token' => hash('sha256','testpassword')
        ]);
        $data = [
            'email' => $user->email,
            'password' => $user->password,
            'api_token' => 'testpassword'
        ];
        $response = $this->json('POST','/api/login',$data);
        $response->assertStatus(200);
        $this->assertTrue(Auth::check());

        $user->forceDelete();
    }
}
