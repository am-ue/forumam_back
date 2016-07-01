<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class DatabaseTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testConnexion()
    {
        $db = DB::select('select "world!" as hello')[0];
        $this->assertEquals($db->hello, 'world!');
    }
}
