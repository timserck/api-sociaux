<?php
/* Getting a JSON Facebook Feed
   ==========================================================================
   1. Sign in as a developer at https://developers.facebook.com/
   2. Click "Create New App" at https://developers.facebook.com/apps
   3. Under Apps Settings, find the App ID and App Secret
*/
$appID = '1623422467947244';
$appSecret = '37ca60e19bac2c85de6641a7ff0ebc51';

/* Configuring a JSON Facebook Feed
   ==========================================================================
   1. Find the desired feed ID at http://findmyfacebookid.com/
   2. Set the maximum number of stories to retrieve
   3. Set the seconds to wait between caching the response
*/
$feed = 658665141;
$maximum = 10;
$caching = 60;
/* Enjoying a JSON Facebook Feed
   ==========================================================================
   Visit this URL and make sure everything is working
   Use JSONP by adding ?callback=YOUR_FUNCTION to this URL
   Tweet love or hate @jon_neal
   Permission errors? http://stackoverflow.com/questions/4917811/file-put-contents-permission-denied
*/
$filename = basename(__FILE__, '.php').'.json';
$filetime = file_exists($filename) ? filemtime($filename) : time() - $caching - 1;
if (time() - $caching > $filetime) {
    $authentication = file_get_contents("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$appID}&client_secret={$appSecret}");
    $response = file_get_contents("https://graph.facebook.com/{$feed}/feed?{$authentication}&limit={$maximum}");
    file_put_contents($filename, $response);
} else {
    $response = file_get_contents($filename);
}
header('Content-Type: application/json');
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $filetime).' GMT');
print($_GET['callback'] ? $_GET['callback'].'('.$response.')' : $response);
