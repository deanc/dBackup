<?php

require_once('global.php');

class Backup
{
    private $apps = array();

    function __construct()
    {
	$iterator = new DirectoryIterator(APPS_DIR);
	foreach ($iterator as $fileinfo)
	{
	    if(!$fileinfo->isDot() AND $fileinfo->isDir())
	    {
		$this->apps[] = $fileinfo->getFilename();
	    }
	}

	// make some more interesting objects
    }

    public function run()
    {
	$this->createDirectories();

	$classes = array();
	foreach($this->apps AS $app)
	{
	    require_once(APPS_DIR . '/' . $app . '/backup.php');
	    $className = 'dBackup_' . ucfirst($app);
	    $class = new $className;
	    $classes[] = $class;
	}

	try
	{
	    // before
	    foreach($classes AS $c)
	    {
		$c->beforeRun();
	    }
	}
	catch(Exception $e)
	{
	    echo $e;die;
	}

	// run
	foreach($classes AS $c)
	{
	    $c->run();
	}

	// after
	foreach($classes AS $c)
	{
	    $c->afterRun();
	}
    }

    private function createDirectories()
    {
	if(!is_dir(BACKUPS_DIR))
	{
	    throw new dBackup_Exception('Directory to output backups does not exist');
	}
	else
	{
	    $dirname = date('Y-m-d');
	    
	    // wipe it if it already exists
	    if(is_dir(BACKUPS_DIR . '/' . $dirname))
	    {
		// suppress nasty errors here
		@unlink(BACKUPS_DIR . '/' . $dirname);
	    }

	    // continue to create the directory if we can
	    if(!is_dir(BACKUPS_DIR . '/' . $dirname) AND !mkdir(BACKUPS_DIR . '/' . $dirname))
	    {
		throw new dBackup_Exception('You don\'t have the necessary permissions to create your backup directories');
	    }

	    // if we got here, the directory exists
	    foreach($this->apps AS $app)
	    {
		mkdir(BACKUPS_DIR . '/' . $dirname . '/' . $app);
	    }
	}
    }
}

$backup = new Backup;
$backup->run();

?>