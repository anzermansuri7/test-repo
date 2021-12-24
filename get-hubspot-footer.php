<?php
$url = "https://www.streetlightdata.com/";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$res = curl_exec($ch);

curl_close($ch);

$dom = new DomDocument();
@$dom->loadHTML($res);

//Get the nodes
$xpath = new DOMXpath($dom);
$footer_nav = $xpath->evaluate("//div[contains(@id,'footer-outer')]")->item(0);


//Save to HTML strings
$footer_nav = $footer_nav->ownerDocument->saveXML($footer_nav);

//Replace relative paths
$footer_nav = str_replace('href="/', 'href="'.$url, $footer_nav);

$navJson = json_encode(
	array(
		'footer' => $footer_nav,
	)
);

?>

var SLD_WP_FOOTER_HTML = <?=$navJson?>;