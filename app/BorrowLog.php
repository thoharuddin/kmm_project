<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowLog extends Model
{
    protected $fillable = ['book_id', 'user_id', 'is_returned'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_returned' => 'boolean',
    ];

    /**
     * Relasi Many-to-One dengan Book
     * @return Book
     */
    public function book()
    {
        return $this->belongsTo('App\Book');
    }

    /**
     * Relasi Many-to-One dengan User
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeReturned($query)
    {
        return $query->where('is_returned', 1);
    }
    
    public function scopeBorrowed($query)
    {
        return $query->where('is_returned', 0);
    }
}
