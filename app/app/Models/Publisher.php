<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

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
	    'name',
        'short_name',
	];

	/**
	 * @return hasMany
	 */
	public function books(): HasMany {
		return $this->hasMany( Book::class );
	}
}
