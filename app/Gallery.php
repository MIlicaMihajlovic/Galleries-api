<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillabe = [
        'title', 'description', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public static function search($term, $skip, $take) {

        return self::where('title', 'LIKE', "%$term%",
                            'OR', 'description', 'LIKE', "%$term%"//,
                          /*  'OR', 'user_id', 'LIKE', "%$term%"*/ )
                            ->skip($skip)
                            ->take($take)
                            ->get();
              
    }
}
