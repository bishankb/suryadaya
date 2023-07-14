<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use App\Media;
use App\Models\PageType;
use App\Models\ListPage;

class Tag extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_type',
		'name',
		'slug',
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
            }
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function pageType()
    {
        return $this->belongsTo(PageType::class, 'page_type');
    }

    public function listPages()
    {
        return $this->belongsToMany(ListPage::class);
    }

    public function scopePageTypeFilter($query, $filter)
    {
        if ($filter) {
            return $query->whereHas('pageType', function ($q) use ($filter) {
                        $q->where('name', $filter);
                    });
        }

        return $query;
    }
}
