<?php

namespace App\JsonApi\Books;

use CloudCreativity\LaravelJsonApi\Document\Error;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\EncodingParametersInterface;
use Neomerx\JsonApi\Exceptions\JsonApiException;

class Adapter extends AbstractAdapter {

	/**
	 * Mapping of JSON API attribute field names to model keys.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Adapter constructor.
	 *
	 * @param StandardStrategy $paging
	 */
	public function __construct( StandardStrategy $paging ) {
		parent::__construct( new \App\Models\Book(), $paging );
	}

	/**
	 * @param Builder $query
	 * @param Collection $filters
	 *
	 * @return void
	 */
	protected function filter( $query, Collection $filters ) {

        /**
         * Query books by name
         */
        if ($name = $filters->get('name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        /**
         * Query books by publisher id
         */
        if ($publisher = $filters->get('publisher')) {
            $query->where('publisher_id', '=', $publisher);
        }

        /**
         * Query books by publisher short name (case insensitive, full match)
         */
        if ($publisherShortName = $filters->get('publisherShortName')) {
            $query->whereHas('publisher', function($q) use($publisherShortName) {
                $q->whereRaw('LOWER(short_name) = ? ', [trim(strtolower($publisherShortName))]);
            });
        }

        /**
         * Query books by tag id
         */
        if ($tag = $filters->get('tag')) {
            $query->whereHas('tags', function($q) use($tag) {
                $q->where('id', '=', $tag);
            });
        }

        /**
         * Query books by category id
         */
        if ($category = $filters->get('category')) {
            $query->whereHas('categories', function($q) use($category) {
                $q->where('id', '=', $category);
            });
        }

        /**
         * Query books by author id
         */
        if ($author = $filters->get('author')) {
            $query->whereHas('authors', function($q) use($author) {
                $q->where('id', '=', $author);
            });
        }

        /**
         * Query books by user id
         */
        if ($user = $filters->get('user')) {
            $query->whereHas('users', function($q) use($user) {
                $q->where('user_id', '=', $user);
            });
        }

        /**
         * Query books by author name (case insensitive, partial match)
         */
        if ($authorName = $filters->get('authorName')) {
            $query->whereHas('authors', function($q) use($authorName) {
                $q->whereRaw('LOWER(name) LIKE ? ', [trim(strtolower("%{$authorName}%"))]);
            });
        }

        /**
         * Filter for available books if set to 'true' or for unavailable books if set to 'false'
         */
        if ($isAvailable = $filters->get('isAvailable')) {
            if (!in_array($isAvailable, ['true', 'false'])) {
                $error = Error::create([
                    'title' => 'Value error',
                    'detail' => 'Invalid value provided for filter `isAvailable`. Should be `true` or `false`',
                    'status' => '400',
                ]);
                throw new JsonApiException($error, 400);
            }

            if ($isAvailable === 'true') {
                $query->doesntHave('users');
            } else {
                $query->whereHas('users');
            }
        }

        /**
         * Filter books by release year
         */
        if ($releaseYear = $filters->get('releaseYear')) {
            $query->whereYear('release_date', $releaseYear);
        }

        /**
         * Filter books by release month
         */
        if ($releaseMonth = $filters->get('releaseMonth')) {
            $query->whereMonth('release_date', $releaseMonth);
        }

        /**
         * Filter books by release day
         */
        if ($releaseDay = $filters->get('releaseDay')) {
            $query->whereDay('release_date', $releaseDay);
        }

        /**
         * Randomize book order
         */
        if ($random = $filters->get('random')) {
            $query->inRandomOrder();
        }
	}

	protected function publisher() {
		return $this->belongsTo();
	}

    protected function tags() {
        return $this->hasMany();
    }

    protected function categories() {
        return $this->hasMany();
    }

    protected function authors() {
        return $this->hasMany();
    }

    protected function users() {
        return $this->hasMany();
    }

}
