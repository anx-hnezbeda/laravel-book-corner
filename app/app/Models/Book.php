<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Builder;
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
     * The "booting" method of the model.
     *
     * Adds global scope to filter out nsfw books during work hours
     *
     * @throws \Exception
     */
    protected static function boot()
    {
        parent::boot();

        if (static::workTime()) {
            static::addGlobalScope('nsfw', function (Builder $builder) {
                $builder->where('nsfw', '=', false);
            });
        }
    }

    /**
     * Checks if the current time is work time in Germany/Austria
     *
     * @return bool
     * @throws \Exception
     */
    protected static function workTime(): bool {
        $tzInfo = new DateTimeZone('Europe/Berlin');
        $current = new DateTime('now', $tzInfo);
        $workStart = new DateTime('now', $tzInfo);
        $workEnd = new DateTime('now', $tzInfo);

        $workStart->setTime(9, 0, 0, 0);
        $workEnd->setTime(17, 0,0,0);

        if ($current > $workStart && $current < $workEnd)
        {
            return true;
        }
        return false;
    }

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

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany {
        return $this->belongsToMany( User::class );
    }

}
