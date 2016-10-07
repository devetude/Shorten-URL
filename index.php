<?
$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__);

if( file_exists("DEBUG") ){
	ini_set('display_errors', 1); 
	error_reporting(E_ALL^E_NOTICE^E_WARNING);
}else{
	ini_set('display_errors', 0); 
	error_reporting(0);
}


$page=$_GET['fhc_page'];
if( empty($page) ) $page='index';

$path=$_SERVER['DOCUMENT_ROOT']."/app/controllers/";
$viewpath_default=$page.".html";

$job=$path.$page.".php";
if( !is_file($job) ){
	if( is_dir($path.$page) ){
		$job=$path.$page."/index.php";
		$viewpath_default=$page."/index.html";
	}
}

if( !preg_match("/^".preg_quote($path,'/')."/" , realpath($job))) {
	include_once("lib/classes/DB.php");
	include_once("lib/classes/URL.php");

	$url = new URL();

	$shorten_url = $page;
	$original_url = $url->get_original_url($shorten_url)->original_url;

	if($original_url != null) {
		$url->add_url_hits($shorten_url);
	}

	header("Location:".$original_url);
	exit;
}

$res=Array();

// Preload from defined
$preload_list=array("lib/include/class_loader.php","lib/include/core.php");
foreach($preload_list as $filename){
	include($filename);
}

foreach(glob("lib/include/*.*") as $filename){
	if( in_array($filename,$preload_list ) ) continue;
	include($filename);
}

include $job;

if( !defined("__RENDERED__") ){
	render($viewpath_default);
}

define("__FHC_END__",true);
?>
