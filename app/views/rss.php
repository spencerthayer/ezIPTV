<?php
$u = getURI();
$v = readData($a);
$itemURL = $u["protocol"].getAuth()."@".$u["server"]."/".$v["uid"];
$rss_array = $v["rssUrl"];
$limit = 2;
$startTime = date("YmdGis O",strtotime("-1 day"));
$endTime = date("YmdGis O",strtotime("+1 day"));
if ($epg) {
    print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    print "<!DOCTYPE tv SYSTEM \"xmltv.dtd\">";
    print "<tv date=\"".date("YmdGis 0")."\" source-info-name=\"RSS EPG\" source-info-url=\"".$url."\">";
}
for ($i=0; $i<count($rss_array); $i++ ) {
    // if(++$i > $limit) break;
    $rssfeed = simplexml_load_file($rss_array[$i]);
    foreach ($rssfeed->channel as $channel) {
        // $podcast = $channel->title;
        $thumbnail = $channel->image->url;
        $channel = str_ireplace(',','',$channel->title);
    }
    $num = 0;
    foreach ($rssfeed->channel->item as $item) {
        $title = $item->title;
        $titleM3U = str_ireplace(',','',$title);
        $titleEPG = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', filter_var(str_ireplace('/,"+;)/','',$title), FILTER_SANITIZE_STRING, FILTER_SANITIZE_EMAIL));
        $description = $item->description;
        $description = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', filter_var(str_ireplace('','',$description), FILTER_SANITIZE_STRING, FILTER_SANITIZE_EMAIL));
        $pubDate = strtotime($item->pubDate);
        $date = date('Y-m-d', $pubDate);
        $url = $item->enclosure[url];
        $itemNum = $num++;
        //
        if ($epg) {
            print "<channel id=\"".$pubDate.$itemNum."\">";
            print "<display-name>".$channel."</display-name>";
            print "</channel>";
            print "<programme start=\"".$startTime."\" stop=\"".$endTime."\" channel=\"".$pubDate.$itemNum."\">";
            print "<title lang=\"en\">".$titleEPG."</title>";
            print "<desc lang=\"en\">".$description."</desc>";
            print "</programme>";
            // print "\n";
        } elseif (!$epg) {
            print "#EXTINF:-1 ";
            print "tvg-logo=\"".$thumbnail."\" ";
            print "tvg-id=\"".$pubDate.$itemNum."\" ";
            print "tvg-url=\"".$itemURL."/rss/epg\" ";
            print "group-title=\"📺 ".$channel."\",".$date." | ".$titleM3U;
            print "\n";
            print $url."\n";
        }
    }
}
if ($epg) {
    print "</tv>";
}
?>
