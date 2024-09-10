<?php

namespace App\Models;

use App\Traits\Auditable; 
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BuildingFolder extends Model 
{
    use  Auditable, HasFactory;

    public $table = 'building_folders'; 

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [ 
        'building_id',
        'name', 
        'type', 
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }  
}
