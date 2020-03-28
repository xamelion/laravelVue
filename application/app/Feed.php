<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /**
     * A table associated with the model.
     *
     * @var string Table name
     */
    protected $table = 'feeds';

    /***
     * Cell names
     *
     * @var array string
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'media',
        'category_id'
    ];

    /**
     * Get the category for the feed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
