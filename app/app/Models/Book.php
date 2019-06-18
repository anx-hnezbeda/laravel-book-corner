<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
		'name',
		'pages',
		'ean',
		'isbn_10',
		'isbn_13',
		'release_date',
		'type',
		'nsfw',
	];


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * @return BelongsTo
	 */
	public function publisher(): BelongsTo {
		return $this->belongsTo( Publisher::class );
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

	/**
	 * @return BelongsToMany
	 */
	public function tags(): BelongsToMany {
		return $this->belongsToMany( Tag::class );
	}

}
