<?php

namespace App\JsonApi\Publishers;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider {

	/**
	 * @var string
	 */
	protected $resourceType = 'publishers';

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
			'name'       => $resource->name,
			'short_name' => $resource->short_name,
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
			'books' => [
				self::SHOW_SELF    => true,
				self::SHOW_RELATED => true,
				self::SHOW_DATA    => isset( $includeRelationships['books'] ),
				self::DATA         => function () use ( $resource ) {
					return $resource->books;
				},
			],
		];
	}
}
