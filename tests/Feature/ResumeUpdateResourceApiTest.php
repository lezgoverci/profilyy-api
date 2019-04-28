<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;

use App\Resume;
use App\Applicant;
use App\Role;
use App\User;

class ResumeUpdateResourceApiTest extends TestCase
{
     /**
     * Test resume update resource api unauthenticated
     *
     * @return void
     */
    public function testResumeUpdateResourceApiUnauthenticated()
    {
        $faker = \Faker\Factory::create();
        $resume = factory(Resume::class)->create();
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(40);
        $data = [
            'resume_id' => $resume->id,
            'api_token' => Str::random(40),
            'role_id' => $role->id,
            'applicant_id' => $applicant->id,
            'experience' => $faker->paragraphs($nb = 3, $asText = true),
            'education' => $faker->paragraphs($nb = 3, $asText = true),
            'skills' => $faker->paragraphs($nb = 3, $asText = true)

        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('PUT','/api/resume',$data);

        $resume->refresh();
        $response->assertStatus(401); // success

        $user->forceDelete();
        $role->forceDelete();
        $applicant->forceDelete();
        $resume->forceDelete();
        

    }

    /**
     * Test resume update resource api authenticated
     *
     * @return void
     */
    public function testResumeUpdateResourceApiAuthenticated()
    {
        $faker = \Faker\Factory::create();
        $resume = factory(Resume::class)->create();
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(40);
        $data = [
            'resume_id' => $resume->id,
            'api_token' => $random,
            'role_id' => $role->id,
            'applicant_id' => $applicant->id,
            'experience' => $faker->paragraphs($nb = 3, $asText = true),
            'education' => $faker->paragraphs($nb = 3, $asText = true),
            'skills' => $faker->paragraphs($nb = 3, $asText = true)

        ];
        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('PUT','/api/resume',$data);

        $resume->refresh();
        $response->assertStatus(200); // success
        $this->assertEquals($data['experience'],$resume->experience);

        $user->forceDelete();
        $role->forceDelete();
        $applicant->forceDelete();
        $resume->forceDelete();
        

    }
}
