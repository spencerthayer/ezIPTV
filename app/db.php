<?
class Db {
	var $db_file = 'json.db',
	$dataArr = array(),
	$sizeof,
	$num_rows = 0,
	$where = array(),
	$like = array(),
	$order_by = array(),
	$pointer;
	function __construct( $db_file = '' )
	{
		if( $db_file != '' ) $this->db_file = $db_file;
		$this->get();
		$this->do_indexing();
	}
	private function do_where()
	{
		// Where Filter
		if( ! empty( $this->where ) )
		{
			$result = array();
			foreach( $this->dataArr as $row )
			{
				foreach( $this->where as $key => $value )
				{
					if( isset( $row[ $key ] ) && 
							$row[ $key ] == $value )
					{
						$result[] = $row;	
					}
				}
			}
			$this->where = array();
			$this->dataArr = $result;
		}
	}
	private function do_like()
	{
		// Like Filter
		if( ! empty( $this->like ) )
		{
			$result = array();
			foreach( $this->dataArr as $row )
			{
				foreach( $this->like as $key => $value )
				{
					if( isset( $row[ $key ] ) && 
							strpos( $row[ $key ], $value ) != FALSE )
					{
						$result[] = $row;
					}
				}
			}
			$this->like = array();
			$this->dataArr = $result;
		}
	}
	private function do_order_by()
	{
		if( ! empty( $this->order_by ) )
		{
			$sorting = array();
			foreach( $this->dataArr as $key => $row )
			{
				$sorting[ $key ] = $row[ $this->order_by[ 'key' ] ];
			}
			switch( $this->order_by[ 'order' ] )
			{
				case 'ASC': $order = SORT_ASC; break;
				case 'DESC': $order = SORT_DESC; break;
			}
			array_multisort( $sorting, $order, $this->dataArr );
			$this->order_by = array();
		}
	}
	private function do_indexing()
	{
		if( ! empty( $this->dataArr ) )
		{
			$i = 1;
			foreach( $this->dataArr as $key => $value )
			{
				$this->dataArr[ $key ][ '_id' ] = $i;
				$i++;
			}
		}
	}
	private function clear_indexing()
	{
		foreach( $this->dataArr as $key => $value )
		{
			unset( $this->dataArr[ $key ][ '_id' ] );
		}
	}
	private function write_db()
	{
		$json = json_encode( $this->dataArr );
		@file_put_contents( $this->db_file, $json );
	}
	/***
	/*
	/*		PUBLIC METHODS
	/*
	/*/
	public function where( $key, $value )
	{
		$this->where[$key] = $value;
	}
	public function like( $key, $value )
	{
		$this->like[$key] = $value;
	}
	public function order_by( $key, $order = 'DESC' )
	{
		$this->order_by[ 'key' ] = $key;
		$this->order_by[ 'order' ] = $order;
	}
	public function get()
	{
		$this->dataArr = json_decode( @file_get_contents( $this->db_file ), TRUE );
		// Apply filtering
		$this->do_where();
		$this->do_like();
		$this->do_order_by();
		// Set num_rows
		if( empty( $this->dataArr) ) $this->num_rows = 0;
		else $this->num_rows = sizeof( $this->dataArr );
		return $this->dataArr;
	}
	public function insert( $data )
	{
		$this->dataArr[] = $data;
		$this->do_indexing();
		$this->write_db();
	}
	public function update( $data )
	{
		$rows = $this->get(); // First query will reset WHERE and LIKE filters
		$rows_full = $this->get();
		foreach( $rows as $row )
		{
			foreach( $data as $key => $value )
			{
				$row[ $key ] = $value;
			}	
			foreach( $rows_full as $key => $value )
			{
				if( $rows_full[ $key ][ '_id' ] == $row[ '_id' ] )
				{
					$rows_full[ $key ] = $row;
				}
			}
		}
		$this->dataArr = $rows_full;
		$this->write_db();
	}
	public function delete()
	{
		$rows = $this->get(); // First query will reset WHERE and LIKE filters
		$rows_full = $this->get();
		foreach( $rows as $row )
		{
			foreach( $rows_full as $key => $value )
			{
				if( $rows_full[ $key ][ '_id' ] == $row[ '_id' ] )
				{
					unset( $rows_full[ $key ] );
				}
			}
		}
		$this->dataArr = $rows_full;
		$this->write_db();
	}
}
