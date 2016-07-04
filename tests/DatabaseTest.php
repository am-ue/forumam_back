<?php

namespace Tests;

use Illuminate\Support\Facades\DB;

class DatabaseTest extends TestCase
{

    public function testConnexion()
    {
        $db = DB::select('select "world!" as hello')[0];
        $this->assertEquals($db->hello, 'world!');
    }
}
