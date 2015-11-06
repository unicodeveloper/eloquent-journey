<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable  = ['title','pages_count','price','description','author_id','publisher_id'];

    protected $dates = ['deleted_at'];

    // Accessor..manipulates values returned from the database
    // e.g <getColumnNameAttribute> that's the syntax e.g if you want to manipulate the title column, the method name
    // will be getTitleAttribute
    public function getPriceAttribute($value)
    {
        return '$' . $value;
    }

    // Mutator...manipulates values as they are been inserted/stored in the database
    // e.g <setColumnNameAttribute> that's the syntax e.g if you want to manipulate the title column, the method name
    // will be setTitleAttribute like we have here
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtoupper($value);
    }


}
