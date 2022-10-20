<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        Permission::create(['name' => 'create','description'=>'create data']);
        Permission::create(['name' => 'update','description'=>'update data']);
        Permission::create(['name' => 'delete','description'=>'delete data']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('create');
        $role1->givePermissionTo('update');
        $role1->givePermissionTo('delete');

        $role2 = Role::create(['name' => 'staff']);
        $role2->givePermissionTo('create');
        $role2->givePermissionTo('update');

        $role3 = Role::create(['name' => 'teacher']);
        $role3->givePermissionTo('create');
        $role3->givePermissionTo('update');
        
        $user = \App\Models\User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);
        
        $user->assignRole($role1);

    }
}
