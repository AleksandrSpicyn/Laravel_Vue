<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 * @property string name
 * @property string description
 * @property string img
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Category categories
 */
class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'img'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $table = 'products';

    /**
     * Product categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'products_categories');
    }
}
