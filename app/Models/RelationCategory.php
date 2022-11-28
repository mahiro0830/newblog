<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class RelationCategory extends Model
{
    use HasFactory;

    protected $table = 'relation_categories';

    protected $fillable = array('post_id', 'category_id');

    public function category()
    {
        return $this->belongsTo( Category::class );
    }
}
