<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use App\Media;
use App\Models\PageType;
use App\Models\Category;

class ListPage extends BaseModel
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
        'order',
        'description',
        'category_id',
        'file_id',
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

    public function pageType()
    {
        return $this->belongsTo(PageType::class, 'page_type');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'list_page_tag', 'list_page_id', 'tag_id');
    }

    public function file()
    {
        return $this->belongsTo(Media::class, 'file_id');
    }

    public function scopeCategoryFilter($query, $filter)
    {
        if ($filter) {
            return $query->whereHas('category', function ($q) use ($filter) {
                        $q->where('name', $filter);
                    });
        }

        return $query;
    }

    public function scopeTagFilter($query, $filter)
    {
        if ($filter) {
            return $query->whereHas('tags', function ($q) use ($filter) {
                        $q->where('name', $filter);
                    });
        }

        return $query;
    }
}