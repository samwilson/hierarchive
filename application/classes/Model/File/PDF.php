<?php

class Model_File_PDF extends Model_File {

	public function type()
	{
		return 'application/pdf';
	}

	public function ext()
	{
		return 'pdf';
	}

	public function html()
	{
		return '';
	}

}
