<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * A table associated with the model.
     *
     * @var string Table name
     */
    protected $table = 'categories';

    /***
     * Cell names
     *
     * @var array string
     */
    protected $fillable = [
        'title'
    ];

    /**
     * Disable timestamp
     * @var bool
     */
    public $timestamps = false;
}
