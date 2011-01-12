<?php
$config = parse_ini_file("config.ini");
require_once(./simplepie.inc);
foreach ($config[feeds] as $url){
	$feed=new SimplePie();
	$feed->set_feed_url($url);
	$feed->init();
	$feed->handle_content_type();
}
//print_r($content);
?>