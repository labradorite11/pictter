<?php
require "vendor/abraham/twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

$twitter_connect = new TwitterOAuth('8rpQ0O2H00CTNscenflNQkVBo', 'vrxjq0RFc783v4TBGrGhUbX2arooIUcBye4qsHwCecChBGoTJs', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$access_token = $twitter_connect->oauth('oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));

$_SESSION['access_token'] = $access_token['oauth_token'];
$_SESSION['access_token_secret'] = $access_token['oauth_token_secret'];


// $user_connect = new TwitterOAuth('8rpQ0O2H00CTNscenflNQkVBo', 'vrxjq0RFc783v4TBGrGhUbX2arooIUcBye4qsHwCecChBGoTJs', $access_token['oauth_token'], $access_token['oauth_token_secret']);
//
// $user = $user_connect->get("account/verify_credentials");
//
// $statuses = $user_connect->get('statuses/home_timeline',array('count' => '30',"include_entities"=>true));
//
// foreach($statuses as $status){
//     $photo = $status->extended_entities->media;
//     echo "HI";
//     if(isset($photo)){
//         foreach($photo as $pic)
//         echo "<img src=\"{$pic->media_url}\"><br/>\n";
//     }
// }

header('Location: ' . "");



?>
