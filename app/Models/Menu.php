<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use App\Models\SinglePage;
use App\Models\PageType;

class Menu extends BaseModel
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
        'positions',
		'has_sub_menu',
        'menu_for',
		'order',
		'status',
		'created_by',
		'updated_by',
    ];

    const Positions = [
    	'Top Header',
    	'Top Navbar',
    	'Bottom Navbar',
    	'Notices',
        'Footer Service',
    	'Footer Navigation'
    ];

    const MenuFor = [
        'Single Page',
        'List Page'
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

    public function singlePages()
    {
        return $this->hasMany(SinglePage::class, 'menu_id');
    }

    public function pageTypes()
    {
        return $this->hasMany(PageType::class, 'menu_id');
    }

    public function scopePositionFilter($query, $filter)
    {
        if ($filter) {
            $position_id = array_flip(self::Positions)[$filter];

            return $query->whereRaw("find_in_set($position_id, positions)");
        }

        return $query;
    }

    public function scopeMenuFor($query, $filter)
    {
        if ($filter) {
            if($filter == 'Sub Menu') {
                return $query->where('has_sub_menu', 1);
            } else {                
                return $query->where('menu_for', array_flip(self::MenuFor)[$filter]);
            }
        }

        return $query;
    }
}
