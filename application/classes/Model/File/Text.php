<?php

class Model_File_Text extends Model_File {

	public function mime_types()
	{
		return array(
			'text/plain',
		);
	}

	public function extension()
	{
		return 'txt';
	}

	public function html()
	{
		return '<pre>' . $this->text() . '</pre>';
	}

}
