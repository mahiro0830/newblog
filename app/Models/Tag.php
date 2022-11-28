<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RelationTag;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = array('name', 'slug');

    public function relationTags()
    {
        return $this->hasMany( RelationTag::class );
    }
}
