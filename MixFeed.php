<?php
$config = parse_ini_file("config.ini");
foreach ($config[feeds] as $url){
	$feed = simplexml_load_file($url);
	foreach($feed->channel->item as $item){
		$content[]=array('date'=>date_format(date_create_from_format('r',$item->pubDate),'U'),'title'=>$item->title,'link'=>$item->link,'description'=>$item->description);
	}
}
print_r($content);
?>