<?php

namespace App\JsonApi\Books;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider {

	/**
	 * @var string
	 */
	protected $resourceType = 'books';

	/**
	 * @param $resource
	 *      the domain record being serialized.
	 *
	 * @return string
	 */
	public function getId( $resource ) {
		return (string) $resource->getRouteKey();
	}

	/**
	 * @param $resource
	 *      the domain record being serialized.
	 *
	 * @return array
	 */
	public function getAttributes( $resource ) {
		return [
			'created-at' => $resource->created_at->toAtomString(),
			'updated-at' => $resource->updated_at->toAtomString(),
            'release_date' => $resource->release_date,
			'name'       => $resource->name,
			'pages'      => $resource->pages,
			'isbn_10'    => $resource->isbn_10,
			'isbn_13'    => $resource->isbn_13,
		];
	}

	/**
	 * @param object $resource
	 * @param bool $isPrimary
	 * @param array $includeRelationships
	 *
	 * @return array
	 */
	public function getRelationships( $resource, $isPrimary, array $includeRelationships ) {
		return [
			'publisher' => [
				self::SHOW_SELF    => true,
				self::SHOW_RELATED => true,
				self::SHOW_DATA    => isset( $includeRelationships['publisher'] ),
				self::DATA         => function () use ( $resource ) {
					return $resource->publisher;
				},
			],
            'authors' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset( $includeRelationships['authors'] ),
                self::DATA         => function () use ( $resource ) {
                    return $resource->authors;
                },
            ],
            'categories' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset( $includeRelationships['categories'] ),
                self::DATA         => function () use ( $resource ) {
                    return $resource->categories;
                },
            ],
            'tags' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset( $includeRelationships['tags'] ),
                self::DATA         => function () use ( $resource ) {
                    return $resource->tags;
                },
            ],
            'users' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset( $includeRelationships['users'] ),
                self::DATA         => function () use ( $resource ) {
                    return $resource->users;
                },
            ],
		];
	}
}
