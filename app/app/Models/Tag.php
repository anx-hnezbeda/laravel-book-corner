<?php

namespace App\Models;

use App\Models\Acl\ActionType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Tag
 * @package App\Models
 */
class Tag extends BaseModel {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'book_id',
		'name',
	];

	/**
	 * @return BelongsToMany
	 */
	public function books(): BelongsToMany {
		return $this->belongsToMany( Book::class );
	}

    /**
     * @return BelongsToMany
     */
    public function books_available(): BelongsToMany {
        return $this->belongsToMany( Book::class )->doesntHave('users');
    }

    /**
     * @return BelongsToMany
     */
    public function books_borrowed(): BelongsToMany {
        return $this->belongsToMany( Book::class )->whereHas('users');
    }
}
