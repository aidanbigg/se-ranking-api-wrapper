<?php

namespace SeRanking\Entities;

use SeRanking\ApiFactory;

/**
 * Class Site
 * @package SeRanking\Entities
 */
class Site {

	/**
	 * @var string
	 */
	protected $apiMethod = 'sites';

	/**
	 * @var null
	 */
	public $id;

	/**
	 * @var
	 */
	public $title;

	public $url;

	public $depth;

	public $subdomain_match;

	public $exact_url;

	public $manual_check_freq;

	public $auto_reports;

	public $group_id;

	public $day_of_week;

	public $site_active;

	public $keywords;

	/**
	 * Site constructor.
	 *
	 * @param null $id
	 */
	public function __construct( $id = null ) {

		// run here
		if ( ! is_null( $id ) ) {

			// set id
			$this->id = $id;

			// get site
			$this->syncKeywords();
		} else {
			// new site
		}
	}

	public function syncKeywords() {

		$apiFactory = new ApiFactory();

		$keywords = $apiFactory->getSiteKeywords( $this->id );

		$this->keywords = $keywords;
	}

	public function getStats( $dates, $se = null ) {

		$apiFactory = new ApiFactory();

		$stats = $apiFactory->getSiteStats( $this->id, $dates, $se );

		return $stats;
	}
}
