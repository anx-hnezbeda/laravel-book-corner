<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class BookUser
 * @package App\Models
 */
class BookUser extends BaseModel {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'book_user';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'book_id',
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
		return $this->hasOne( Publisher::class, 'id', 'publisher_id' );
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
	 * @return BelongsTo
	 */
	public function book(): BelongsTo {
		return $this->belongsTo( Book::class, 'book_id' );
	}

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo( User::class, 'user_id' );
	}

}