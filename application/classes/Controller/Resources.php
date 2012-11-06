<?php

class Controller_Resources extends Controller_Base {

	public function action_view()
	{
		$id = $this->request->param('id');
		$resource = Model_Resource::from_id($id);
		if (!$resource)
		{
			exit('Not Found');
		}
		$this->template->title = $resource['title'];
		$this->view->id = $resource['id'];
		$this->view->title = $resource['title'];
	}

}
