<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RelationCategory;

class Category extends Model
{
    use HasFactory;

    /**
     * Eloquentから追加できるカラム
     */
    protected $fillable = array('id', 'name', 'slug', 'path');

    public function relationCategories()
    {
        return $this->hasMany( RelationCategory::class, 'category_id', 'id' );
    }
}
