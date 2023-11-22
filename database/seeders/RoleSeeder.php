<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;  
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'SuperAdmin']);
        $role2 = Role::create(['name' => 'Administrador']);
        $role3 = Role::create(['name' => 'Urbano']);
        $role4 = Role::create(['name' => 'Auxiliar Urbano']);
        $role5 = Role::create(['name' => 'Clasificacion']);
        $role6 = Role::create(['name' => 'Auxiliar Clasificacion']);
        $role12 = Role::create(['name' => 'Adminsion']);
        $role12 = Role::create(['name' => 'Auxiliar Adminsion']);
        $role7 = Role::create(['name' => 'Despacho']);
        $role8 = Role::create(['name' => 'Auxiliar Despacho']);
        $role9 = Role::create(['name' => 'Enlace']);
        $role10 = Role::create(['name' => 'Expedicion']);
        $role10 = Role::create(['name' => 'Auxiliar Expedicion']);
        $role11 = Role::create(['name' => 'Ventanilla']);
        $role12 = Role::create(['name' => 'Almacen']);
        $role12 = Role::create(['name' => 'Auxiliar Almacen']);
        $role13 = Role::create(['name' => 'Cartero']);
        $role14 = Role::create(['name' => 'Operador']);
        $role14 = Role::create(['name' => 'Auxiliar Operador']);
        $role15 = Role::create(['name' => 'Cajero']);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'users.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.delete'])->syncRoles([$role1,$role2]);

        // Permission::create(['name' => 'packages.index'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6]);
        Permission::create(['name' => 'packages.delete'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name' => 'packages.clasificacion'])->syncRoles([$role1,$role2,$role5,$role6]);
        Permission::create(['name' => 'packages.ventanilla'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name' => 'packages.redirigidos'])->syncRoles([$role1,$role2,$role5,$role6]);
        Permission::create(['name' => 'packages.carteros'])->syncRoles([$role1,$role2,$role13]);
        
    }
}
