<?php
    $u = getURI();
    $v = readData($a);
    $itemURL = $u["protocol"].getAuth()."@".$u["server"]."/".$v["uid"];
    function update($x){
        if(!$x) {
            echo "/";
        } else {
            echo "/".$x."/update";
        }
    }
?>
    <div class="container p-1"><br/>
        <ul class="nav nav-justified">
            <li class="nav-item"><a href="<?=$itemURL;?>/csv" target="_blank"><button type="button" class="btn btn-sm info-color text-white z-depth-0 waves-effect">CSV</button></a></li>
            <li class="nav-item"><a href="<?=$itemURL;?>/m3u" target="_blank"><button type="button" class="btn btn-sm info-color text-white z-depth-0 waves-effect">M3U</button></a></li>
            <li class="nav-item"><a href="<?=$itemURL;?>/rss" target="_blank"><button type="button" class="btn btn-sm info-color text-white z-depth-0 waves-effect">RSS</button></a></li>
            <li class="nav-item"><a href="<?=$itemURL;?>/rss/epg" target="_blank"><button type="button" class="btn btn-sm info-color text-white z-depth-0 waves-effect">EPG</button></a></li>
            <li class="nav-item"><a href="<?=$itemURL;?>/all" target="_blank"><button type="button" class="btn btn-sm info-color text-white z-depth-0 waves-effect">ALL</button></a></li>
        </ul>
    </div>
    <form action="<? update($v["uid"]); ?>" method="post" class="p-5" style="padding-top:0px;">
        <input type="hidden" id="uid" name="uid" value="<?=$u["path"];?>">
        <!-- <p class="h4 mb-4"><a href="/<?=$v["uid"];?>"> <?=$v["title"];?></a></p> -->
        <div class="md-form mb-4">
            <input type="text" id="title" name="title" class="form-control" value="<?=$v["title"];?>">
            <label for="title">Title of the URL.</label>
            <small id="title" class="form-text text-muted">
                Note: a title is not required and is used only to help organize the list.
            </small>
        </div>
        <div class="md-form mb-4">
            <input type="text" id="csvUrl" name="csvUrl" class="form-control" value="<?=$v["csvUrl"];?>">
            <label for="csvUrl">Link to the CSV used to generate the M3U.</label>
            <small id="csvUrl" class="form-text text-muted">
                Note: the CSV must be formatted according to the standards in the
                <a href="https://github.com/spencerthayer/ezIPTV">ezIPTV</a> documentation.
            </small>
        </div>
        <div class="md-form mb-4">
            <!-- <i class="fas fa-angle-double-right prefix"></i> -->
            <textarea name="m3uUrl" id="m3uUrl" class="md-textarea form-control" rows="3"><?=line($v["m3uUrl"]);?></textarea>
            <label for="m3uUrl">M3U links to be converted into a CSV file.</label>
            <small id="m3uUrl" class="form-text text-muted">
            Note: use only one M3U URL per line.
            </small>
        </div>
        <div class="md-form mb-4">
            <!-- <i class="fas fa-angle-double-right prefix"></i> -->
            <textarea name="rssUrl" id="rssUrl" class="md-textarea form-control" rows="5"><?=line($v["rssUrl"]);?></textarea>
            <label for="rssUrl">RSS links to create the video on demand M3U link.</label>
            <small id="rssUrl" class="form-text text-muted">
                Note: use only one RSS URL per line.
            </small>
        </div>
        <button class="btn btn-lg aqua-gradient text-white" type="submit"><i class="far fa-save"></i> SAVE DATA</button>
        <a href="/<?=$v["uid"];?>/delete" class="btn btn-lg ripe-malinka-gradient text-white"><i class="far fa-trash-alt"></i> DELETE</a>
    </form>
