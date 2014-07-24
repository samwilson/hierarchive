<?php

abstract class Controller_Base extends Controller_Template {

	protected $view;

	/** @var string */
	private $alert_session_key = 'alerts';

	protected $alerts = array();

	public function before()
	{
		parent::before();

		$this->template->controller = strtolower($this->request->controller());
		$this->template->action = $this->request->action();
		if (Kohana::find_file('views/' . $this->template->controller, $this->template->action))
		{
			$this->view = View::factory($this->template->controller . '/' . $this->template->action);
		}
		$this->template->title = 'Hierarchives';
		$this->template->view = $this->view;

		// Get postponed alerts
		$this->template->alerts = array();
		foreach (Session::instance()->get($this->alert_session_key, array()) as $alert)
		{
			$this->alert($alert['message'], $alert['type']);
		}
		Session::instance()->set($this->alert_session_key, array());
	}

	/**
	 * Add an alert to the page.
	 *
	 * See http://getbootstrap.com/components/#alerts
	 *
	 * @param string $type One of: success, info, warning, or danger
	 * @param string $message HTML message
	 * @param boolean $postpone Show on next page load
	 * @throws Exception If the type is wrong
	 */
	protected function alert($message, $type = 'info', $postpone = FALSE)
	{
		$valid_types = array('success', 'info', 'warning', 'danger');
		if (!in_array($type, $valid_types))
		{
			throw new Exception("'$type' is not a valid alert type");
		}
		$new_alert = array('type' => $type, 'message' => $message);
		if ($postpone)
		{
			$alerts = Session::instance()->get($this->alert_session_key, array());
			$alerts[] = $new_alert;
			Session::instance()->set($this->alert_session_key, $alerts);
		} else
		{
			$this->template->alerts[] = $new_alert;
		}
	}

}
