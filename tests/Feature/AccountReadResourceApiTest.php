<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

use App\User;

class AccountReadResourceApiTest extends TestCase
{
    /**
     * test account read unauthenticated
     *
     * @return void
     */
    public function testAccountReadUnauthenticated()
    {
        $response = $this->json('GET','/api/account/2');
        $response->assertStatus(401); //no api token
    }

    /**
     * test account read authenticated
     *
     * @return void
     */
    public function testAccountReadAuthenticated()
    {
        $random = Str::random(60);
        $data = [
            'api_token' => $random
        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('GET','/api/account/1',$data);

        $response->assertStatus(200); //success
    }
}
