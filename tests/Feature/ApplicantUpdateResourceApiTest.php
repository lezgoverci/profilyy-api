<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;

use App\User;
use App\Applicant;
use App\Role;

class ApplicantUpdateResourceApiTest extends TestCase
{
    /**
     * test update applicant unauthenticated
     *
     * @return void
     */
    public function testUpdateApplicantUnauthenticated()
    {
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
       $data = [
           'api_token' => Str::random(60),
           'role_id' => $role->id,
           'resume_id' => 1,
           'id' => $applicant->id
       ];

       $user = factory(User::class)->create(['api_token'=> Str::random(60)]);
       $response = $this->actingAs($user)->json('PUT','/api/applicant',$data);
       $response->assertStatus(401); 

       $role->forceDelete();
       $user->forceDelete();
       $applicant->forceDelete();
    }

    /**
     * test update applicant authenticated and unauthorized
     *
     * @return void
     */
    public function testUpdateApplicantAuthenticatedUnauthorized()
    {
        $random = Str::random(60);
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
       $data = [
           'api_token' => $random,
           'role_id' => $role->id,
           'resume_id' => 1,
           'id' => $applicant->id
       ];

       $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
       $response = $this->actingAs($user)->json('PUT','/api/applicant',$data);
       $response->assertStatus(403); 

       $role->forceDelete();
       $user->forceDelete();
       $applicant->forceDelete();
    }

    /**
     * test update applicant authenticated and authorized
     *
     * @return void
     */
    public function testUpdateApplicantAuthenticatedAuthorized()
    {
        $random = Str::random(60);
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
       $data = [
           'api_token' => $random,
           'role_id' => $role->id,
           'resume_id' => 1,
           'id' => $applicant->id
       ];

       $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
       $response = $this->actingAs($user)->json('PUT','/api/applicant',$data);
       $applicant->refresh();
       $response->assertStatus(200); 
       $this->assertEquals($data['resume_id'],$applicant->resume_id);
      
       $role->forceDelete();
       $user->forceDelete();
       $applicant->forceDelete();
    }
}
