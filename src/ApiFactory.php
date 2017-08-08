<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 08/08/2017
 * Time: 10:14
 */

namespace SeRanking;

use SeRanking\ApiAdaptor;

/**
 * Class Site
 * @package SeRanking\Entities
 */
class ApiFactory extends ApiAdaptor {

	protected $apiMethod = '';

	public function __construct() {
		parent::__construct();
	}

	public function getSites() {

		$data = array();

		// set method
		$this->apiMethod = 'sites';

		// make request
		$sites = $this->makeRequest();

		// create site objects
		foreach ( $sites as $site ) {
			$data[] = new Site( $site->id );
		}

		return $data;
	}

	public function updateSite( $site ) {

		$this->apiMethod = 'updateSite';

		if ( isset( $site->id ) ) {

			$parameters['siteid'] = $site->id;

			// option params
			if ( isset( $site->title ) ) {
				$parameters['site_title'] = $site->title;
			}
			if ( isset( $site->url ) ) {
				$parameters['site_name'] = $site->url;
			}
			if ( isset( $site->exact_url ) ) {
				$parameters['site_exact_url'] = $site->exact_url;
			}
			if ( isset( $site->active ) ) {
				$parameters['site_active'] = $site->site_active;
			}
			if ( isset( $site->subdomain_match ) ) {
				$parameters['site_subdomain_match'] = $site->subdomain_match;
			}
			if ( isset( $site->depth ) ) {
				$parameters['site_depth'] = $site->depth;
			}

			$response = $this->makeRequest( $parameters );

			return $response->status;
		} else {
			return false;
		}
	}

	public function createSite( $site ) {

		// set method
		$this->apiMethod = 'addSite';

		// set data
		$data = [
			'url'               => $site->url,
			'title'             => $site->title,
			'depth'             => $site->depth,
			'subdomain_match'   => $site->subdomain_match,
			'site_exact_url'    => $site->site_exact_url,
			'manual_check_freq' => $site->manual_check_freq,
			'auto_reports'      => $site->auto_reports,
			'day_of_week'       => $site->day_of_week
		];

		// make request
		$response = $this->makeRequest( null, $data );

		// return id
		return $response->siteid;
	}

	public function destroySite( $site_id ) {
		$this->apiMethod = 'deleteSite';
		$this->makeRequest( [ 'siteid' => $site_id ] );
	}

	public function getSiteKeywords( $site_id ) {

		$this->apiMethod = 'siteKeywords';

		$parameters = [
			'siteid' => $site_id
		];

		$response = $this->makeRequest( $parameters );

		return $response;
	}

	public function getSiteStats( $site_id, $dates, $se = null ) {

		$this->apiMethod = 'stat';

		$parameters = [
			'siteid'    => $site_id,
			'dateStart' => $dates['dateStart'],
			'dateEnd'   => $dates['dateEnd'],
		];

		if ( isset( $se ) ) {
			$parameters['SE'] = $se;
		}

		$response = $this->makeRequest( $parameters );

		return $response;
	}

	public function addSiteKeywords( $site_id, $keywords ) {

		echo 'here';
		$this->apiMethod = 'addSiteKeywords';

		$data = [
			'siteid'   => $site_id,
			'keywords' => $keywords
		];

		$response = $this->makeRequest( null, $data );

		echo '<pre>';
		var_dump( $response );
		echo '</pre>';
	}

	public function destroySiteKeywords( $site_id, $keywords ) {

		$this->apiMethod = 'deleteKeywords';

		$data = [
			'siteid'       => $site_id,
			'keywords_ids' => $keywords
		];

		$response = $this->makeRequest( null, $data );

		return $response;
	}
}