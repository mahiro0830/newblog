<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RelationCategory;

class Entry extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    /**
     * relation_category とのリレーション（１対１）
     */
    public function relation_category()
    {
        return $this->hasOne( RelationCategory::class, 'post_id' );
    }

    /**
     * relation_tag とのリレーション（１対多）
     */
    public function relation_tags()
    {
        return $this->hasMany( RelationTag::class, 'post_id' );
    }
}
