<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;
use App\User;
use App\Applicant;
use App\Role;

class ApplicantReadResourceApiTest extends TestCase
{
    /**
     * test read applicant unauthenticated
     *
     * @return void
     */
    public function testReadApplicantUnauthenticated()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
       $data = [
           'api_token' => Str::random(60),
           'role_id' => $role->id
       ];

       $user = factory(User::class)->create(['api_token'=> Str::random(60)]);
       $response = $this->actingAs($user)->json('GET','/api/applicant',$data);
       $response->assertStatus(401); 

       $role->forceDelete();
       $user->forceDelete();
    }

    /**
     * test read applicant unauthorized
     *
     * @return void
     */
    public function testReadApplicantUnauthorized()
    {
        $random = Str::random(60);
        $role = factory(Role::class)->create(['name' => 'hr']);
        $data = [
           'api_token' => $random,
           'role_id' => $role->id
        ];

       $user = factory(User::class)->create(['api_token'=> hash('sha256', $random)]);
       $response = $this->actingAs($user)->json('GET','/api/applicant',$data);
       $response->assertStatus(403); 

       $role->forceDelete();
       $user->forceDelete();
    }

    /**
     * test read applicant authorized
     *
     * @return void
     */
    public function testReadApplicantAuthorized()
    {
        $applicant = factory(Applicant::class)->create();
        $random = Str::random(60);
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $data = [
           'api_token' => $random,
           'role_id' => $role->id,
           'id' => $applicant->id
        ];

       $user = factory(User::class)->create(['api_token'=> hash('sha256', $random)]);
       $response = $this->actingAs($user)->json('GET','/api/applicant',$data);
       $response->assertStatus(200); 

       $role->forceDelete();
       $applicant->forceDelete();
       $user->forceDelete();
       
    }
}
