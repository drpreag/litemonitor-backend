<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicAPIRoutesTests extends TestCase
{

    public function testUsersApi()
    {
        // $user = factory(\App\User::class)->create();
        $user = \App\User::find(1);
        $this->actingAs($user, 'api');

        // POST - insert new User
        $data = [
            "name" => "Test user",
            "email" => "foo@bar.com",
            "active" => 1,
            "role_id" => 1,
            "password" => "secret"
        ];
        $response = $this->call('POST', '/api/users', $data);
        $response->assertStatus(201);

        $newUserId = $response->json(["data"])["id"];

        // PUT - update User
        $data = [
            "id" => $newUserId,
            "name" => "Altered user name",
            "email" => "alter_foo@bar.com",
            "active" => 0,
            "role_id" => 1,
            "password" => "DFGH67skfglasdkf"
        ];
        $response = $this->call('PUT', '/api/users', $data);
        $response->assertStatus(200);

        // GET user/{id} show User
        $response = $this->get('/api/users/'.$newUserId);
        $response->assertStatus(200);

        // GET users - list Users
        $response = $this->get('/api/users');
        $response->assertStatus(200);

        // DELETE user/{id} - delete User
        $response = $this->delete('/api/users/'.$newUserId);
        $response->assertStatus(200); 
    }

    public function testHostsApi()
    {
        $user = \App\User::find(1);
        $this->actingAs($user, 'api');

        $response = $this->get('/api/hosts');
        $response->assertStatus(200);
        $response = $this->get('/api/hosts/1');
        $response->assertStatus(200);
        $response = $this->get('/api/hosts/1/services');
        $response->assertStatus(200);
    }

    public function testFlappingsApi()
    {
        $user = \App\User::find(1);
        $this->actingAs($user, 'api');

        $response = $this->get('/api/flappings');
        $response->assertStatus(200);
        $response = $this->get('/api/flappings/last');
        $response->assertStatus(200);
    }

    public function testServicesApi()
    {
        $user = \App\User::find(1);
        $this->actingAs($user, 'api');

        $response = $this->get('/api/services');
        $response->assertStatus(200);
        $response = $this->get('/api/services/1');
        $response->assertStatus(200);
        $response = $this->get('/api/services/1/observations');
        $response->assertStatus(200);
        $response = $this->get('/api/services-stats');
        $response->assertStatus(200);
    }

    public function testRolesApi()
    {
        $user = \App\User::find(1);
        $this->actingAs($user, 'api');

        $response = $this->get('/api/roles');
        $response->assertStatus(200);
        $response = $this->get('/api/roles/1');
        $response->assertStatus(200);
    }

    public function testProbesApi()
    {
        $user = \App\User::find(1);
        $this->actingAs($user, 'api');

        $response = $this->get('/api/probes');
        $response->assertStatus(200);
    }
    
    public function testStatsApi()
    {
        $user = \App\User::find(1);
        $this->actingAs($user, 'api');

        $response = $this->get('/api/hosts-stats');
        $response->assertStatus(200);
        $response = $this->get('/api/services-stats');
        $response->assertStatus(200);
    }
    
}
