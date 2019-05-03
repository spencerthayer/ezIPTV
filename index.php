<?php
    ini_set("memory_limit", "256M");
    error_reporting(E_ALL);
    require("app/vars.php");
    require("app/link.php");
    require("app/db.php");
    if (!file_exists(".htaccess")) {
        header("location: ./setup");
        die;
    }
    // ROUTING
    $routes = array(
        $pathRoot."/" => "indexController",
        $pathRoot."/{a}" => "itemController",
        $pathRoot."/{a}/all" => "allController",
        $pathRoot."/{a}/csv" => "csvController",
        $pathRoot."/{a}/delete" => "deleteData",
        $pathRoot."/{a}/m3u" => "m3uController",
        $pathRoot."/{a}/rss" => "rssController",
        $pathRoot."/{a}/rss/epg" => "epgController",
        $pathRoot."/{a}/update" => "updateData",
        $pathRoot."/add" => "addController",
        $pathRoot."/example" => "createExample",
        $pathRoot."/f/{a}/",
        $pathRoot."/f/{a}/edit" => "fileController",
        $pathRoot."/f/{a}/delete" => "fileController",
        $pathRoot."/f/{a}/update" => "fileController",
        "/git" => "gitPull"
        );
    Link::all($routes);
    // CRUD CONTROLLERS
    class indexController {
        function get(){
            // echo "GET";
            require("app/vars.php");
            include("src/header.php");
            listData();
            include("src/footer.php");
        }
        function post(){
            createData();
        }
    }
    class itemController {
        function get($a){
            require("app/vars.php");
            include("src/header.php");
            include("app/views/item.php");
            include("src/footer.php");
        }
    }
    // VIEWS CONTROLLERS
    function addController() {
        header("location: ".url().ran(4,4)."");
    }
    function allController($a) {
        header("Content-type: text/m3u");
        print "#EXTM3U"."\n";
        include("app/views/m3u.php");
        include("app/views/rss.php");
    }
    function createData(){
        $db = new Db("data/data.json");
        $data = array(
            "uid" => $_POST["uid"],
            "title" => $_POST["title"],
            "csvUrl" => $_POST["csvUrl"],
            "m3uUrl" => array_values(array_filter(explode(PHP_EOL, $_POST["m3uUrl"]))),
            "rssUrl" => array_values(array_filter(explode(PHP_EOL, $_POST["rssUrl"])))
            );
        $db->insert($data);
        header("location: ".url().$_POST["uid"]);
    }
    function readData($a){
        $db = new Db("data/data.json");
        $db->where("uid", $a);
        // $db->order_by("_id", "DESC");
        $data = $db->get();
        foreach($data as $data) {
            $uid    = $data["uid"];
            $title  = $data["title"];
            $csvUrl = $data["csvUrl"];
            $m3uUrl = $data["m3uUrl"];
            $rssUrl = $data["rssUrl"];
            return compact("uid","title","csvUrl","m3uUrl","rssUrl");
            }
    }
    function updateData($a){
        // print_r($_POST);
        $db = new Db("data/data.json");
        $data = array(
            "uid" => $_POST["uid"],
            "title" => $_POST["title"],
            "csvUrl" => $_POST["csvUrl"],
            "m3uUrl" => array_values(array_filter(explode(PHP_EOL, $_POST["m3uUrl"]))),
            "rssUrl" => array_values(array_filter(explode(PHP_EOL, $_POST["rssUrl"])))
            );
        $db->where("uid", $_POST["uid"]);
        $db->update($data);
        header("location: ".url().$_POST["uid"]);
    }
    function deleteData($a){
        $u = getURI();
        $db = new Db("data/data.json");
        $db->where("uid", $u["path"]);
        $db->delete();
        header("location: ".url());
    }
    function createExample(){
        $db = new Db("data/data.json");
        $uid = ran(4,4);
        $data = array(
            "uid" => $uid,
            "title" => ran(8,16),
            "csvUrl" => "https://docs.google.com/spreadsheets/d/e/2PACX-1vRCK3VaABs6SlEL-nBXtbvDPhMkgbKpHKENGK_-1kOtkpUT2KSznjlTgCbmT2lcur9LinZRM7c-wDp-/pub?gid=878215409&single=true&output=csv",
            "m3uUrl" => array (
                "https://pastebin.com/raw/0AxHuqZv",
                "https://pastebin.com/raw/jbqA0j82",
                "https://pastebin.com/raw/EFjBwC9e"
            ),
            "rssUrl" => array (
                "https://democracynow.org/podcast-video.xml",
                "https://podsync.net/1QPr",
                "https://siftrss.com/f/d08JgNM5V3",
                "https://siftrss.com/f/LbQX1zVA6z0",
                "https://podsync.net/WQ2O",
                "https://podsync.net/hH351ceab"
                ),
            );
        $db->insert($data);
        header("location: ".url().$uid);
    }
    function csvController($a) {
        include("app/views/csv.php");
    }
    function epgController($a) {
        $epg = true;
        header("Content-type: text/xml");
        include("app/views/rss.php");
    }
    function m3uController($a) {
        header("Content-type: text/m3u");
        print "#EXTM3U"."\n";
        include("app/views/m3u.php");
    }
    function rssController($a) {
        $epg = false;
        header("Content-type: text/m3u");
        print "#EXTM3U"."\n";
        include("app/views/rss.php");
    }
    // GENERAL FUNCTIONS
    function ran($x,$y){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        return substr(str_shuffle($chars),0,rand($x,$y));
        }
    function line($x){
        return implode( "\n", $x );
    }
    function getAuth(){
        $f = file_get_contents("data/settings.json");
        $j = json_decode($f, true);
        $l = $j["login"];
        $p = $j["pass"];
        return $l.":".$p;
    }
    function getURI(){
        $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://";
        $server = $_SERVER["HTTP_HOST"];
        $hostname = $protocol.$server;
        $uri = $_SERVER['REQUEST_URI'];
        $url = $protocol.$server.$uri;
        $parseURL= parse_url($url, PHP_URL_PATH);
        $uriPath = explode("/", trim($parseURL, "/"));
        $path = $uriPath["0"];
        return compact("protocol","server","hostname","path");
    }
    function url(){
        $u = getURI();
        $itemURL = $u["protocol"].getAuth()."@".$u["server"]."/";//.$v["uid"]."/";
        return $itemURL;
    }
    function listData(){
        echo "<div class=\"table-responsive\">
            <table id=\"list\" class=\"table table-sm table-hover table-fixed\" cellspacing=\"0\" width=\"100%\">
            <thead>
                <tr>
                <th style=\"width:6rem;\">UID</th>
                <th class=\"th-sm\">TITLE</th>
                <th class=\"th-sm\">CSV URL</th>
                <th class=\"th-sm\">M3U URLs</th>
                <th class=\"th-sm\">RSS URLs</th>
                </tr>
            </thead>
            <tbody>"."\n";
        $db = new Db("data/data.json");
        $v = $db->get();
        $u = getURI();
        foreach($v as $v) {
        $itemURL = $u["protocol"].getAuth()."@".$u["server"]."/".$v["uid"];
        echo "\t\t\t".
            "<tr>".
            "<td onclick=\"location.href='".$v["uid"]."'\" style=\"cursor:pointer;\">".$v["uid"]."</a></td>".
            "<td onclick=\"location.href='".$v["uid"]."'\" style=\"cursor:pointer;\">".$v["title"]."</a></td>".
            "<td onclick=\"location.href='".$v["uid"]."'\" style=\"cursor:pointer;\">".$v["csvUrl"]."</a></td>".
            "<td onclick=\"location.href='".$v["uid"]."'\" style=\"cursor:pointer;\">".line($v["m3uUrl"])."</a></td>".
            "<td onclick=\"location.href='".$v["uid"]."'\" style=\"cursor:pointer;\">".line($v["rssUrl"])."</a></td>".
            "</tr>\n";
        // echo "\t\t\t".
        //     "<tr><td colspan=\"5\" class=\"off\" style=\"border: none !important;\">".
        //     "<ul class=\"nav nav-justified\">".
        //     "<li class=\"nav-item\"><a href=\"".$itemURL."/csv\" target=\"_blank\"><button type=\"button\" class=\"btn btn-sm white z-depth-0 waves-effect\">CSV</button></a></li>".
        //     "<li class=\"nav-item\"><a href=\"".$itemURL."/m3u\" target=\"_blank\"><button type=\"button\" class=\"btn btn-sm white z-depth-0 waves-effect\">M3U</button></a></li>".
        //     "<li class=\"nav-item\"><a href=\"".$itemURL."/rss\" target=\"_blank\"><button type=\"button\" class=\"btn btn-sm white z-depth-0 waves-effect\">RSS</button></a></li>".
        //     "<li class=\"nav-item\"><a href=\"".$itemURL."/rss/epg\" target=\"_blank\"><button type=\"button\" class=\"btn btn-sm white z-depth-0 waves-effect\">EPG</button></a></li>".
        //     "<li class=\"nav-item\"><a href=\"".$itemURL."/all\" target=\"_blank\"><button type=\"button\" class=\"btn btn-sm white z-depth-0 waves-effect\">ALL</button></a></li>".
        //     "</ul>".
        //     "</td></tr>\n";
        // }
        echo "\t\t\t".
            "<tr class=\"off\"><td colspan=\"5\" class=\"off\" style=\"border: none !important;\">".
            "<li class=\"url\"><a href=\"".$itemURL."/csv\" target=\"_blank\"><i class=\"fas fa-file-download\"></i> Download CSV:</a> ".
            "<input type=\"text\" class=\"form-control\" value=\"".$itemURL."/csv\"/></li>".
            "<li class=\"url\"><a href=\"".$itemURL."/m3u\" target=\"_blank\"><i class=\"fas fa-file-medical-alt\"></i> M3U url:</a> ".
            "<input type=\"text\" class=\"form-control\" value=\"".$itemURL."/m3u\"/></li>".
            "<li class=\"url\"><a href=\"".$itemURL."/rss\" target=\"_blank\"><i class=\"fas fa-rss\"></i> RSS M3U url:</a> ".
            "<input type=\"text\" class=\"form-control\" value=\"".$itemURL."/rss\"/></li>".
            "<li class=\"url\"><a href=\"".$itemURL."/rss/epg\" target=\"_blank\"><i class=\"far fa-file-code\"></i> RSS EPG url:</a> ".
            "<input type=\"text\" class=\"form-control\" value=\"".$itemURL."/epg\"/></li>".
            "<li class=\"url\"><a href=\"".$itemURL."/all\" target=\"_blank\"><i class=\"far fa-copy\"></i> M3U with RSS:</a> ".
            "<input type=\"text\" class=\"form-control\" value=\"".$itemURL."/all\"/></li>".
            "</td></tr>\n";
        }
        echo "</tbody>
            </table>
            </div>
            </section>";
    }
    function gitPull(){
        // if (!is_dir(".git")) { }
        $gitURL  = "https://github.com/spencerthayer/ezIPTV";
        $outputDir = rmdir(".git");
        $outputInit = shell_exec("git init");
        $outputAdd = shell_exec("git remote add origin ".$gitURL.";");
        $outputPull = shell_exec("git fetch --all;git reset --hard origin/master;");
        echo "<p><pre>$outputDir</pre></p>";
        echo "<p><pre>$outputInit</pre></p>";
        echo "<p><pre>$outputAdd</pre></p>";
        echo "<p><pre>$outputPull</pre></p>";
        // header("location: /");
    }
?>