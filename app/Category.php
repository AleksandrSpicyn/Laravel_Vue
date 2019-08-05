<?php

namespace App;

use Baum\Node;
use Carbon\Carbon;

/**
 * Class Category
 * @package App
 * @property string name
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Product products
 */
class Category extends Node
{
    protected $table = 'categories';
    protected $fillable = [
        'name'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Category products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'products_categories');
    }
}
