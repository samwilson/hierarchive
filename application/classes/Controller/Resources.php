<?php

class Controller_Resources extends Controller_Base {

	public function before()
	{
		parent::before();
		require_once DOCROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'markdown'.DIRECTORY_SEPARATOR.'markdown.php';
	}
	
	public function action_view()
	{
		$id = $this->request->param('id');
		if (!$id)
		{
			$this->redirect(Route::url('resource', array('id' => 1), TRUE));
		}
		$resource = new Model_Resource();
		$resource->load_from_id($id);
		if (!$resource->loaded())
		{
			exit('Not Found');
		}
		$this->template->title = $resource->get_title();
		$this->view->resource = $resource;
	}

	public function action_edit()
	{
		$id = $this->request->param('id');
		if ($id)
		{
			$this->view->resource = new Model_Resource($id);
		} else
		{
			$this->view->resource = new Model_Resource();
		}
		if ($this->request->post('save'))
		{
			$this->view->resource->save($this->request->post());
			$this->redirect(Route::url('resource', array('id' => $id), TRUE));
		}
	}

}
