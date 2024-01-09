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
        $role7 = Role::create(['name' => 'Cartero']);
        $role8 = Role::create(['name' => 'Adminsion']);
        $role9 = Role::create(['name' => 'Auxiliar Adminsion']);
        $role10 = Role::create(['name' => 'Expedicion']);
        $role11 = Role::create(['name' => 'Auxiliar Expedicion']);
        $role12 = Role::create(['name' => 'Casillas']);
        $role13 = Role::create(['name' => 'ECA']);
        $role14 = Role::create(['name' => 'DND']);
        $role15 = Role::create(['name' => 'EMS']);
        $role16 = Role::create(['name' => 'Encargado']);
        // $role10 = Role::create(['name' => 'Despacho']);
        // $role11 = Role::create(['name' => 'Auxiliar Despacho']);
        // $role12 = Role::create(['name' => 'Enlace']);
        // $role16 = Role::create(['name' => 'Almacen']);
        // $role17 = Role::create(['name' => 'Auxiliar Almacen']);
        // $role19 = Role::create(['name' => 'Operador']);
        // $role20 = Role::create(['name' => 'Auxiliar Operador']);
        // $role21 = Role::create(['name' => 'Cajero']);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'users.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.delete'])->syncRoles([$role1,$role2]);
        
        Permission::create(['name' => 'packages.clasificacion'])->syncRoles([$role1,$role2,$role5,$role6]);
        Permission::create(['name' => 'packages.entregasclasificacion'])->syncRoles([$role1,$role2,$role5,$role6]);
        Permission::create(['name' => 'packages.ventanilla'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name' => 'packages.delete'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name' => 'packages.redirigidos'])->syncRoles([$role1,$role2,$role10]);
        Permission::create(['name' => 'packages.distribuicioncartero'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'packages.carteros'])->syncRoles([$role1,$role2,$role7]);
        Permission::create(['name' => 'packages.inventariocartero'])->syncRoles([$role7]);
        Permission::create(['name' => 'packages.inventario'])->syncRoles([$role1,$role2,$role5,$role6,$role3,$role4,$role12,$role13,$role7]);
        Permission::create(['name' => 'packages.prerezago'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'packages.rezago'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'packages.urbano'])->syncRoles([$role1,$role2,$role3,$role7]);
        Permission::create(['name' => 'packages.generalcartero'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'packages.casillas'])->syncRoles([$role1,$role2,$role12]);
        Permission::create(['name' => 'packages.casillas'])->syncRoles([$role1,$role2,$role13]);
        Permission::create(['name' => 'national.total'])->syncRoles([$role1,$role2,$role8,$role9,$role10,$role11]);
        Permission::create(['name' => 'national.index'])->syncRoles([$role1,$role2,$role8,$role9]);
        Permission::create(['name' => 'national.clasificacion'])->syncRoles([$role1,$role2,$role8,$role9,$role10,$role11]);
        Permission::create(['name' => 'national.entrega'])->syncRoles([$role1,$role2,$role8,$role9]);
    }
}
