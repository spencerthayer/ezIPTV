<?php
    $v = readData($a);
    $csv = $v["csvUrl"];
    generateList($csv);
    function generateList($x) {
        $file_handle = fopen($x, "r");
        $i = 0;
        while (!feof($file_handle) ) {
            $i++;
            $line_of_text = fgetcsv($file_handle, 1024);
                $active   = $line_of_text[0];
                $error    = $line_of_text[1];
                $region   = $line_of_text[2];
                $code     = $line_of_text[3];
                $category = $line_of_text[4];
                $group    = $line_of_text[5];
                $tag      = $line_of_text[6];
                $id       = $line_of_text[7];
                $name     = $line_of_text[8];
                $epgid    = $line_of_text[9];
                $logourl  = $line_of_text[10];
                $url      = $line_of_text[11];
                $epgurl   = $line_of_text[12];
                $provider = $line_of_text[13];
                $notes    = $line_of_text[14];
                if(!$region && $category){ }
                if($group){ $region = ""; $category = ""; }
                if($category){ $category = " ".$category; }
                if($code){
                    $codeID = $code.": ";
                    $code = " [".$code."]";
                }
                if($tag){ $tag = "(".$tag.") "; }
                if($epgid) { $tvgid = $epgid; }else{ $tvgid = $id; }
            if($active == "yes"){
                print "#EXTINF:-1 ";
                print "tvg-logo=\"".$logourl."\" ";
                print "tvg-id=\"".$tvgid."\""." ";
                print "tvg-name=\"".$id."\" ";
                print "group-title=\"".$group.$region.$category."\",".$tag.$name.$code;
                print "\n";
                print $url."\n";
            }
        }   
    }
?>