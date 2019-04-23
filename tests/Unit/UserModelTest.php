<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    /**
     * Test User model exists
     *
     * @return void
     */
    public function testUserModelExists()
    {
        $user = factory(\App\User::class)->make();
        $this->assertNotNull($user);
    }

    /**
     * Test User has an Account relationship
     *
     * @return void
     */
    public function testUserModelHasAnAccountRelationship()
    {

        $users = factory(\App\User::class,1)
            ->create()
            ->each(function($user){
                $user->account()->save(factory(\App\Account::class)->make());
            });
        $this->assertNotNull($users);
    }
}
