<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use App\Media;
use App\Models\Menu;
use App\Models\ListPage;
use App\Models\Category;
use App\Models\Tag;

class PageType extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'order',
        'order_by',
		'menu_id',
		'status',
		'created_by',
		'updated_by',
    ];

    const OrderBy = [
        'Ascending Order',
        'Descending Order'
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
        return $query->where('name', 'like', '%' . $search . '%')
                     ->OrWhereHas('menu', function ($r) use ($search) {
                        $r->where('name', 'like', '%' . $search . '%');
                     });
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function listPages()
    {
        return $this->hasMany(ListPage::class, 'page_type');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'page_type');        
    }

    public function tag()
    {
        return $this->hasOne(Tag::class, 'page_type');        
    }
}
