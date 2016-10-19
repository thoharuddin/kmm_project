<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Author extends Model
{
    protected $fillable = ['name'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::deleting(function($author)
        {
            // mengecek apakah penulis masih punya buku
            if ($author->books->count() > 0) {

                $html = 'Penulis tidak bisa dihapus karena masih memiliki buku : ';
                $html .= '<ul>';
                foreach ($author->books as $book) {
                    $html .= "<li>$book->title</li>";
                }
                $html .= '</ul>';

                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>$html
                ]);

                return false;
            }
        });
    }

    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
