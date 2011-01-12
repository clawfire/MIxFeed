<?php
/* Read the config file */
$config = parse_ini_file("config.ini");
/* Load rss library */
require_once('./simplepie.inc');
/* Load Rss feeds */
$feeds = new SImplePie($config[feeds]);
/* Set the per feed item limit */
$feeds->set_item_limit($config[limit_per_feed]);
/* Set the cache time */
$feeds->set_cache_duration ($config[caching_time]);
/* Enable Direct render outpout (without sanitize and cleaning) */
$feeds->enable_xml_dump(isset($_GET['xmldump']) ? true : false);
/* Init Feeds Grabbing */
$loaded=$feeds->init();
/* Ensure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it). */
$feeds->handle_content_type();

/* Starting render a feed */
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.00">
<channel>
<title><?php echo $config[feed_title];?></title>
<link><?php echo $config[feed_refer_url];?></link>
<description>
	<?php echo $config[feed_description];?>
</description>
<language><?php echo $config[feed_language];?></language>
<?php if ($loaded) {
	$itemlimit=0;
	foreach($feeds->get_items() as $item) {
		if ($itemlimit==$config[max_items]) { break; }
?>
	<item>
	<title><?php echo $item->get_title(); ?></title>
	<link><?php echo $item->get_permalink(); ?></link>
	<description>
		<?php echo $item->get_description(); ?>
	</description>
	</item>
<?
	$itemlimit = $itemlimit + 1;
	}
}
?>
</channel>
</rss>