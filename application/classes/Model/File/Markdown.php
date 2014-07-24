<?php

class Model_File_Markdown extends Model_File {

	public function type()
	{
		return 'text/x-markdown';
	}

	public function ext()
	{
		return 'md';
	}

	public function html()
	{
		return Michelf\MarkdownExtra::defaultTransform($this->text());
	}

}
