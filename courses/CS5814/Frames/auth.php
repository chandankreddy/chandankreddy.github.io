<?php
//Turn on error display
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Define the directory where the files are stored
$dir = "schedule";

//Define the MIME type to be returned (Default: PDF)
$type = (isset($_GET['type'])) ? $_GET['type'] : "pdf";
$mime = "";
switch($type)
{
	case "pdf": { $mime = "application/pdf"; break; }
	case "html": { $mime = "text/html"; break;}
	case "dat" : { $mime = "application/octet-stream"; break;}
	default : $mime = "application/pdf";
}

//Define valid user/pass
$valid_passwords = array ("cs5525fall16" => "VT.Data.Analytics");
$valid_users = array_keys($valid_passwords);

//Get the user/pass entered by the user
$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];


//Match the user-provided user/pass with the correct user/pass
$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

//If it doesn't match
if (!$validated) 
{
    header('WWW-Authenticate: Basic realm="Authentication for CS 5525"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Incorrect credentials. Please ask the instructor for the login/pass if you do not have it.';
    exit;
}
else
{
	if (!isset($_GET['file']))
	{
		echo 'File not specified';
		exit;
	}
	else
	{	
		//Construct the file path
		$file = $dir . '/' . $_GET['file'];
		if (file_exists($file))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: ' . $mime . '; charset=UTF-8');
			//header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}
	}
}
?>
