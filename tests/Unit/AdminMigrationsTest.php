<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Schema;

class AdminMigrationsTest extends TestCase
{
    /**
     * Test if 'admins' table exists
     *
     * @return void
     */
    public function testAdminsDatabaseExist()
    {
        $this->assertTrue(Schema::hasTable('admins'));
    }

    /**
     * Test 'admins' table columns
     *
     * @return void
     */
    public function testAdminsDatabaseColumnsExist()
    {
        $this->assertTrue(Schema::hasColumn('admins','id'));
        $this->assertTrue(Schema::hasColumn('admins','role_id'));
        $this->assertTrue(Schema::hasColumn('admins','account_id'));
    }
}
