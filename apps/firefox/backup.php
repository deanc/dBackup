<?php

require_once('config.php');

class dBackup_Firefox
{
    public function beforeRun()
    {
	if(!is_dir('MOZBACKUP_PATH'))
	{
	    throw new dBackup_Exception('MozBackup directory doesn\'t exist. Make sure you have it installed');
	}
    }

    public function run()
    {
	echo 'Backing up firefox';
    }

    public function afterRun()
    {

    }
}

?>
