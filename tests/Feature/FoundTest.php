<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FoundTest extends TestCase
{
    public function testFound()
    {
        $response = $this->get('/found/');

        $response->assertOk();

    }

    public function testFoundStart()
    {
        
        $response = $this->get('/found/start/10/20');

        $response->assertOk();

        $response->assertJsonPath('data.id',10);
        
        $response->assertJsonPath('data.driver',"20");       

    }

    public function testFoundStop()
    {
               
        $response = $this->get('/found/stop/10/20');

        $response->assertOk();

        $response->assertJsonPath('data.driver',"0");    

    }
}
