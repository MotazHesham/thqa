<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 23,
                'title' => 'owner_managment_access',
            ],
            [
                'id'    => 24,
                'title' => 'owner_create',
            ],
            [
                'id'    => 25,
                'title' => 'owner_edit',
            ],
            [
                'id'    => 26,
                'title' => 'owner_show',
            ],
            [
                'id'    => 27,
                'title' => 'owner_delete',
            ],
            [
                'id'    => 28,
                'title' => 'owner_access',
            ],
            [
                'id'    => 29,
                'title' => 'building_create',
            ],
            [
                'id'    => 30,
                'title' => 'building_edit',
            ],
            [
                'id'    => 31,
                'title' => 'building_show',
            ],
            [
                'id'    => 32,
                'title' => 'building_delete',
            ],
            [
                'id'    => 33,
                'title' => 'building_access',
            ],
            [
                'id'    => 34,
                'title' => 'general_setting_access',
            ],
            [
                'id'    => 35,
                'title' => 'country_create',
            ],
            [
                'id'    => 36,
                'title' => 'country_edit',
            ],
            [
                'id'    => 37,
                'title' => 'country_show',
            ],
            [
                'id'    => 38,
                'title' => 'country_delete',
            ],
            [
                'id'    => 39,
                'title' => 'country_access',
            ],
            [
                'id'    => 40,
                'title' => 'city_create',
            ],
            [
                'id'    => 41,
                'title' => 'city_edit',
            ],
            [
                'id'    => 42,
                'title' => 'city_show',
            ],
            [
                'id'    => 43,
                'title' => 'city_delete',
            ],
            [
                'id'    => 44,
                'title' => 'city_access',
            ],
            [
                'id'    => 45,
                'title' => 'building_document_create',
            ],
            [
                'id'    => 46,
                'title' => 'building_document_edit',
            ],
            [
                'id'    => 47,
                'title' => 'building_document_show',
            ],
            [
                'id'    => 48,
                'title' => 'building_document_delete',
            ],
            [
                'id'    => 49,
                'title' => 'building_document_access',
            ],
            [
                'id'    => 50,
                'title' => 'building_sak_create',
            ],
            [
                'id'    => 51,
                'title' => 'building_sak_edit',
            ],
            [
                'id'    => 52,
                'title' => 'building_sak_show',
            ],
            [
                'id'    => 53,
                'title' => 'building_sak_delete',
            ],
            [
                'id'    => 54,
                'title' => 'building_sak_access',
            ],
            [
                'id'    => 55,
                'title' => 'system_report_access',
            ],
            [
                'id'    => 56,
                'title' => 'owners_report_create',
            ],
            [
                'id'    => 57,
                'title' => 'owners_report_edit',
            ],
            [
                'id'    => 58,
                'title' => 'owners_report_show',
            ],
            [
                'id'    => 59,
                'title' => 'owners_report_delete',
            ],
            [
                'id'    => 60,
                'title' => 'owners_report_access',
            ],
            [
                'id'    => 61,
                'title' => 'report_building_create',
            ],
            [
                'id'    => 62,
                'title' => 'report_building_edit',
            ],
            [
                'id'    => 63,
                'title' => 'report_building_show',
            ],
            [
                'id'    => 64,
                'title' => 'report_building_delete',
            ],
            [
                'id'    => 65,
                'title' => 'report_building_access',
            ],
            [
                'id'    => 66,
                'title' => 'report_sak_create',
            ],
            [
                'id'    => 67,
                'title' => 'report_sak_edit',
            ],
            [
                'id'    => 68,
                'title' => 'report_sak_show',
            ],
            [
                'id'    => 69,
                'title' => 'report_sak_delete',
            ],
            [
                'id'    => 70,
                'title' => 'report_sak_access',
            ],
            [
                'id'    => 71,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
