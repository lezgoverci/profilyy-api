<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Str;

use App\Role;
use App\Admin;
use App\User;

class AdminDeleteResourceApiTest extends TestCase
{
     /**
     * test delete admin unauthenticated 
     *
     * @return void
     */
    public function testDeleteAdminUnauthenticated()
    {
        $admin = factory(Admin::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $data = [
            'api_token' => Str::random(60),
            'role_id' => $role->id,
            'admin_id' => $admin->id
        ];

        $user = factory(User::class)->create(['api_token'=> hash('sha256',Str::random(60))]);
        $response = $this->actingAs($user)->json('DELETE','/api/admin',$data);
        $response->assertStatus(401); 

        $role->forceDelete();
        $user->forceDelete();
        $admin->forceDelete();
    }

     /**
     * test delete admin authenticated unauthorized
     *
     * @return void
     */
    public function testDeleteAdminAuthenticatedUnauthorized()
    {
        $admin = factory(Admin::class)->create();
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $random = Str::random(60);
        $data = [
            'api_token' => $random,
            'role_id' => $role->id,
            'admin_id' => $admin->id
        ];

        $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE','/api/admin',$data);
        $response->assertStatus(403); 

        $role->forceDelete();
        $user->forceDelete();
        $admin->forceDelete();
    }

     /**
     * test delete admin authenticated unauthorized
     *
     * @return void
     */
    public function testDeleteAdminAuthenticatedAuthorized()
    {
        $admin = factory(Admin::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $random = Str::random(60);
        $data = [
            'api_token' => $random,
            'role_id' => $role->id,
            'admin_id' => $admin->id
        ];

        $user = factory(User::class)->create(['api_token'=> hash('sha256',$random)]);
        $response = $this->actingAs($user)->json('DELETE','/api/admin',$data);
        $response->assertStatus(204); 

        $deleted_admin = Admin::find($data['admin_id']);
        $this->assertEquals(null,$deleted_admin);

        $role->forceDelete();
        $user->forceDelete();
        $admin->forceDelete();
    }
}
