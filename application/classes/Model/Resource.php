<?php

class Model_Resource extends Model {

	private $data;

	private $loaded = FALSE;

	private $contents;

	private $parents;

	public function __construct($id = FALSE)
	{
		if ($id)
		{
			$this->load_from_id($id);
		}
	}

	public function load_from_id($id)
	{
		$this->data = DB::select()
			->from('resources')
			->where('id', '=', $id)
			->execute()
			->current();
		$this->loaded = (bool) $this->data;
	}

	public function has_parents()
	{
		return count($this->get_parents() > 0);
	}

	public function get_parents()
	{
		if (!is_array($this->parents))
		{
			$this->parents = array();
			$id = $this->get_parent_id();
			while ($id)
			{
				$parent = new Model_Resource();
				$parent->load_from_id($id);
				if ($parent->loaded())
				{
					array_unshift($this->parents, $parent);
				} else
				{
					break;
				}
				$id = $parent->get_parent_id();
			}
		}
		return $this->parents;
	}

	public function save($in_data)
	{
		// TODO validate data
		$data = array(
			'title' => $in_data['title'],
			'parent_id' => (is_numeric($in_data['parent_id'])) ? $in_data['parent_id'] : NULL,
			'description' => $in_data['description'],
		);
		if ($this->loaded())
		{
			$query = DB::update('resources')->where('id', '=', $this->get_id());
		} else
		{
			$query = DB::insert('resource');
		}
		$query->set($data)->execute();
	}

	public function loaded()
	{
		return $this->loaded;
	}

	public function get_title()
	{
		return $this->data['title'];
	}

	public function get_parent_id()
	{
		return $this->data['parent_id'];
	}

	public function get_id()
	{
		return (int) $this->data['id'];
	}

	public function get_description()
	{
		return $this->data['description'];
	}

	public function get_contents()
	{
		if (!is_array($this->contents))
		{
			$this->contents = array();
			$contents = DB::select()
				->from('resources')
				->where('parent_id', '=', $this->get_id())
				->execute();
			foreach ($contents as $item)
			{
				$resource = new Model_Resource();
				$resource->load_from_id($item['id']);
				$this->contents[] = $resource;
			}
		}
		return $this->contents;
	}

}