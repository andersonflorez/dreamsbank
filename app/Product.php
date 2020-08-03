<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Transaction;

class Product extends Model
{
    protected $fillable = ['id', 'name', 'state', 'number'];
    protected $timestamp = true;

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only the users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserId($query, $id = null)
    {
        if ($id != null) {
            return $query->where('user_id', $id);
        } else {
            return $query;
        }
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('state', 'approved');
    }
}
