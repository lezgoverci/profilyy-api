<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;

use App\Role;
use App\Admin;
use App\User;

class AdminReadResourceApiTest extends TestCase
{
    /**
     * test read admin unauthenticated
     *
     * @return void
     */
    public function testReadAdminUnauthenticated()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $admin = factory(Admin::class)->create();
        $data = [
            'api_token' => Str::random(60),
            'role_id' => $role->id,
            'admin_id' => $admin->id
        ];

        $user = factory(User::class)->create(['api_token'=> Str::random(60)]);
        $response = $this->actingAs($user)->json('GET','/api/admin',$data);
        $response->assertStatus(401); 

        $admin->forceDelete();
        $role->forceDelete();
        $user->forceDelete();
    }

    /**
     * test read admin authenticated unauthorized
     *
     * @return void
     */
    public function testReadAdminAuthenticatedUnauthorized()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(60);
        $admin = factory(Admin::class)->create();
        $data = [
            'api_token' => $random ,
            'role_id' => $role->id,
            'admin_role' => $admin->id
        ];

        $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('GET','/api/admin',$data);
        $response->assertStatus(403); 

        $admin->forceDelete();
        $role->forceDelete();
        $user->forceDelete();
    }

    /**
     * test read admin authenticated authorized
     *
     * @return void
     */
    public function testReadAdminAuthenticatedAuthorized()
    {
        $role = factory(Role::class)->create(['name' => 'admin']);
        $random = Str::random(60);
        $admin = factory(Admin::class)->create();
        $data = [
            'api_token' => $random ,
            'role_id' => $role->id,
            'admin_id' => $admin->id
        ];

        $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('GET','/api/admin',$data);
        $response->assertStatus(200)->assertSee("created_at"); 

        $admin->forceDelete();
        $role->forceDelete();
        $user->forceDelete();
    }
}
