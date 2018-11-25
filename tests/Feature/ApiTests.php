<?php
/**
 *
 * Testing REST API interface
 *
 */
namespace App;

use Tests\TestCase;

class ApiTests extends TestCase
{
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjMyMzI4NDM1NzExMDBkYTY5YzYzZGFkNGNjNDU4MDk3NzNlMTFiZTE4ZTNiOWNjOThjZTBjZmU1ODNhMjFlZDEzNTcyNDVjMDIwODgyNDhkIn0.eyJhdWQiOiIyIiwianRpIjoiMzIzMjg0MzU3MTEwMGRhNjljNjNkYWQ0Y2M0NTgwOTc3M2UxMWJlMThlM2I5Y2M5OGNlMGNmZTU4M2EyMWVkMTM1NzI0NWMwMjA4ODI0OGQiLCJpYXQiOjE1NDMxMDQ4NzYsIm5iZiI6MTU0MzEwNDg3NiwiZXhwIjoxNTc0NjQwODc2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.NsRm7joEH148eQ5R6x7OvieH63hkfV-zuQLPdvw_7So0Ob2zFQK6ZWVXDFkxWAyrPwKvjzYwXEiW1sGCDqkVCmhiucb35By8xG0AW0fF092gIH3H4SNxNHmXlBKeJywTligdHMKkNUeWJTaLLNAHhWGgRNKdjcrFusPVxW1VeTqPEQrTBcDS_K3TLIc2TiSpR1amBRdhgCMTppyHCt-iNVlKreYPzK8kgoCZyQCn8GhgSdwk9En8UCCv9-b9orZNk1_6iH85Lba1ssGc-mQ4OkI6COJ2-3NrVfh9jNPQSTxzFM8U8Mmi8Mrt4y8_Uc7MPd1eQrYhyt_G_1ToQytRYra3msCrPTFIP-dCv7pk96uTgxXqXtweKWDPIZEYCa_Fbf4k7Sk1uBvqHdTFRfdWoA9nudI-JGIyiijdbIUO71Zqj0B-8H_qd6sPHKjhctnh2NsUzCsMYGN1PAF3rxgX3Lu8e4BMthiVd961HF7iV8edI14Nt0n8d06q2Z6qWvwfhlPaNMPNsDAKe5ES4-SmNt5snvsZjedy5FG70dcZ4FTETap9nbnhyplklo80z4PVc6h8vSdwpfr6qnPL93yhZ4GeCP6N3ditAVWI2ksLNdaztnlPJp1mEc5RgwPqsb0T215-0RO12UMEzUwXrtcxBav--Ot2gjUV82g7nCClh0U";

    public function testUsersApi()
    {
        // POST - insert new User
        $data = [
            "name" => "Test user",
            "email" => "foo@bar.com",
            "active" => 1,
            "role_id" => 1,
            "password" => "test12345"
        ];
        $response = $this->call('POST', '/api/users', $data, ['headers'=>['Authorization'=>'Bearer '.$this->token]]);
        $response->assertStatus(201);
        $newUserId = $response->json(["data"])["id"];

        // PUT - update User
        $data = [
            "id" => $newUserId,
            "name" => "Test User with Name",
            "email" => "new_foo@bar.com",
            "active" => 0,
            "role_id" => 1,
            "password" => "DFGH67skfglasdkf"
        ];
        $response = $this->call('PUT', '/api/users', $data, ['headers' => ['Authorization' => 'Bearer '.$this->token]]);
        $response->assertStatus(200);

        // GET user/{id} show User
        $response = $this->get('/api/users/'.$newUserId, [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);

        // GET users - list Users
        $response = $this->get('/api/users', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);

        // DELETE user/{id} - delete User
        $response = $this->delete('/api/users/'.$newUserId, [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
    }

    public function testHostsApi()
    {
        $response = $this->get('/api/hosts', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/hosts/1', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/hosts/1/services', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
    }

    public function testFlappingsApi()
    {
        $response = $this->get('/api/flappings', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/flappings/last', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
    }

    public function testServicesApi()
    {
        $response = $this->get('/api/services', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/services/1', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/services/1/observations', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/services-stats', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
    }

    public function testRolesApi()
    {
        $response = $this->get('/api/roles', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/roles/1', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
    }

    public function testProbesApi()
    {
        $response = $this->get('/api/probes', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
    }
    
    public function testStatsApi()
    {
        $response = $this->get('/api/hosts-stats', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
        $response = $this->get('/api/services-stats', [], [], ['HTTP_Authorization' => $this->token]);
        $response->assertStatus(200);
    }
}
