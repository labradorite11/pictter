<?php

require "vendor/abraham/twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

ini_set('session.gc_probability',100);
session_start();

if(isset($_SESSION['access_token'])){

    $user_connect = new TwitterOAuth('8rpQ0O2H00CTNscenflNQkVBo', 'vrxjq0RFc783v4TBGrGhUbX2arooIUcBye4qsHwCecChBGoTJs', $_SESSION['access_token'], $_SESSION['access_token_secret']);

    $user = $user_connect->get("account/verify_credentials");
    if(isset($_GET['prev'])){
        $statuses = $user_connect->get('statuses/home_timeline',array('count' => '200',"include_entities"=>true,'since_id'=>$_GET['prev'] ,'tweet_mode' => 'extended'));
    } else if(isset($_GET['next'])){
        $statuses = $user_connect->get('statuses/home_timeline',array('count' => '200',"include_entities"=>true,'max_id'=>$_GET['next'] ,'tweet_mode' => 'extended'));
    } else {
        $statuses = $user_connect->get('statuses/home_timeline',array('count' => '200',"include_entities"=>true,'tweet_mode' => 'extended'));
    }
    $since = "";
    $max =  "";

    $grid = "";
    $i = 0;
    $count = 0;
    foreach($statuses as $status){
        $count++;
        if($count == 1) { $since = $status->id_str; }
        $max = $status->id_str;
        $photo = $status->extended_entities->media;
        if(isset($photo)){
            foreach($photo as $pic){
                $grid = $grid . "<div class=\"grid-item\"><a href=\"{$pic->media_url}\" class=\"modal\"><img src=\"{$pic->media_url}\" class=\"imgitem\"></a></div>\n";
                // $grid = $grid . "<div id=\"modal{$i}\" style=\"display:none;\"><img src=\"{$pic->media_url}\"></div>";
            }

            // $id = $status->id_str;
            // $tweet = $user_connect->get("statuses/show",array('id' => $id,'include_entities' => 'true','tweet_mode' => 'extended'));
            // if(isset($tweet)){ echo "succeed!"; var_dump($tweet);}

        }
    }

    $page = file_get_contents('pictter_template.html');
    $page = str_replace('{grid}',$grid,$page);

    $prev = "<a href=\"?prev={$since}\">PREV </a>";
    $next = "<a href=\"?next={$max}\">NEXT</a>";
    $logout = "<a href=\"logout.php\">LOGOUT</a>";

    $page = str_replace('{page}',$prev . " " . $next . " " . $logout,$page);

    print $page;


} else {

    $connection = new TwitterOAuth('8rpQ0O2H00CTNscenflNQkVBo','vrxjq0RFc783v4TBGrGhUbX2arooIUcBye4qsHwCecChBGoTJs');
    $request_token = $connection->oauth("oauth/request_token",array("oauth_callback" => "https://photter.herokuapp.com/callback.php"));

    $_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));

$page = file_get_contents('login_template.html');
$page = str_replace('{url}',$url,$page);
print $page;
}
?>
