<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCreateResourceApiTest extends TestCase
{
    //CREATE

    $new_user = [
        'fname' => 'John',
        'lname' => 'Doe',
        'address' => 'Butuan City, Philippines',
        'email' => 'john.doe@email.com',
        'phone' => '1234 567 8900',
        'gender' => 'male'
    ];

    /**
     * Test user create resource api unauthenticated
     *
     * @return void
     */
    public function testUserCreateResourceApiUnauthenticated()
    {
        $reponse = $this->json('POST','/api/user',$new_user);
        $reponse->assertSuccessful();
    }

    /**
     * Test user create resource api authenticated and unauthorized
     *
     * @return void
     */
    public function testUserCreateResourceApiAuthenticatedUnauthorized()
    {
        $account = factory(\App\Account::class)->make(['role'=>'applicant']);

        $response = $this->actingAs($account->user())
                        ->withSession(['role' => $account->role])
                        ->json('POST','/api/user',$new_user);

        $response->assertForbidden();


    }

    /**
     * Test user create resource api authenticated and authorized
     *
     * @return void
     */
    public function testUserCreateResourceApiAuthenticatedAuthorized()
    {
        $account = factory(\App\Account::class)->make(['role' => 'admin']);
        $response = $this->actingAs($account->user())
                        ->withSession(['role' => $account->role])
                        ->json('POST','/api/user',$new_user);
        $response->assertSuccessful();
    }

}
