<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $customerRole = Role::create(['name' => 'Customer', 'slug' => 'customer']);
        $providerRole = Role::create(['name' => 'Service Provider', 'slug' => 'service-provider']);
        
        // Create admin user
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->roles()->attach($adminRole);
        
        // Create customer user
        $customer = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => bcrypt('password')
        ]);
        $customer->roles()->attach($customerRole);
        
        // Create provider user
        $provider = User::factory()->create([
            'email' => 'provider@example.com',
            'password' => bcrypt('password')
        ]);
        $provider->roles()->attach($providerRole);
    }

    /** @test */
    public function admin_login_page_is_accessible()
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.admin-login');
    }

    /** @test */
    public function admin_can_login_and_access_admin_dashboard()
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
        
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'admin@example.com')->first());
    }

    /** @test */
    public function non_admin_users_cannot_access_admin_area()
    {
        // Login as customer
        $this->post('/login', [
            'email' => 'customer@example.com',
            'password' => 'password',
            'login_type' => 'customer'
        ]);
        
        // Try to access admin dashboard
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
        
        // Logout
        $this->post(route('logout'));
        
        // Login as provider
        $this->post('/login', [
            'email' => 'provider@example.com',
            'password' => 'password',
            'login_type' => 'vendor'
        ]);
        
        // Try to access admin dashboard
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_login_redirects_to_dashboard_if_already_authenticated_as_admin()
    {
        // Login as admin
        $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
        
        // Try to access login page while logged in
        $response = $this->get(route('admin.login'));
        $response->assertRedirect(route('admin.dashboard'));
    }
}
