<?php

class Model_File_HTML extends Model_File {

	public function type()
	{
		return 'text/html';
	}

	public function ext()
	{
		return 'html';
	}

	public function html()
	{
		return $this->text();
	}

}
