<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Schema;

class UserTest extends TestCase
{
    /**
     * Test if 'users' table exists
     *
     * @return void
     */
    public function testUserDatabaseExist()
    {
        $this->assertTrue(Schema::hasTable('users'));
    }

    /**
     * Test 'users' table columns
     *
     * @return void
     */
    public function testUserDatabaseColumnsExist()
    {
        $this->assertTrue(Schema::hasColumn('users','id'));
        $this->assertTrue(Schema::hasColumn('users','account_id'));
        $this->assertTrue(Schema::hasColumn('users','fname'));
        $this->assertTrue(Schema::hasColumn('users','lname'));
        $this->assertTrue(Schema::hasColumn('users','address'));
        $this->assertTrue(Schema::hasColumn('users','email'));
        $this->assertTrue(Schema::hasColumn('users','phone'));
        $this->assertTrue(Schema::hasColumn('users','gender'));

    }
}
