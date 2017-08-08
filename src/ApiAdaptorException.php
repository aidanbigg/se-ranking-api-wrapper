<?php

namespace SeRanking;

/**
 * Class ApiAdaptorException
 * @package SeRanking
 */
class ApiAdaptorException extends \Exception {

	protected $title;

	public function __( $title, $message, $code = 0, \Exception $previous = null ) {

		$this->title = $title;

		parent::__construct( $message, $code, $previous );
	}

	public function getTitle() {
		return $this->title;
	}
}