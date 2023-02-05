<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user_list',
            'user_create',
            'user_edit',
            'user_delete',
            'role_list',
            'role_create',
            'role_edit',
            'role_delete',
            'member_list',
            'member_expire_list',
            'member_pending_fees_list',
            'member_create',
            'member_edit',
            'member_delete',
            'member_view',
            'make_payment',
            'membership_list',
            'membership_create',
            'membership_edit',
            'membership_delete',
            'attendance_list',
            'newsletter_list',
            'consultation_list',
            'expense_list',
            'expense_edit',
            'expense_delete',
            'expense_create',
            'make_salary',
            'make_history',
            'tag_list',
            'tag_create',
            'tag_edit',
            'tag_delete',
            'brand_list',
            'brand_create',
            'brand_edit',
            'brand_delete',
            'user_attendance',
            'user_attendance_list',
            'user_attendance_mark',
            'category_list',
            'category_create',
            'category_edit',
            'category_delete',
            'locker_list',
            'locker_create',
            'locker_edit',
            'locker_delete',
            'attribute_list',
            'attribute_create',
            'attribute_edit',
            'attribute_delete',
            'value_list',
            'value_create',
            'value_edit',
            'value_delete',
            'product_list',
            'product_create',
            'product_edit',
            'product_delete',
            'trashed_memberships',
            'trashed_roles',
            'trashed_users',
            'trashed_members',
            'dashboard_income_expense',
            'dashboard_members',
            'update_member_fee',
            'update_member_reg_date',
            'update_member_ptf',
            'goal_list',
            'goal_create',
            'goal_edit',
            'goal_delete',
            'order_list',
            'order_create',
            'order_edit',
            'order_delete',
            'classes_list',
            'classes_create',
            'classes_edit',
            'classes_delete',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::updateOrCreate([
                'name' => $permission
            ]);
        }
    }
}
