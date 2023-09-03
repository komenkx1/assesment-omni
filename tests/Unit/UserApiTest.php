<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UserApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test index method.
     */
    public function testGetAllData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/user');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'telepon',
                ],
            ],
        ]);
    }

    /**
     * Test store method.
     */
    public function testStore()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'telepon' => '08123456789',
            'password' => 'password',
        ];

        $response = $this->post('/api/user', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'telepon',
            ],
        ]);
    }

    /**
     * Test show method.
     */
    public function testShow()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/user/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'telepon' => $user->telepon,
            ],
        ]);
    }

    /**
     * Test update method.
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'dsaasd@da.com',
            'telepon' => '08123456789',
        ];

        $response = $this->patch('/api/user/' . $user->id, $data);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => 'Jane Doe',
                'email' => $user->email,
                'telepon' => $user->telepon,
            ],
        ]);
    }

    /**
     * Test destroy method.
     */
    public function testDestroy()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete('/api/user/' . $user->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
