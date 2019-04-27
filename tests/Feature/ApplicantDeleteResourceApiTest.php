<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;
use App\User;
use App\Applicant;
use App\Role;

class ApplicantDeleteResourceApiTest extends TestCase
{
     /**
     * test delete applicant unauthenticated
     *
     * @return void
     */
    public function testDeleteApplicantUnauthenticated()
    {
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
       $data = [
           'api_token' => null,
           'role_id' => $role->id,
           'id' => $applicant->id
       ];

       $user = factory(User::class)->create(['api_token'=> Str::random(60)]);
       $response = $this->actingAs($user)->json('DELETE','/api/applicant',$data);
       $response->assertStatus(401); 

       $role->forceDelete();
       $user->forceDelete();
       $applicant->forceDelete();
    }

     /**
     * test delete applicant authenticated and unauthorized
     *
     * @return void
     */
    public function testDeleteApplicantAuthenticatedUnauthorized()
    {
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $random = Str::random(60);
       $data = [
           'api_token' => $random,
           'role_id' => $role->id,
           'id' => $applicant->id
       ];

       $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
       $response = $this->actingAs($user)->json('DELETE','/api/applicant',$data);
       $response->assertStatus(403); 

       $role->forceDelete();
       $user->forceDelete();
       $applicant->forceDelete();
    }

     /**
     * test delete applicant authenticated and authorized
     *
     * @return void
     */
    public function testDeleteApplicantAuthenticatedAuthorized()
    {
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(60);
       $data = [
           'api_token' => $random,
           'role_id' => $role->id,
           'id' => $applicant->id
       ];

       $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
       $response = $this->actingAs($user)->json('DELETE','/api/applicant',$data);
       $response->assertStatus(204); 

       $deleted_applicant = Applicant::find($data['id']);
        $this->assertEquals(null,$deleted_applicant);

        $role->forceDelete();
       $user->forceDelete();
       $applicant->forceDelete();
    }
}
