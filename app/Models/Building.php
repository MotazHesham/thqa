<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Builder;

class Building extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'buildings';

    protected $appends = [
        'photos',
    ];

    public const BUILDING_STATUS_SELECT = [
        'empty'  => 'فارغ',
        'rented' => 'مؤجر',
    ];

    protected $dates = [
        'owned_date',
        'registration_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const DATE_TYPE = [
        'owned_date' => 'تاريخ التمليك',
        'registration_date'  => 'تاريخ التسجيل',
        'created_at'      => 'تاريخ الأضافة للنظام',
    ];
    public const BUILDING_TYPE_SELECT = [
        'land_space' => 'أرض فضاء',
        'duplex_villa'  => 'فيلا دوبلكس',
        'building_residential'      => 'عمارة - سكني',
        'arch_commercial'      => 'عمارة - تجاري',
        'villa'      => 'فيلا',
        'break'      => 'استراحة',
        'building_residential_commercial'      => 'عمارة - سكني تجاري',
        'cert_planner'      => 'مخطط معتمد',
        'raw_land'      => 'أرض خام',
        'building_invest'      => 'مبني استثماري',
    ];
    public const BUILDING_TYPE_REF_SELECT = [
        'land_space' => 'LS',
        'duplex_villa'  => 'DVP',
        'building_residential'      => 'RP',
        'arch_commercial'      => 'CP',
        'villa'      => 'VP',
        'break'      => 'BP',
        'building_residential_commercial'      => 'RCP',
        'cert_planner'      => 'LL',
        'raw_land'      => 'RL',
        'building_invest'      => 'IP',
    ];
    public const BUILDING_TYPE_ICONS = [
        'land_space' => 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        'duplex_villa'  => 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
        'building_residential'      => 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
        'arch_commercial'      => 'https://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
        'villa'      => 'https://maps.google.com/mapfiles/ms/icons/purple-dot.png',
        'break'      => 'https://maps.google.com/mapfiles/ms/icons/pink-dot.png',
        'building_residential_commercial'      => 'https://maps.google.com/mapfiles/ms/icons/orange-dot.png',
        'cert_planner'      => 'https://maps.google.com/mapfiles/ms/icons/ltblue-dot.png',
        'raw_land'      => 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-pushpin.png',
        'building_invest'      => 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-pushpin.png',
    ];

    protected $fillable = [
        'owner_id',
        'code',
        'name',
        'map_lat',
        'map_long',
        'address',
        'building_type',
        'building_status',
        'owned_date',
        'registration_date',
        'survey_descision',
        'commerical_num',
        'real_estate_identity', 
        'details',
        'country_id',
        'city_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('employees', function (Builder $builder) {  
            $user = auth()->user();
            if ($user && !$user->is_admin) {
                $builder->whereHas('employees',function($q) use($user){
                    $q->where('employee_id',$user->id);
                });
            }
        });
    }

    public function get_details(){
        return '<p>' . $this->name . '</p>' . '<p>' . Building::BUILDING_TYPE_SELECT[$this->building_type] . '</p>';
    }

    public function get_images(){
        $images = '';
        foreach($this->photos as $media){
            $images .= '<a href="'.$media->getUrl().'" target="_blanc"><img src="'.$media->getUrl("thumb") .'" alt="" /></a>';
        } 
        return $images;
    }

    public function get_location_link(){
        return 'https://www.google.com/maps/place/'.$this->map_lat.','.$this->map_long;
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 220, 220);
    }

    public function buildingBuildingDocuments()
    {
        return $this->hasMany(BuildingDocument::class, 'building_id', 'id');
    }

    public function buildingBuildingSaks()
    {
        return $this->hasMany(BuildingSak::class, 'building_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function getOwnedDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setOwnedDateAttribute($value)
    {
        $this->attributes['owned_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getRegistrationDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setRegistrationDateAttribute($value)
    {
        $this->attributes['registration_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPhotosAttribute()
    {
        $files = $this->getMedia('photos');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    } 

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');

    }

    public function folders(){
        return $this->hasMany(BuildingFolder::class);
    }
    
    public function employees()
    {
        return $this->belongsToMany(User::class, 'building_employee', 'building_id', 'employee_id');
    }

}
