<?php

class Controller_Files extends Controller_Base {

	public function action_view()
	{
		$id = $this->request->param('id');
		$this->view->file = new Model_File($id);
		if ( ! $this->view->file->id())
		{
			throw new HTTP_Exception_404("File with ID $id was not found");
		}
	}

	public function action_edit()
	{
		$id = $this->request->param('id');
		$file = new Model_File($id);

		if ($this->request->post())
		{
			$is_upload = ! empty($_FILES['upload_file']['tmp_name']);
			$contents = ($is_upload) ? $_FILES['upload_file']['tmp_name'] : $this->request->post('text_file');
			$file->save($this->request->post('name'), $contents, $is_upload, $this->request->post('type'));
			$this->alert('File saved', 'success', TRUE);
			$this->redirect(Route::get('file')->uri(array('id' => $file->id())));
		}
		$this->view->file = $file;
	}

	/**
	 * 
	 */
	public function action_render()
	{
		$id = $this->request->param('id');
		$ext = $this->request->param('ext');
		$size = $this->request->param('size');
		$file = new Model_File($id);
		if ($ext != $file->ext() AND $size==Model_File::SIZE_ORIGINAL)
		{
			$this->redirect(Route::get('render')->uri(array('id' => $file->id(), 'ext' => $file->ext())));
		}
		$cache_filename = $file->rendered_filename($size);
		$filename = $file->id() . '.' . $file->ext() . '.' . substr($cache_filename,-3);
		$this->response->send_file($cache_filename, $filename, array('inline' => TRUE));
	}

}
