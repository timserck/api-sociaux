<?php
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "1459194816-kyG3qE5gfECXlsaQvpLit1KtyI8OnHHNMUFRgl6",
'oauth_access_token_secret' => "ZB9Xq7Kc1LjK7TUVYrlvlX3IIEu0oK22amnRAhHcIOWAu",
'consumer_key' => "sltaPYgW6a0njbMYI5byBSrKp",
'consumer_secret' => "TP33P8lSkRH88Gua8aS2iSsEyDjAjsHPAmwHDzlZGAgODAToc5"
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
//change de request here
if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = "Serck_Timothee";}
if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 20;}
$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
foreach($string as $items)
    {
        echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo "Tweet: ". $items['text']."<br />";
        echo "Tweeted by: ". $items['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
?>
