<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Book
 * @package App\Models
 */
class Book extends BaseModel {

	public const TYPE_HARDCOVER = "HARDCOVER";
	public const TYPE_SOFTCOVER = "SOFTCOVER";
	public const TYPE_EBOOK = "EBOOK";

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'books';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'publisher_id',
		'type',
        'name',
        'pages',
        'isbn_10',
        'isbn_13',
	];


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * @return HasOne
	 */
	public function publisher(): HasOne {
		return $this->hasOne( Publisher::class, 'id' );
	}

	/**
	 * @return BelongsToMany
	 */
	public function authors(): BelongsToMany {
		return $this->belongsToMany( Author::class );
	}

	/**
	 * @return BelongsToMany
	 */
	public function categories(): BelongsToMany {
		return $this->belongsToMany( Category::class );
	}

}
