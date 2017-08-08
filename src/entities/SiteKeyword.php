<?php

namespace SeRanking;

class SiteKeyword {

	public $siteid;
	public $id;
	public $name;
	public $group_id;
	public $link;
	public $first_check_date;

	public function __construct( $data = null, $siteId = null ) {
		if ( isset( $data ) ) {
			$this->siteid           = $siteId;
			$this->id               = $data->id;
			$this->name             = $data->name;
			$this->group_id         = $data->group_id;
			$this->link             = $data->link;
			$this->first_check_date = $data->first_check_date;
		} else {
			// new keyword
		}
	}
}