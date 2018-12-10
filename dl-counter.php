<?php
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

$plugin_slug = 'auto-load-next-post';

$stats = get_data('https://api.wordpress.org/plugins/info/1.0/' . $plugin_slug . '.json');

$downloads = json_decode($stats, true);

echo $downloads['downloaded'];
