<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = [
        "id",
        "title",
        "description",
        "image",
        "slug",
        "views",
        "total_products",
        "seo_title",
        "meta_key",
        "meta_description",
        "created_by",
        "modified_by",
        "status"
    ];
    protected $table = 'tags';

    public function blogs()
    {
        return $this->morphedByMany('App\Blog', 'taggable');
    }

    public function products()
    {
        return $this->morphedByMany('App\Product', 'taggable');
    }
}
