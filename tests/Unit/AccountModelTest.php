<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountModelTest extends TestCase
{
    /**
     * Test Account model exists
     *
     * @return void
     */
    public function testAccountModelExists()
    {
        $account = factory(\App\Account::class)->make();
        $this->assertNotNull($account);
    }

    /**
     * Test Account has a User relationship
     *
     * @return void
     */
    public function testAccountModelUserRelationship()
    {

        $account = factory(\App\Account::class)->make();
        $this->assertNotNull($account->user());
    }
}
