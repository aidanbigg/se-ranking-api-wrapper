<?php

namespace SeRanking;

/**
 *
 * Provides the Factory with the the ApiInterface
 *
 * Class ApiAdaptor
 * @package SeRanking
 */
class ApiAdaptor extends ApiInterface {

	/**
	 * @var
	 */
	private $username;

	/**
	 * @var
	 */
	private $password;

	/**
	 * @var
	 */
	private $response;

	/**
	 * @var
	 */
	protected $apiMethod;

	/**
	 * ApiAdaptor constructor.
	 */
	public function __construct() {

		// attempt to authenticate
		try {

			// set username & password
			$this->setUsername();
			$this->setPassword();

			// authenticate
			$this->authenticate();

		} catch ( ApiAdaptorException $e ) {
			echo $e;
		}
	}

	/**
	 *
	 */
	private function authenticate() {

		// set parameters
		$parameters = [
			'login' => $this->username,
			'pass'  => md5( $this->password )
		];

		// continue authentication
		try {
			$this->get( 'login', 'GET', $parameters );

			// set session token
			SessionHandler::setToken( $this->response->token );
		} catch ( ApiAdaptorException $e ) {
			echo $e;
		}
	}

	/**
	 * Handles response
	 *
	 * @param $response
	 *
	 * @return mixed
	 */
	public function _handleResponse( $response ) {

		// decode json
		$this->response = json_decode( $response );

		// message
		if ( $this->response->code == 400 ) {
			throw new ApiAdaptorException( 'Status 400 Error: ' . $this->response->message );
		} else if ( $this->response->code == 403 ) {
			throw new ApiAdaptorException( $this->response->message );
		} else {
			switch ( $this->response->message ) {
				case 'Incorrect username or password':
					throw new ApiAdaptorException( 'Error handling response from API (' . $this->response->message . ')' );
					break;
				default:
					return true;
					break;
			}
		}
	}

	/**
	 * @return bool
	 * @throws ApiAdaptorException
	 */
	private function setUsername() {

		// set username
		$this->username = getenv( 'SE_RANKING_USERNAME' );

		// check valid
		if ( $this->username == '' ) {
			throw new ApiAdaptorException( 'No username set in environment' );
		} else {
			return true;
		}
	}

	/**
	 * @return bool
	 * @throws ApiAdaptorException
	 */
	private function setPassword() {

		// set password
		$this->password = getenv( 'SE_RANKING_PASSWORD' );

		// check valid
		if ( $this->password == '' ) {
			throw new ApiAdaptorException( 'No password set in environment' );
		} else {
			return true;
		}
	}

	public function makeRequest( $parameters, $data ) {

		// check we have a token
		if ( SessionHandler::hasToken() ) {

			// set the token param
			$parameters['token'] = SessionHandler::getToken();

			// carry out the request
			try {

				$this->get( $this->apiMethod, 'GET', $parameters, $data );

				return $this->response;
			} catch ( ApiAdaptorException $e ) {
				echo $e;
			}
		} else {
			$this->authenticate();
		}
	}
}