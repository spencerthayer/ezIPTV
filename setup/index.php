<?php
    // FUNCTIONS
    function createData() {
        $dirPAth = realpath(__DIR__ ."/..")."/";
        $dataFolder = $dirPAth."data";
        if (!is_dir($dataFolder)) {
            mkdir($dataFolder, 0754);
            chmod($dataFolder, 0754);
            $dataFile =fopen($dirPAth."data/data.json", "w") or die("Can't create file!");
            fclose($dataFile);
            echo "<p><strong>"."Data files and directory structure created."."</strong></p>";
        }
    }
    function htaccess() {
        $dirPAth = realpath(__DIR__ ."/..")."/";
        $url  = isset($_SERVER["HTTPS"])?"https://":"http://";
        $url .= $_SERVER["SERVER_NAME"];
        $url .= $_SERVER["REQUEST_URI"];
        $url  = dirname($url);
        if (!file_exists($dirPAth.".htaccess")) :
        $content = "#
        #Prevent viewing of .htaccess file
        <Files .htaccess>
            order allow,deny
            deny from all
        </Files>
        #Prevent viewing of .htpasswd file
        <Files .htpasswd>
            order allow,deny
            deny from all
        </Files>
        #Prevent viewing of .json files
        <Files ~ \"\.json\">
            order allow,deny
            deny from all
        </Files>
        #Prevent directory listings
        Options All -Indexes
        #RewriteEngine
        Options +FollowSymLinks
        RewriteEngine On
        RewriteCond %{HTTPS} off
        RewriteCond %{SERVER_PORT} 443
        #RewriteRule ^/?$ http://%{SERVER_NAME}/ [R=301,L]
        RewriteRule ^/?$ ".$url." [R=301,L]
        ## REWRITE BROKEN LINKS ##
        RewriteCond %{SERVER_PORT} 80
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_URI} !^/index\.php
        # RewriteRule ^(.*)$ index.php/$1 [L]
        RewriteCond %{REQUEST_URI} (/[^.]*|\.(php))$ [NC]
        RewriteRule .* index.php [L]
        ## REMOVE .PHP EXTENSION ##
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME}\.php -f
        RewriteRule ^(.*)$ $1.php
        # REWRITE SPACES AND +
        RewriteRule ^([^\ ]*)\ (.*)$ $1-$2 [E=rspace:yes,N]
        RewriteCond %{ENV:rspace} yes
        # RewriteRule (.*) http://%{HTTP_HOST}$1 [R=301,L]
        RewriteRule (.*)".$url."$1 [R=301,L]
        #AUTHENTICATION
        AuthType Basic
        AuthName \"Password Protected Area\"
        AuthUserFile ".$dirPAth.".htpasswd
        Require valid-user
        #PAGES
        ErrorDocument 404 /404.php
        #";
        file_put_contents($dirPAth.".htaccess", $content);
        echo "<p><strong>"."URL routing and site permissions successfully installed."."</strong></p>";
        endif;
    }
    function htpasswd() {
        $dirPAth = realpath(__DIR__ ."/..")."/";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!$*()_-";
        $login = substr(str_shuffle($chars),0,rand(3,5));
        $pass = substr(str_shuffle($chars),0,rand(3,5));
        $hash = base64_encode(sha1($pass, true));
        $auth = $login.":{SHA}".$hash;
        $url  = isset($_SERVER["HTTPS"])?"https://":"http://";
        $url .= $login.":".$pass."@";
        $url .= $_SERVER["SERVER_NAME"];
        $url .= $_SERVER["REQUEST_URI"];
        $urlUp  = dirname($url);
        file_put_contents($dirPAth.".htpasswd", $auth);
        echo "<p>".
        "The authentication URL combination is ".
        "<code>".$login.":".$pass."</code>, and the URL is:".
        "<br/>".
        "<a href=\"".$urlUp."\">".$urlUp."</a>.".
        "</p>".
        "<p>".
        "Alternatively the authentication information is ".
        "<strong>Login:</strong> <code>".$login."</code> and ".
        "<strong>Password:</strong> <code>".$pass."</code>.".
        "</p>".
        "<p>".
        "<strong>".
        "Be sure to save this authentication! ".
        "There is no way to retrieve lost authentication information.".
        "</strong>".
        "</p>";
        echo "<p>".
        "<strong><a href=\"".$url."\">CLICK HERE</a></strong> ".
        "to reset authentication.".
        "</p>";
        echo "<p>".
        "<strong><a href=\"".$urlUp."/example\">CLICK HERE</a></strong> ".
        "to create an example URL.".
        "</p>";
        $jsonSettings = json_encode(array ("login"=>$login,"pass"=>$pass));
        file_put_contents($dirPAth."data/settings.json", $jsonSettings);
    }
    // ACTIONS
    require("../app/vars.php");
    require("../src/header.php");
    echo "<section class=\"my-5\"><div class=\"container p-5\">";
    createData();
    htaccess();
    htpasswd();
    echo "</div></section>";
    require("../src/footer.php");