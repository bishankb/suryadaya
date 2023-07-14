<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Gallery;

class Media extends Model
{  
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'filename', 'original_filename', 'extension', 'mime', 'type', 'file_size'
    ];

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class, 'gallery_media', 'gallery_id', 'media_id');
    }
}
