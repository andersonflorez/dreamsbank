<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Transaction extends Model
{
    protected $fillable = ['id', 'product_id', 'commerce', 'amount', 'state'];
    protected $timestamp = true;
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to only the users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProductId($query, $id)
    {
        if ($id != null) {
            return $query->where('product_id', $id);
        } else {
            return $query;
        }
    }
}
