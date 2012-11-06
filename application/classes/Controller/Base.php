<?php

abstract class Controller_Base extends Controller_Template {

	public $template = 'base';

	public $view;

	public function before()
	{
		parent::before();
		$this->view = View::factory($this->request->action());
		$this->template->title = 'Hierarchives';
		$this->template->body = $this->view;
	}

}