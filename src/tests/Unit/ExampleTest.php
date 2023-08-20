<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Shop;

class RouteAccessTest extends TestCase
{
        use RefreshDatabase;
    /**
     * Test access to all routes.
     *
     * @return void
     */

    /**
     * Test showAdminRegister method.
     *
     * @return void
     */
    public function testShowAdminRegister()
    {
        $response = $this->get('/admin/register');
        $response->assertStatus(200);
        $response->assertViewIs('admin_register');
    }

    /**
     * Test storeAdmin method with valid data.
     *
     * @return void
     */
    public function testStoreAdminWithValidData()
    {
        $shop = Shop::factory()->create();

        $data = [
            'role' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'shop_id' => $shop->id,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/admin/register', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/registered');

        $this->assertDatabaseHas('users', [
            'role' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'shop_id' => $shop->id,
        ]);
    }

    /**
     * Test storeAdmin method with invalid data.
     *
     * @return void
     */
    public function testStoreAdminWithInvalidData()
    {
        $data = [
            // Provide incomplete or invalid data here
        ];

        $response = $this->post('/admin/register', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors();

        // Make assertions for specific error messages
        // $response->assertSessionHasErrors('role');
        // $response->assertSessionHasErrors('name');
        // $response->assertSessionHasErrors('email');
        // ...

        $this->assertDatabaseCount('users', 0);
    }

    /**
     * Test showAdminRegistered method.
     *
     * @return void
     */
    public function testShowAdminRegistered()
    {
        $response = $this->get('/admin/registered');
        $response->assertStatus(200);
        $response->assertViewIs('admin_registered');
    }
}