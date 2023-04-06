<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';

    protected $fillable = [
        'title',
        'url',
        'description',
        'img_path', 
    ];

    public function user() {
        return $this->belongsTo(User::class); 
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function($stock) {
            $stock->user_id = \Auth::id(); 
        }); 
    }
}
