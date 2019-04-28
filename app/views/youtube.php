<!DOCTYPE html>
<html>
<head>
    <title>Youtube Download</title>
    <style type="text/css">
        body {
          background: #eee;
        }
    </style>
</head>
<body>


<?php if(!isset($_GET['id'])){ ?>
    <div class="">
        <p class="text-center">
            Please Insert Video Id .
        </p>
    </div>
<?php }else{
    $channelid = $_GET["id"];

    ini_set("user_agent","facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)");
    /* gets the data from a URL */
function get_data($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)");
    curl_setopt($ch, CURLOPT_REFERER, "http://facebook.com");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
$urlVideoDetails = "https://www.youtube.com/get_video_info?video_id=".$channelid."&el=detailpage";
// $string = get_data($urlVideoDetails);
$returnedData = get_data($urlVideoDetails);
// $parts = parse_url($returnedData);
parse_str($returnedData, $query);
// echo $query['hlsvp'];
$downloadUrl = $query['hlsvp'];
header("Location: $downloadUrl");
} ?>

</body>
</html>
