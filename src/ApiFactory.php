<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 08/08/2017
 * Time: 10:14
 */

namespace SeRanking;

use SeRanking\Entities\Site;

/**
 *
 * Handles all CRUD methods for the API's entities as well as a few additional common API calls
 *
 * Class ApiFactory
 * @package SeRanking
 */
class ApiFactory extends ApiAdaptor {

	protected $apiMethod = '';

	public function __construct() {
		parent::__construct();
	}

	/*
	 * SITE API FUNCTIONS
	 */

	/**
	 * Gets all websites for account
	 * @return array
	 */
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

	/**
	 * Updates a website dependent on parameters passed
	 *
	 * @param $site
	 *
	 * @return bool
	 */
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

		// attach default search engines
		$searchEngines = [
			'1865' => null,
			'434'  => null,
			'408'  => null
		];
		$this->addSearchEngines( $response->siteid, $searchEngines );

		// return site id
		return $response->siteid;
	}

	public function destroySite( $site_id ) {
		$this->apiMethod = 'deleteSite';
		$this->makeRequest( [ 'siteid' => $site_id ] );
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

	/*
	 * KEYWORD FUNCTIONS
	 */
	public function getSiteKeywords( $site_id ) {

		$this->apiMethod = 'siteKeywords';

		$parameters = [
			'siteid' => $site_id
		];

		$response = $this->makeRequest( $parameters );

		return $response;
	}

	public function addSiteKeywords( $site_id, $keywords ) {

		$this->apiMethod = 'addSiteKeywords';

		$data = [
			'siteid'   => $site_id,
			'keywords' => $keywords
		];

		$response = $this->makeRequest( null, $data );

		return $response;
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

	/*
	 * COMMON API FUNCTIONS
	 */
	public function searchVolumeRegions() {

		$this->apiMethod = 'searchVolumeRegions';

		return $this->makeRequest();
	}

	public function keySearchVolume( $regionId, $keyword ) {
		$this->apiMethod = 'keySearchVolume';

		$parameters = [
			'regionid' => $regionId,
			'keyword'  => urlencode( $keyword )
		];

		return $this->makeRequest( $parameters );
	}

	public function searchEngines() {

		$this->apiMethod = 'searchEngines';

		return $this->makeRequest();
	}

	public function getGoogleLangs() {

		$this->apiMethod = 'getGoogleLangs';

		return $this->makeRequest();
	}

	public function addSearchEngines( $siteId, $searchEngines ) {

		$this->apiMethod = 'updateSiteSE';

		$parameters = [
			'siteid' => $siteId,
		];

		foreach ( $searchEngines as $se_k => $se_v ) {
			$data['se'][ $se_k ] = $se_v;
		}

		$response = $this->makeRequest( $parameters, $data );

		return $response;
	}
}
