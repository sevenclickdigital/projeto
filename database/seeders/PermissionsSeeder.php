<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list billings']);
        Permission::create(['name' => 'view billings']);
        Permission::create(['name' => 'create billings']);
        Permission::create(['name' => 'update billings']);
        Permission::create(['name' => 'delete billings']);

        Permission::create(['name' => 'list birthdays']);
        Permission::create(['name' => 'view birthdays']);
        Permission::create(['name' => 'create birthdays']);
        Permission::create(['name' => 'update birthdays']);
        Permission::create(['name' => 'delete birthdays']);

        Permission::create(['name' => 'list branches']);
        Permission::create(['name' => 'view branches']);
        Permission::create(['name' => 'create branches']);
        Permission::create(['name' => 'update branches']);
        Permission::create(['name' => 'delete branches']);

        Permission::create(['name' => 'list branchhours']);
        Permission::create(['name' => 'view branchhours']);
        Permission::create(['name' => 'create branchhours']);
        Permission::create(['name' => 'update branchhours']);
        Permission::create(['name' => 'delete branchhours']);

        Permission::create(['name' => 'list categoryproducts']);
        Permission::create(['name' => 'view categoryproducts']);
        Permission::create(['name' => 'create categoryproducts']);
        Permission::create(['name' => 'update categoryproducts']);
        Permission::create(['name' => 'delete categoryproducts']);

        Permission::create(['name' => 'list coupons']);
        Permission::create(['name' => 'view coupons']);
        Permission::create(['name' => 'create coupons']);
        Permission::create(['name' => 'update coupons']);
        Permission::create(['name' => 'delete coupons']);

        Permission::create(['name' => 'list holidays']);
        Permission::create(['name' => 'view holidays']);
        Permission::create(['name' => 'create holidays']);
        Permission::create(['name' => 'update holidays']);
        Permission::create(['name' => 'delete holidays']);

        Permission::create(['name' => 'list holidaydescriptions']);
        Permission::create(['name' => 'view holidaydescriptions']);
        Permission::create(['name' => 'create holidaydescriptions']);
        Permission::create(['name' => 'update holidaydescriptions']);
        Permission::create(['name' => 'delete holidaydescriptions']);

        Permission::create(['name' => 'list leads']);
        Permission::create(['name' => 'view leads']);
        Permission::create(['name' => 'create leads']);
        Permission::create(['name' => 'update leads']);
        Permission::create(['name' => 'delete leads']);

        Permission::create(['name' => 'list messages']);
        Permission::create(['name' => 'view messages']);
        Permission::create(['name' => 'create messages']);
        Permission::create(['name' => 'update messages']);
        Permission::create(['name' => 'delete messages']);

        Permission::create(['name' => 'list newsletters']);
        Permission::create(['name' => 'view newsletters']);
        Permission::create(['name' => 'create newsletters']);
        Permission::create(['name' => 'update newsletters']);
        Permission::create(['name' => 'delete newsletters']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list qrbilders']);
        Permission::create(['name' => 'view qrbilders']);
        Permission::create(['name' => 'create qrbilders']);
        Permission::create(['name' => 'update qrbilders']);
        Permission::create(['name' => 'delete qrbilders']);

        Permission::create(['name' => 'list ratings']);
        Permission::create(['name' => 'view ratings']);
        Permission::create(['name' => 'create ratings']);
        Permission::create(['name' => 'update ratings']);
        Permission::create(['name' => 'delete ratings']);

        Permission::create(['name' => 'list ratinggooglebusinesses']);
        Permission::create(['name' => 'view ratinggooglebusinesses']);
        Permission::create(['name' => 'create ratinggooglebusinesses']);
        Permission::create(['name' => 'update ratinggooglebusinesses']);
        Permission::create(['name' => 'delete ratinggooglebusinesses']);

        Permission::create(['name' => 'list scratchcards']);
        Permission::create(['name' => 'view scratchcards']);
        Permission::create(['name' => 'create scratchcards']);
        Permission::create(['name' => 'update scratchcards']);
        Permission::create(['name' => 'delete scratchcards']);

        Permission::create(['name' => 'list scratchcardanswers']);
        Permission::create(['name' => 'view scratchcardanswers']);
        Permission::create(['name' => 'create scratchcardanswers']);
        Permission::create(['name' => 'update scratchcardanswers']);
        Permission::create(['name' => 'delete scratchcardanswers']);

        Permission::create(['name' => 'list scratchcardconfigs']);
        Permission::create(['name' => 'view scratchcardconfigs']);
        Permission::create(['name' => 'create scratchcardconfigs']);
        Permission::create(['name' => 'update scratchcardconfigs']);
        Permission::create(['name' => 'delete scratchcardconfigs']);

        Permission::create(['name' => 'list scratchcardplayers']);
        Permission::create(['name' => 'view scratchcardplayers']);
        Permission::create(['name' => 'create scratchcardplayers']);
        Permission::create(['name' => 'update scratchcardplayers']);
        Permission::create(['name' => 'delete scratchcardplayers']);

        Permission::create(['name' => 'list socialleads']);
        Permission::create(['name' => 'view socialleads']);
        Permission::create(['name' => 'create socialleads']);
        Permission::create(['name' => 'update socialleads']);
        Permission::create(['name' => 'delete socialleads']);

        Permission::create(['name' => 'list tenants']);
        Permission::create(['name' => 'view tenants']);
        Permission::create(['name' => 'create tenants']);
        Permission::create(['name' => 'update tenants']);
        Permission::create(['name' => 'delete tenants']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
