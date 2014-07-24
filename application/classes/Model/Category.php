<?php

class Model_Category extends Model {

	private $id;

	private $name;

	public function __construct($id = NULL)
	{
		if (!is_null($id))
		{
			$this->load($id);
		}
	}

	public function name()
	{
		return $this->name;
	}

	public function load($id)
	{
		$data = DB::select()
			->from('categories')
			->where('id', '=', $id)
			->execute();
		$this->id = $data->id;
		$this->name = $data->name;
	}

	public function subcategories()
	{
		$cats = DB::select('id', 'name')->from('categories');
		if (is_null($this->id))
		{
			$cats->where('parent_id', 'IS', NULL);
		} else
		{
			$cats->where('parent_id', '=', $this->id);
		}
		$out = array();
		foreach ($cats->execute() as $c)
		{
			$out[] = new Model_Category($c->id);
		}
		return $out;
	}

	public function files()
	{
		$files = array();
		if (is_null($this->id))
		{
			$files = DB::select('id')
				->from('files')
				->join('file_categories', 'LEFT')->on('file_categories.file_id', '=', 'files.id')
				->where('file_categories.file_id', 'IS', NULL)
				->execute();
		}
		$out = array();
		foreach ($files as $f)
		{
			$out[] = new Model_File($f['id']);
		}
		return $out;
	}

}
