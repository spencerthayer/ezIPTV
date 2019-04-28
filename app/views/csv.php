<?php
ini_set("memory_limit", "256M");
error_reporting(1);
function cleanQuote($x) {
  return str_replace(array("\""), "", $x);
}
function cleanComma($x){
  if (strpos($x,",") !== false) {
    echo "\"".cleanQuote($x)."\"";
  } else { echo cleanQuote($x); }
}
function useCode($x){
  if (strpos($x,": ") !== false) {
    cleanComma(trim(explode(": ", $x)[0]));
  } else { cleanComma($x); }
}
function trimCode($x){
  if (strpos($x,": ") !== false) {
    cleanComma(trim(explode(": ", $x)[1]));
  } else { cleanComma($x); }
}
function multiRequest($data, $options = array()) {
    // array of curl handles
    $curly = array();
    // data to be returned
    $result = array();
    // multi handle
    $mh = curl_multi_init();
    // loop through $data and create curl handles
    // then add them to the multi-handle
    foreach ($data as $id => $d) {
      $curly[$id] = curl_init();
      $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
      curl_setopt($curly[$id], CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curly[$id], CURLOPT_MAXREDIRS, 5);
      curl_setopt($curly[$id], CURLOPT_URL, $url);
      curl_setopt($curly[$id], CURLOPT_HEADER, 0);
      curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
      // post?
      if (is_array($d)) {
        if (!empty($d['post'])) {
          curl_setopt($curly[$id], CURLOPT_POST, 1);
          curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
        }
      }
      // extra options?
      if (!empty($options)) {
        curl_setopt_array($curly[$id], $options);
      }
      curl_multi_add_handle($mh, $curly[$id]);
    }
    // execute the handles
    $running = null;
    do {
      curl_multi_exec($mh, $running);
    } while($running > 0);
    // get content and remove handles
    foreach($curly as $id => $c) {
      $result[$id] = curl_multi_getcontent($c);
      curl_multi_remove_handle($mh, $c);
    }
    // all done
    curl_multi_close($mh);
    return $result;
  }

function parseM3U($data = array()) {
    $regex = '/(?P<tag>#EXTINF)|(?:(?P<prop_key>[-a-z]+)=\"(?P<prop_val>[^"]+)")|(?<extraItem>,[^\r\n]+)|(?<url>http[^\s]+)/';
    $string = multiRequest($data);
    $string = implode($string);
    preg_match_all($regex, $string, $match );
    $count = count( $match[0] );
    $result = [];
    $index = -1;
    for( $i =0; $i < $count; $i++ ){
        $item = $match[0][$i];
        if( !empty($match['tag'][$i])){
            //is a tag increment the result index
            ++$index;
        }elseif( !empty($match['prop_key'][$i])){
            $result[$index][$match['prop_key'][$i]] = $match['prop_val'][$i];
        }elseif( !empty($match['extraItem'][$i])){
            $result[$index]['group-name'] = str_replace(array("\"", ","), "", $item);
        }elseif( !empty($match['url'][$i])){
            $result[$index]['url'] = $item ;
        }
    }
    return $result;
}
function filterM3U(){
  // download the file
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "<M3U_LINK>");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec($ch);
  curl_close ($ch);

  // write to file
  $fp = fopen('tv_channels.m3u', 'w');
  fwrite($fp, $result);
  fclose($fp);

  // filter the file
  echo "#EXTM3U\n";
  exec('grep -E "^#EXTINF.*tvg\-name=\"([^#])*\".*group\-title=\"(NHL|NBA|Canada|USA Entertainment|USA Docs & News|Latino|USA Sports)\"" -A 1 tv_channels.m3u | sed "/^--$/d"', $out);
  foreach($out as $line) {
      echo $line."\n";
  }
}
function createCSV($data){
  header("content-type: text/csv");
  header("content-disposition: attachment; filename=".date('YmdHBis').".csv");
  echo "ACTIVE,ERROR,REGION,CODE,CATEGORY,GROUP,TAG,ID,NAME,EPGID,LOGOURL,URL,EPGURL,PROVIDER,NOTES\n";
  foreach ($data as $row) {
      echo "YES,";//ACTIVE
      echo ",";//ERROR
      cleanComma($row["group-title"]);echo ","; //REGION
      useCode($row["tvg-name"]);echo ",";//CODE
      echo ",";//CATEGORY
      echo ",";//GROUP
      echo ",";//TAG
      cleanComma($row["group-name"]);echo ",";//ID
      trimCode($row["tvg-name"]);echo ",";//NAME
      cleanComma($row["tvg-id"]);echo ",";//EPGID
      cleanComma($row["tvg-logo"]);echo ",";//LOGO
      cleanComma($row["url"]);echo ",";//URL
      cleanComma($row["epg-url"]);//EPGURL
      echo ",";//PROVIDER
      echo ",";//NOTES
      echo "\n";
  }
}
function createJSON($data){
  header("content-type: text/json");
  header("content-disposition: attachment; filename=".date('YmdHBis').".json");
  echo json_encode($data, JSON_PRETTY_PRINT);
}
$v = readData($a);
$urls = (array) $v["m3uUrl"];
$arrayM3U = parseM3U($urls);
createCSV($arrayM3U);
?>