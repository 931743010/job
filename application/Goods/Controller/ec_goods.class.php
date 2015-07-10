<?php
class ec_goods{
	private $client;
	
	function __construct() {
		$this->client = elasticsearch();
		$this->index = 'ec_hmv';
		$this->type = 'ec_goods';
	}
	/**
	 * @todo index
	 * @param int $id
	 * @param array $data
	 */
	function create( $id, $data ){
		if ($data) {
			$params = array();
			$params['body']  = $data;
			$params['index'] = $this->index;
			$params['type']  = $this->type;
			$params['id']    = $id;
			$ret = $this->client->index( $params );
		}
	}
	/**
	 * @todo update Data
	 * @param int $id
	 * @param array $data
	 */
	function update( $id, $data ){
		if( $data ){
			$params['body']['doc']  = $data;
			$params['index'] = $this->index;
			$params['type']  = $this->type;
			$params['id']    = $id;
			$ret = $this->client->update( $params );
		}
	}
	/**
	 * @todo batch update Data
	 * @param int $ids
	 * @param array $data
	 */
	function updates( $ids, $data ){
		if( $data ){
			foreach( $ids as $id ){
				$params['body']['doc']  = $data;
				$params['index'] = $this->index;
				$params['type']  = $this->type;
				$params['id']    = $id;
				$ret = $this->client->update( $params );
			}
		}
	}
	/**
	 * @todo delete 
	 */
	function delete( $id ){
		if( $id ){
			$params['index'] = $this->index;
			$params['type']  = $this->type;
			$params['id']    = $id;
			$ret = $this->client->delete( $params );
		}
	}
	/**
	 * @todo delete
	 */
	function deletes( $ids ){
		if( $id ){
			foreach( $ids as $id ){
				$params['index'] = $this->index;
				$params['type']  = $this->type;
				$params['id']    = $id;
				$ret = $this->client->delete( $params );
			}
		}
	}
}
?>