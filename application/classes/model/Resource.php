<?php

class Model_Resource extends Model {

	public static function from_id($id)
	{
		$resource = DB::select()
				->from('resources')
				->where('id', '=', $id)
				->execute()
				->current();
		return $resource;
	}
	
	public function get_description()
	{
		return '';
	}

}