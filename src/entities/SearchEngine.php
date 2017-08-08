<?php

namespace SeRanking\Entities;

use SeRanking\ApiAdaptor;

/**
 * Class SearchEngine
 * @package SeRanking\Entities
 */
class SearchEngine extends ApiAdaptor {

	/**
	 * @var string
	 */
	protected $apiMethod = 'searchEngines';

	/**
	 * @var
	 */
	private $id;

	/**
	 * @var
	 */
	private $name;

	/**
	 * @var
	 */
	private $regionid;

	/**
	 * @var
	 */
	private $regions;

	/**
	 * SearchEngine constructor.
	 *
	 * @param null $id
	 */
	public function __construct( $id = null ) {
		parent::__construct();
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getRegionid() {
		return $this->regionid;
	}

	/**
	 * @param mixed $regionid
	 */
	public function setRegionid( $regionid ) {
		$this->regionid = $regionid;
	}

	/**
	 * @return mixed
	 */
	public function getRegions() {
		return $this->regions;
	}

	/**
	 * @param mixed $regions
	 */
	public function setRegions( $regions ) {
		$this->regions = $regions;
	}
}