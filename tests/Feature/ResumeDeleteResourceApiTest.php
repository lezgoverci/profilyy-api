<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;

use App\Resume;
use App\Role;
use App\User;

class ResumeDeleteResourceApiTest extends TestCase
{
   /**
     * Test resume delete resource api unauthenticated
     *
     * @return void
     */
    public function testResumeDeleteResourceApiUnauthenticated()
    {
        $resume = factory(Resume::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(40);
        $data = [
            'resume_id' => $resume->id,
            'api_token' => Str::random(40),
            'role_id' => $role->id

        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE','/api/resume',$data);

        $response->assertStatus(401); // unauthenticated

        $user->forceDelete();
        $role->forceDelete();
        $resume->forceDelete();
        

    }

    /**
     * Test resume delete resource api authenticated
     *
     * @return void
     */
    public function testResumeDeleteResourceApiAuthenticated()
    {
        $resume = factory(Resume::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(60);
        $data = [
            'resume_id' => $resume->id,
            'api_token' => $random,
            'role_id' => $role->id

        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE','/api/resume',$data);

        $response->assertStatus(204); // deleted
        $this->assertNull(Resume::find($data['resume_id']));

        $user->forceDelete();
        $role->forceDelete();
        $resume->forceDelete();
        

    }
}
