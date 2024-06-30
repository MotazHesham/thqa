<?php

return [
    'userManagement' => [
        'title'          => 'إدارة المستخدمين',
        'title_singular' => 'إدارة المستخدمين',
    ],
    'permission' => [
        'title'          => 'الصلاحيات',
        'title_singular' => 'الصلاحية',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'المجموعات',
        'title_singular' => 'مجموعة',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'المستخدمين',
        'title_singular' => 'مستخدم',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'approved'                 => 'Approved',
            'approved_helper'          => ' ',
            'photo'                    => 'Photo',
            'photo_helper'             => ' ',
            'phone'                    => 'Phone',
            'phone_helper'             => ' ',
            'user_type'                => 'User Type',
            'user_type_helper'         => ' ',
            'last_name'                => 'Last Name',
            'last_name_helper'         => ' ',
        ],
    ],
    'auditLog' => [
        'title'          => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'description'         => 'Description',
            'description_helper'  => ' ',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => ' ',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id'             => 'User ID',
            'user_id_helper'      => ' ',
            'properties'          => 'Properties',
            'properties_helper'   => ' ',
            'host'                => 'Host',
            'host_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
        ],
    ],
    'userAlert' => [
        'title'          => 'User Alerts',
        'title_singular' => 'User Alert',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'alert_text'        => 'Alert Text',
            'alert_text_helper' => ' ',
            'alert_link'        => 'Alert Link',
            'alert_link_helper' => ' ',
            'user'              => 'Users',
            'user_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'ownerManagment' => [
        'title'          => 'Owner Managment',
        'title_singular' => 'Owner Managment',
    ],
    'owner' => [
        'title'          => 'Owners',
        'title_singular' => 'Owner',
        'fields'         => [
            'id'                          => 'ID',
            'id_helper'                   => ' ',
            'user'                        => 'User',
            'user_helper'                 => ' ',
            'gender'                      => 'Gender',
            'gender_helper'               => ' ',
            'identity_num'                => 'Identity Num',
            'identity_num_helper'         => ' ',
            'identity_date'               => 'Identity Date',
            'identity_date_helper'        => ' ',
            'address'                     => 'Address',
            'address_helper'              => ' ',
            'commerical_num'              => 'Commerical Num',
            'commerical_num_helper'       => ' ',
            'real_estate_identity'        => 'Real Estate Identity',
            'real_estate_identity_helper' => ' ',
            'created_at'                  => 'Created at',
            'created_at_helper'           => ' ',
            'updated_at'                  => 'Updated at',
            'updated_at_helper'           => ' ',
            'deleted_at'                  => 'Deleted at',
            'deleted_at_helper'           => ' ',
        ],
    ],
    'building' => [
        'title'          => 'Buildings',
        'title_singular' => 'Building',
        'fields'         => [
            'id'                          => 'ID',
            'id_helper'                   => ' ',
            'owner'                       => 'Owner',
            'owner_helper'                => ' ',
            'address'                     => 'Address',
            'address_helper'              => ' ',
            'building_type'               => 'Building Type',
            'building_type_helper'        => ' ',
            'building_status'             => 'Building Status',
            'building_status_helper'      => ' ',
            'owned_date'                  => 'Owned Date',
            'owned_date_helper'           => ' ',
            'registration_date'           => 'Registration Date',
            'registration_date_helper'    => ' ',
            'survey_descision'            => 'Survey Descision',
            'survey_descision_helper'     => ' ',
            'commerical_num'              => 'Commerical Num',
            'commerical_num_helper'       => ' ',
            'real_estate_identity'        => 'Real Estate Identity',
            'real_estate_identity_helper' => ' ',
            'photos'                      => 'Photos',
            'photos_helper'               => ' ',
            'employee'                    => 'Employee',
            'employee_helper'             => ' ',
            'created_at'                  => 'Created at',
            'created_at_helper'           => ' ',
            'updated_at'                  => 'Updated at',
            'updated_at_helper'           => ' ',
            'deleted_at'                  => 'Deleted at',
            'deleted_at_helper'           => ' ',
            'country'                     => 'Country',
            'country_helper'              => ' ',
            'city'                        => 'City',
            'city_helper'                 => ' ',
            'map_lat'                     => 'Map Lat',
            'map_lat_helper'              => ' ',
            'map_long'                    => 'Map Long',
            'map_long_helper'             => ' ',
            'name'                        => 'Name',
            'name_helper'                 => ' ',
        ],
    ],
    'generalSetting' => [
        'title'          => 'General Settings',
        'title_singular' => 'General Setting',
    ],
    'country' => [
        'title'          => 'Countries',
        'title_singular' => 'Country',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'short_code'        => 'Short Code',
            'short_code_helper' => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'city' => [
        'title'          => 'Cities',
        'title_singular' => 'City',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'country'           => 'Country',
            'country_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'buildingDocument' => [
        'title'          => 'Building Documents',
        'title_singular' => 'Building Document',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'building'          => 'Building',
            'building_helper'   => ' ',
            'file_num'          => 'File Num',
            'file_num_helper'   => ' ',
            'file_name'         => 'File Name',
            'file_name_helper'  => ' ',
            'file_type'         => 'File Type',
            'file_type_helper'  => ' ',
            'file_date'         => 'File Date',
            'file_date_helper'  => ' ',
            'photo'             => 'Photo',
            'photo_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'buildingSak' => [
        'title'          => 'Building Saks',
        'title_singular' => 'Building Sak',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'building'          => 'Building',
            'building_helper'   => ' ',
            'sak_num'           => 'Sak Num',
            'sak_num_helper'    => ' ',
            'photo'             => 'Photo',
            'photo_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'systemReport' => [
        'title'          => 'System Reports',
        'title_singular' => 'System Report',
    ],
    'ownersReport' => [
        'title'          => 'Owners Report',
        'title_singular' => 'Owners Report',
    ],
    'reportBuilding' => [
        'title'          => 'Report Buildings',
        'title_singular' => 'Report Building',
    ],
    'reportSak' => [
        'title'          => 'Report Saks',
        'title_singular' => 'Report Sak',
    ],

];
