<?php

require_once('config.php');

class dBackup_Exception extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        $str = '---------------------------------------------------------------' . "\r\n";
	$str .= 'Error: ' . $this->message . "\r\n";
	$str .= '--------------------------------------------------------------' . "\r\n";
	return $str;
    }
}

?>
