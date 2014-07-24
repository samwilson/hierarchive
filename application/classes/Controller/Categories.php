<?php

class Controller_Categories extends Controller_Base {

	public function action_index()
	{
		$id = $this->request->param('id');
		$this->view->category = new Model_Category($id);
		if (count($this->view->category->subcategories()) == 0)
		{
		}
	}

	public function action_edit()
	{
		$id = $this->request->param('id');
		$this->view->category = new Model_Category($id);
	}

}
