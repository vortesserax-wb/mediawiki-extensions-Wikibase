<?php declare( strict_types=1 );

namespace Wikibase\Repo\RestApi\Application\Serialization;

use Throwable;

/**
 * @license GPL-2.0-or-later
 */
class InvalidFieldException extends SerializationException {
	private string $field;

	/** @var mixed */
	private $value;

	/**
	 * @param string $field
	 * @param mixed $value
	 * @param string $message
	 * @param Throwable|null $previous
	 */
	public function __construct( string $field, $value, string $message = '', Throwable $previous = null ) {
		$this->field = $field;
		$this->value = $value;

		parent::__construct( $message, 0, $previous );
	}

	public function getField(): string {
		return $this->field;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}
}
