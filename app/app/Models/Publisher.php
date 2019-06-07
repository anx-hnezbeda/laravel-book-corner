<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Publisher
 * @package App\Models
 */
class Publisher extends BaseModel
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'publishers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	];

	/**
	 * @return BelongsToMany
	 */
	public function books(): BelongsToMany {
		return $this->belongsToMany( Book::class );
	}
}