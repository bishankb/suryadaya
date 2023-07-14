<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use App\Media;
use App\Models\ImportantLink ;

class ImportantLink extends BaseModel
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
		'order',
		'status',
		'created_by',
		'updated_by',
    ];

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if($filter == "name-low-high") {
                return $query->orderBy('name', 'asc');
            } elseif ($filter == "name-high-low") {
                return $query->orderBy('name', 'desc');
            } elseif($filter == "order-low-high") {
                return $query->orderBy('order', 'asc');
            } elseif ($filter == "order-high-low") {
                return $query->orderBy('order', 'desc');
            }
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}
