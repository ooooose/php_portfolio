<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';

    protected $fillable = [
        'title',
        'url',
        'description',
        'img_path', 
        'user_id', 
    ];

    public function bookmarks()
    {
      return $this->hasMany(Bookmark::class, 'board_id');
    }

    public function scopeSearch($query, $search)
    {
        if ($search !== null) {
            $search_split = mb_convert_kana($search, 's');
            $search_split_2 = preg_split('/[\s]+/', $search_split);
            foreach ($search_split_2 as $value) {
                $query->where('title', 'like', '%'.$value.'%'); 
            }

            return $query;
        }
    }

    public function is_bookmarked_by_auth_user()
    {
        $id = Auth::id();
        $bookmarkers = array(); 
        foreach($this->bookmarks as $bookmark) {
            array_push($bookmarkers, $bookmark->user_id);
        }

        if (in_array($id, $bookmarkers)) {
            return true; 
        } else {
            return false; 
        }
    }

    public function user() 
    {
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
