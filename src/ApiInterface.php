<?php
// https://stackoverflow.com/questions/4634583/php-oop-building-an-api-wrapper-class
namespace SeRanking;

/**
 * Class ApiInterface
 * @package SeRanking
 */
abstract class ApiInterface {

	private $baseUrl = 'https://online.seranking.com/structure/clientapi/v2.php?';

	public function __construct( $baseUrl ) {
		$this->baseUrl = $baseUrl;
	}

	abstract protected function _handleResponse( $response );

	public function get( $apiMethod, $method = 'GET', $parameters = null, $data = null ) {

		// append api_method
		$url = $this->baseUrl . 'method=' . $apiMethod;

		// append parameters
		if ( ! is_null( $parameters ) ) {
			foreach ( $parameters as $p_k => $p_v ) {
				$url .= '&' . $p_k . '=' . $p_v;
			}
		}

		// set data
		$data = array(
			'data' => json_encode( $data )
		);

		$response = $this->request( $url, $data, $method );

		$this->_handleResponse( $response );
	}

	public function request( $url, $data, $method ) {

		// init curl
		$curl = curl_init();

		// set options
		curl_setopt_array( $curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL            => $url,
			CURLOPT_POST           => ( $method == 'POST' ? 1 : 0 ),
			CURLOPT_POSTFIELDS     => $data
		) );

		// execute request
		$response = curl_exec( $curl );

		// close curl
		curl_close( $curl );

		// return response
		return $response;
	}
}