<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'slug' => 'admin',
                'description' => 'Full access to all system features',
                'permissions' => ['all']
            ],
            [
                'name' => 'service_provider',
                'slug' => 'service-provider',
                'description' => 'Access to provider features and service management',
                'permissions' => ['manage_services', 'view_requests', 'update_requests']
            ],
            [
                'name' => 'customer',
                'slug' => 'customer',
                'description' => 'Access to customer features and service requests',
                'permissions' => ['create_requests', 'view_own_requests']
            ]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
