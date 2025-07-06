<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CreateTestUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test users for admin, service provider, and customer roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test users...');

        try {
            // Create roles if they don't exist
            $this->createRolesIfNotExist();

            // Create admin user
            $admin = $this->createUser(
                'Admin User',
                'admin@htroadside.com',
                'admin123',
                'admin'
            );

            // Create service provider user
            $provider = $this->createUser(
                'Service Provider',
                'provider@htroadside.com',
                'provider123',
                'service-provider'
            );

            // Create customer user
            $customer = $this->createUser(
                'Customer User',
                'customer@htroadside.com',
                'customer123',
                'customer'
            );

            $this->info('Test users created successfully!');
            $this->info('');
            $this->info('Admin: admin@htroadside.com / admin123');
            $this->info('Service Provider: provider@htroadside.com / provider123');
            $this->info('Customer: customer@htroadside.com / customer123');

        } catch (QueryException $e) {
            $this->error('Database error: ' . $e->getMessage());
            if (str_contains($e->getMessage(), 'Access denied')) {
                $this->error('Database connection issue. Please check your database credentials.');
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Create a user with the specified role
     */
    private function createUser($name, $email, $password, $roleName)
    {
        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $this->info("User {$email} already exists. Updating role...");
            $user = $existingUser;
        } else {
            // Create new user
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->email_verified_at = now();
            $user->save();
            $this->info("Created user: {$email}");
        }

        // Attach role to user
        $role = Role::where('slug', $roleName)->first();
        if ($role) {
            // Check if user already has this role
            $hasRole = DB::table('role_user')
                ->where('user_id', $user->id)
                ->where('role_id', $role->id)
                ->exists();
                
            if (!$hasRole) {
                DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $this->info("Assigned role '{$roleName}' to user {$email}");
            } else {
                $this->info("User {$email} already has role '{$roleName}'");
            }
        } else {
            $this->error("Role '{$roleName}' not found");
        }

        return $user;
    }

    /**
     * Create roles if they don't exist
     */
    private function createRolesIfNotExist()
    {
        $roles = ['admin', 'service-provider', 'customer'];
        
        foreach ($roles as $roleName) {
            $role = Role::where('slug', $roleName)->first();
            if (!$role) {
                $role = new Role();
                $role->name = ucfirst(str_replace('-', ' ', $roleName));
                $role->slug = $roleName;
                $role->save();
                $this->info("Created role: {$roleName}");
            }
        }
    }
}
