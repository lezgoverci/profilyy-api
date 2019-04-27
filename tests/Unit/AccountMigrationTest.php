<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Schema;

class AccountMigrationTest extends TestCase
{
    /**
     * Test if 'acounts' table exists
     *
     * @return void
     */
    public function testAccountDatabaseExist()
    {
        $this->assertTrue(Schema::hasTable('accounts'));
    }

    /**
     * Test 'accounts' table columns
     *
     * @return void
     */
    public function testAccountDatabaseColumnsExist()
    {
        $this->assertTrue(Schema::hasColumn('accounts','id'));
        $this->assertTrue(Schema::hasColumn('accounts','facebook_username'));
        $this->assertTrue(Schema::hasColumn('accounts','user_id'));
        $this->assertTrue(Schema::hasColumn('accounts','username'));
        $this->assertTrue(Schema::hasColumn('accounts','password'));
        $this->assertTrue(Schema::hasColumn('accounts','photo'));

    }
}
