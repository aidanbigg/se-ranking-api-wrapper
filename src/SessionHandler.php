<?php

namespace SeRanking;

/**
 * Class SessionHandler
 * @package SeRanking
 */
class SessionHandler {

	/**
	 * Check session has API token
	 * @return bool
	 */
	public static function hasToken() {
		return ( isset( $_SESSION['se_ranking_token'] ) ? true : false );
	}

	/**
	 * @param $token
	 */
	public static function setToken( $token ) {
		$_SESSION['se_ranking_token'] = $token;
	}

	/**
	 * @return mixed
	 */
	public static function getToken() {
		return $_SESSION['se_ranking_token'];
	}

	/**
	 * Clears any relevant session variables
	 */
	public static function clearSession() {
		empty( $_SESSION['se_ranking_token'] );
	}
}