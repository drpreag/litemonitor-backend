<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTests extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicApi()
    {
        $response = $this->get('/api/flappings');
        $response->assertStatus(200);
        $response = $this->get('/api/flappings/last');
        $response->assertStatus(200);

        $response = $this->get('/api/hosts');
        $response->assertStatus(200);
        $response = $this->get('/api/host/1');
        $response->assertStatus(200);
        $response = $this->get('/api/host/1/services');
        $response->assertStatus(200);
        
        $response = $this->get('/api/services');
        $response->assertStatus(200);
        $response = $this->get('/api/service/1');
        $response->assertStatus(200);
        $response = $this->get('/api/service/1/observations');
        $response->assertStatus(200);  
        $response = $this->get('/api/service-stats');
        $response->assertStatus(200);
        
        $response = $this->get('/api/roles');
        $response->assertStatus(200);
        $response = $this->get('/api/role/1');
        $response->assertStatus(200);

        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $response = $this->get('/api/user/1');
        $response->assertStatus(200);

        $response = $this->get('/api/probes');
        $response->assertStatus(200);
        
    }
    
}
