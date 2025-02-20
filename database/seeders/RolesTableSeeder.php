<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['role' => 'Admin', 'active' => true, 'can_assign_roles' => true, 'create' => true, 'edit' => true, 'delete' => true, 'created_at' => now()],
            ['role' => 'General', 'active' => false, 'can_assign_roles' => true, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Major General', 'active' => false, 'can_assign_roles' => true, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Brigadier General', 'active' => false, 'can_assign_roles' => true, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Colonel', 'active' => false, 'can_assign_roles' => true, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Lieutenant Colonel', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Major', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Captain', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'First Class Officer', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Second Class Officer', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Third Class Officer', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Sergeant', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Corporal', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
            ['role' => 'Soldier', 'active' => false, 'can_assign_roles' => false, 'create' => false, 'edit' => false, 'delete' => false, 'created_at' => now()],
        ]);
    }
}
