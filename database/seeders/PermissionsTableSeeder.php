<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'admin-dashboard',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'branch-dashboard',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'user-dashboard',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'branch-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'branch-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'branch-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'branch-delete',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'multi-branch',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'bank-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'bank-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'bank-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'bank-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'user-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'user-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'user-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'user-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'category-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'category-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'category-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'category-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'mode-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'mode-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'mode-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'mode-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'expense-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'expense-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'expense-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'expense-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'fund-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'fund-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'fund-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'fund-delete',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'fund-approve/reject',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'deposit-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'deposit-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'deposit-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'deposit-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'withdrawal-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'withdrawal-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'withdrawal-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'withdrawal-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'role-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'role-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'role-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'role-delete',
                'guard_name' => 'admin',
            ],


            [
                'name' => 'client-view',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'client-add',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'client-update',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'client-delete',
                'guard_name' => 'admin',
            ],
        ]);
    }
}
