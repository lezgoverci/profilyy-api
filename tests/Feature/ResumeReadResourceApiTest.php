<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Faker\Generator as Faker;

use Illuminate\Support\Str;

use App\Resume;
use App\User;
use App\Role;

class ResumeReadResourceApiTest extends TestCase
{
    /**
     * Test read resume unauthenticated
     *
     * @return void
     */
    public function testReadResumeUnauthenticated()
    {
        $resume = factory(Resume::class)->create();

        $data = [
            'api_token' => null,
            'resume_id' => $resume->id
        ];

        $response = $this->json('GET','/api/resume',$data);
        $response->assertStatus(401); // unauthenticated
        
        $resume->forceDelete();

    }

    /**
     * Test read resume authenticated
     *
     * @return void
     */
    public function testReadResumeAuthenticated()
    {
        $resume = factory(Resume::class)->create();
        $random = Str::random(60);

        $data = [
            'api_token' => $random,
            'resume_id' => $resume->id
        ];

        $user = factory(User::class)->create(['api_token' => hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('GET','/api/resume',$data);
        $response->assertStatus(200); // forbidden

        $user->forceDelete();
        $resume->forceDelete();

    }

    
}
