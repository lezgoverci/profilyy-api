<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Account;

class AccountModelTest extends TestCase
{
    /**
     * Test Account model exists
     *
     * @return void
     */
    public function testAccountModelExists()
    {
        $account = factory(Account::class)->create();
        $this->assertNotNull($account);

        $account->forceDelete();
    }
}
