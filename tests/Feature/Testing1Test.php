<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Testing1Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_testing_1(): void
    {
        $response = $this->get('testing');
		$response->dump();
		//$response->dumpHeaders();
		//$response->dumpSession();

		//$response->dd();
        //$response->ddHeaders();
        //$response->ddBody();
        //$response->ddJson();
        //$response->ddSession();

        $response->assertStatus(200);
    }
}
