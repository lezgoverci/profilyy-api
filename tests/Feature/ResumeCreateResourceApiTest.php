<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;

use App\Applicant;
use App\User;
use App\Role;

class ResumeCreateResourceApiTest extends TestCase
{
    /**
     * Test create resume unauthenticated
     *
     * @return void
     */
    public function testCreateResumeUnauthenticated()
    {

        $faker = \Faker\Factory::create();
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);

        $data = [
            'api_token' => null,
            'applicant_id' => $applicant->id,
            'role_id' => $role->id,
            'experience' => $faker->paragraphs($nb = 3, $asText = true),
            'education' => $faker->paragraphs($nb = 3, $asText = true),
            'skills' => $faker->paragraphs($nb = 3, $asText = true)
        ];

        $response = $this->json('POST','/api/resume',$data);
        $response->assertStatus(401); // unauthenticated

        $role->forceDelete();
        $applicant->forceDelete();

    }

    /**
     * Test create resume authenticated unauthorized
     *
     * @return void
     */
    public function testCreateResumeAuthenticatedUnauthorized()
    {
        $faker = \Faker\Factory::create();
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $random = Str::random(60);

        $data = [
            'api_token' => $random,
            'applicant_id' => $applicant->id,
            'role_id' => $role->id,
            'experience' => $faker->paragraphs($nb = 3, $asText = true),
            'education' => $faker->paragraphs($nb = 3, $asText = true),
            'skills' => $faker->paragraphs($nb = 3, $asText = true)
        ];

        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('POST','/api/resume',$data);
        $response->assertStatus(403); // forbidden

        $user->forceDelete();
        $role->forceDelete();
        $applicant->forceDelete();

    }

    /**
     * Test create resume authenticated authorized
     *
     * @return void
     */
    public function testCreateResumeAuthenticatedAuthorized()
    {
        $faker = \Faker\Factory::create();
        $applicant = factory(Applicant::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(60);

        $data = [
            'api_token' => $random,
            'applicant_id' => $applicant->id,
            'role_id' => $role->id,
            'experience' => $faker->paragraphs($nb = 3, $asText = true),
            'education' => $faker->paragraphs($nb = 3, $asText = true),
            'skills' => $faker->paragraphs($nb = 3, $asText = true)
        ];

        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('POST','/api/resume',$data);
        $response->assertStatus(201); // created

        $user->forceDelete();
        $role->forceDelete();
        $applicant->forceDelete();

    }
}
