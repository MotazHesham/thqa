<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\Building;
use App\Models\BuildingDocument;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class HomeController
{
    public function dropbox(){

        $accessToken = config('app.dropbox_access_token'); 
        $path = request()->has('path') && request()->path != null ? request()->path : ''; 
        $prev = request()->has('prev') && request()->prev != null ? request()->prev : '';
        $modal_id = request()->modal_id;
        $folders = []; 
        try {
            // Make the initial request to get folder entries
            $response = Http::withToken($accessToken)->post('https://api.dropboxapi.com/2/files/list_folder', [
                'path' => $path,
                'recursive' => false,
                'include_media_info' => false,
                'include_deleted' => false,
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Failed to connect to Dropbox'], 500);
            }

            $data = $response->json();
            
            // Filter for folders only
            foreach ($data['entries'] as $key => $entry) { 
                $folders[$key]['id'] = $entry['id']; 
                $folders[$key]['name'] = $entry['name']; 
                $folders[$key]['tag'] = $entry['.tag']; 
                $folders[$key]['path'] = $entry['path_display']; 
            }

            // Check if there are more results and continue fetching
            while ($data['has_more']) {
                $response = Http::withToken($accessToken)->post('https://api.dropboxapi.com/2/files/list_folder/continue', [
                    'cursor' => $data['cursor'],
                ]);

                if ($response->failed()) {
                    return response()->json(['error' => 'Failed to retrieve all folders'], 500);
                }

                $data = $response->json();

                foreach ($data['entries'] as $key => $entry) {
                    $folders[$key]['id'] = $entry['id']; 
                    $folders[$key]['tag'] = $entry['.tag']; 
                    $folders[$key]['name'] = $entry['name']; 
                    $folders[$key]['path'] = $entry['path_display']; 
                }
            }
            
            return view('admin.dropbox.index',compact('folders','path','prev','modal_id'));

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDropBoxFileLink($id)
    { 
        $accessToken = config('app.dropbox_access_token'); 
        
        $url = 'https://api.dropboxapi.com/2/sharing/get_file_metadata';

        $client = new Client();

        try { 
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'file' => $id
                ]
            ]);

            // Decode the response to get the preview_url
            $metadata = json_decode($response->getBody()->getContents(), true);
            $previewUrl = $metadata['preview_url'];  // The preview URL of the file

            return Redirect::away($previewUrl);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch file metadata', 'message' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $settings1 = [
            'chart_title'           => 'إجمالي العقارات',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Building',
            'group_by_field'        => 'owned_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd/m/Y',
            'column_class'          => 'col-md-4',
            'entries_number'        => '5',
            'translation_key'       => 'building',
        ];

        $settings1['total_number'] = 0;
        if (class_exists($settings1['model'])) {
            $settings1['total_number'] = $settings1['model']::when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                if (isset($settings1['filter_days'])) {
                    return $query->where($settings1['filter_field'], '>=',
                        now()->subDays($settings1['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings1['filter_period'])) {
                    switch ($settings1['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings1['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
        }

        $settings2 = [
            'chart_title'           => 'إجمالي الملاك',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Owner',
            'group_by_field'        => 'identity_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd/m/Y',
            'column_class'          => 'col-md-4',
            'entries_number'        => '5',
            'translation_key'       => 'owner',
        ];

        $settings2['total_number'] = 0;
        if (class_exists($settings2['model'])) {
            $settings2['total_number'] = $settings2['model']::when(isset($settings2['filter_field']), function ($query) use ($settings2) {
                if (isset($settings2['filter_days'])) {
                    return $query->where($settings2['filter_field'], '>=',
                        now()->subDays($settings2['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings2['filter_period'])) {
                    switch ($settings2['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings2['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings2['aggregate_function'] ?? 'count'}($settings2['aggregate_field'] ?? '*');
        }

        $settings3 = [
            'chart_title'           => 'إجمالي الصكوك',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\BuildingSak',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd/m/Y H:i:s',
            'column_class'          => 'col-md-4',
            'entries_number'        => '5',
            'translation_key'       => 'buildingSak',
        ];

        $settings3['total_number'] = 0;
        if (class_exists($settings3['model'])) {
            $settings3['total_number'] = $settings3['model']::when(isset($settings3['filter_field']), function ($query) use ($settings3) {
                if (isset($settings3['filter_days'])) {
                    return $query->where($settings3['filter_field'], '>=',
                        now()->subDays($settings3['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings3['filter_period'])) {
                    switch ($settings3['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings3['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings3['aggregate_function'] ?? 'count'}($settings3['aggregate_field'] ?? '*');
        }

        $settings4 = [
            'chart_title'           => 'أحدث الأضافات',
            'chart_type'            => 'latest_entries',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd/m/Y H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'fields'                => [
                'name'       => '',
                'created_at' => '',
            ],
            'translation_key' => 'user',
        ];

        $settings4['data'] = [];
        if (class_exists($settings4['model'])) {
            $settings4['data'] = $settings4['model']::latest()
                ->take($settings4['entries_number'])
                ->get();
        }

        if (! array_key_exists('fields', $settings4)) {
            $settings4['fields'] = [];
        }

        $settings5 = [
            'chart_title'           => 'الإشعارات',
            'chart_type'            => 'latest_entries',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\UserAlert',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd/m/Y H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'fields'                => [
                'alert_text' => '',
            ],
            'translation_key' => 'userAlert',
        ];

        $settings5['data'] = [];
        if (class_exists($settings5['model'])) {
            $settings5['data'] = $settings5['model']::whereHas('users',function($q){
                $q->where('id',auth()->id());
            })->latest()
                ->take($settings5['entries_number'])
                ->get();
        }

        if (! array_key_exists('fields', $settings5)) {
            $settings5['fields'] = [];
        }

        $settings6 = [
            'chart_title'        => 'العقارات',
            'chart_type'         => 'line',
            'report_type'        => 'group_by_string',
            'model'              => 'App\Models\Building',
            'group_by_field'     => 'building_type',
            'aggregate_function' => 'count',
            'filter_field'       => 'created_at',
            'column_class'       => 'col-md-12',
            'entries_number'     => '5',
            'translation_key'    => 'building',
        ];

        $chart6 = new LaravelChart($settings6); 
        $buildings_count = Building::count();

        
        $documents = BuildingDocument::with('building.owner.user')->where('status','active')->orderBy('file_date_end','asc')->get();

        return view('home', compact('settings1', 'settings2', 'settings3', 'settings4', 'settings5','chart6' ,'documents','buildings_count'));
    }
}
