<?php

class Model_File extends Model {

	const SIZE_ORIGINAL = 'original';

	const SIZE_LARGE = 'large';

	const SIZE_SMALL = 'small';

	const SIZE_THUMB = 'thumb';

	const SIZE_ICON = 'icon';

	private $id;

	private $name;

	private $type;

	public static $text_types = array(
		'text/plain' => 'txt',
		'text/html' => 'html',
		'text/x-markdown' => 'md',
	);

//	public static function types()
//	{
//		$files = Kohana::list_files('classes/Model/File');
//		$out = array();
//		foreach ($files as $filename)
//		{
//			$out[] = pathinfo($filename, PATHINFO_FILENAME);
//		}
//		return $out;
//	}

	public function __construct($id = NULL)
	{
		if ( ! is_null($id))
		{
			$this->load($id);
		}
	}

	public static function factory($id = NULL)
	{
		$file = new Model_File($id);
		$type_classname = 'Model_File_' . $file->file_class();
		if (class_exists($type_classname))
		{
			return new $type_classname($id);
		}
		return $file;
	}

	public function id()
	{
		return (int) $this->id;
	}

	public function name()
	{
		return $this->name;
	}

	public function type()
	{
		return $this->type;
	}

	/**
	 * Is this a text file?
	 */
	public function is_text()
	{
		return in_array($this->type(), array_keys(self::$text_types));
	}

	public function ext()
	{
		if (isset(self::$text_types[$this->type()]))
		{
			return self::$text_types[$this->type()];
		}
		$types = File::exts_by_mime($this->type());
		if ( ! empty($types))
		{
			return array_shift($types);
		}
		return '';
	}

	public function contents()
	{
		if ( ! $this->id())
		{
			return '';
		}
		else
		{
			return file_get_contents($this->rendered_filename(self::SIZE_ORIGINAL));
		}
	}

	public function load($id)
	{
		$data = DB::select('id', 'name', 'type')
			->from('files')
			->where('id', '=', $id)
			->execute()
			->current();
		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->type = $data['type'];
	}

	public function categories()
	{
		$cats = DB::select()
			->from('file_categories')
			->where('file_id', '=', $this->id)
			->execute();
		$out = array();
		foreach ($cats as $c)
		{
			$out[] = new Model_Category($c['category_id']);
		}
		return $out;
	}

	/**
	 * Save this file, from either text content or a file.
	 *
	 * @param string $name The name of the file
	 * @param string $contents_or_path Full path to file (if $is_file is true), or text content
	 * @param boolean $is_file True if $contents is a filename, false if it's text content
	 */
	public function save($name, $contents_or_path, $is_file = FALSE, $type = NULL)
	{
		// Do not allow override of file types for anything other than text files.
		if ($is_file)
		{
			$file_mime = File::mime($contents_or_path);
			if ($file_mime != 'text/plain')
			{
				$type = $file_mime;
			}
		}

		// Wrap it all in a transaction.
		Database::instance()->begin();

		// Update the database
		if (is_null($this->id))
		{
			// Create a new file record.
			$id = DB::insert('files')
				->columns(array('name', 'type'))
				->values(array($name, $type))
				->execute();
			$this->load($id[0]);
			$change_type = 'file_created';
		}
		else
		{
			// Update the existing record.
			DB::update('files')
				->set(array('name' => $name, 'type' => $type))
				->where('id', '=', $this->id)
				->execute();
			$this->load($this->id);
			$change_type = 'file_modified';
		}
		// The change record is created. @TODO Only include changed items in `details`.
		$change_record = array(
			'file_id'       => $this->id(),
			'date_and_time' => date('Y-m-d H:i:s'),
			'change_type'   => $change_type,
			'details'       => serialize(array('name' => $this->name(), 'type' => $this->type())),
		);
		DB::insert('changes', array_keys($change_record))
			->values($change_record)
			->execute();

		// Save the actual file.
		$new_rev = $this->revision() + 1;
		$path = $this->path() . '/' . $new_rev . '.' . $this->ext();
		Storage::factory()->set($path, $contents_or_path, $is_file);

		// End the transaction.
		Database::instance()->commit();
	}

	public function exists()
	{
		$filename = $this->path() . '/' . $this->revision() . '.' . $this->ext();
		return Storage::factory()->exists($filename);
	}

	/**
	 * Get the full path to a local file representing this File at the given size.
	 * For images, this will be a resized version; for all other files it'll be an icon.
	 *
	 * @param string $size One of the Model_File::SIZE_* constants.
	 * @return string
	 */
	public function rendered_filename($size = 'thumb')
	{
		$filename = $this->path() . '/' . $this->revision() . '.' . $this->ext();
		if ( ! Storage::factory()->exists($filename))
		{
			throw HTTP_Exception::factory(500, 'No file stored for #:id', array(':id'=>$this->id));
		}
		if ($size != self::SIZE_ORIGINAL AND substr($this->type(), 0, 5) != 'image')
		{
			$icon = DOCROOT . 'vendor/teambox/free-file-icons/32px/' . $this->ext() . '.png';
			if (file_exists($icon))
			{
				return $icon;
			} else
			{
				return DOCROOT . 'vendor/teambox/free-file-icons/32px/_blank.png';
			}
		}
		$cache_filename = Kohana::$cache_dir . '/' . $filename;
		if (!is_dir(dirname($cache_filename)))
		{
			mkdir(dirname($cache_filename), 0700, TRUE);
		}
		Storage::factory()->get($filename, $cache_filename);
		if ($size == self::SIZE_ORIGINAL)
		{
			return realpath($cache_filename);
		} elseif ($size == self::SIZE_THUMB)
		{
			$width = 32;
		} elseif ($size == self::SIZE_SMALL)
		{
			$width = 512;
		}
		$resized_name = Kohana::$cache_dir . '/' . $this->path() . '/' . $this->revision() . '_' . $size . '.png';
		if (!is_dir(dirname($resized_name)))
		{
			mkdir(dirname($resized_name), 0700, TRUE);
		}
		Image::factory($cache_filename)
			->resize($width)
			->save($resized_name);
		return $resized_name;
	}

	public function html()
	{
		return $this->text();
	}

	public function path()
	{
		$hash = md5($this->id());
		return substr($hash, 0, 2) . '/' . substr($hash, 2, 2) . '/' . $this->id() . '/';
	}

	/**
	 * Get the latest revision number.
	 *
	 * @return int The number of available revisions.
	 * @return FALSE If no revisions found.
	 */
	public function revision()
	{
		$storage = Storage::factory();
		if (!$storage->exists($this->path()))
		{
			return FALSE;
		}
		return $storage->listing($this->path())->count();
	}

	public function history()
	{
		return DB::select()
			->from('changes')
			->where('file_id', '=', $this->id())
			->order_by('date_and_time', 'DESC')
			->execute();
	}

}
