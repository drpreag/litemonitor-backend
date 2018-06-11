<?php
/**
 *
 * End-to-end tests
 *
 */
namespace Tests\Feature;

use Tests\TestCase;

// use App\User;
// use App\Flapping;
// use App\Service;
// use App\Host;
// use App\Role;

class ApiTests extends TestCase
{
    public function testUsersApi()
    {
        // POST - insert new User
        $data = [
            "name" => "Test user foo",
            "email" => "foo@bar.com",
            "active" => 1,
            "role_id" => 1,
            "password" => "test12345"
        ];
        $response = $this->call('POST', '/api/user', $data);
        $response->assertStatus(201);
        $newUserId = $response->json(["data"])["id"];

        // PUT - update User
        $data = [
            "id" => $newUserId,
            "name" => "Changed nam bar",
            "email" => "newwfoo@bar.com",
            "active" => 0,
            "role_id" => 1,
            "password" => "DFGH67skfglasdkf"
        ];
        $response = $this->call('PUT', '/api/user', $data);
        $response->assertStatus(200);

        // GET user/{id} show User
        $response = $this->get('/api/user/'.$newUserId);
        $response->assertStatus(200);

        // GET users - list Users
        $response = $this->get('/api/users');
        $response->assertStatus(200);

        // DELETE user/{id} - delete User
        $response = $this->delete('/api/user/'.$newUserId);
        $response->assertStatus(200);
    }

    public function testHostsApi()
    {
        $response = $this->get('/api/hosts');
        $response->assertStatus(200);
        $response = $this->get('/api/host/1');
        $response->assertStatus(200);
        $response = $this->get('/api/host/1/services');
        $response->assertStatus(200);
    }

    public function testFlappingsApi()
    {
        $response = $this->get('/api/flappings');
        $response->assertStatus(200);
        $response = $this->get('/api/flappings/last');
        $response->assertStatus(200);
    }

    public function testServicesApi()
    {
        $response = $this->get('/api/services');
        $response->assertStatus(200);
        $response = $this->get('/api/service/1');
        $response->assertStatus(200);
        $response = $this->get('/api/service/1/observations');
        $response->assertStatus(200);
        $response = $this->get('/api/service-stats');
        $response->assertStatus(200);
    }

    public function testRolesApi()
    {
        $response = $this->get('/api/roles');
        $response->assertStatus(200);
        $response = $this->get('/api/role/1');
        $response->assertStatus(200);
    }

    public function testProbesApi()
    {
        $response = $this->get('/api/probes');
        $response->assertStatus(200);
    }
}
