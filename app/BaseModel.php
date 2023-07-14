<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     *Filter by deleted items.
     *
     */
    public function scopeDeletedItemFilter($query, $filter)
    {
        if ($filter) {
            if ($filter == "Only Deleted") {
                return $query->onlyTrashed();
            } else {
                return $query->withTrashed();
            }
            
        }

        return $query;
    }

    /**
     *Filter by status.
     *
     */
    public function scopeStatusFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('status', $filter == 'Active' ? 1 : 0);
        }

        return $query;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}