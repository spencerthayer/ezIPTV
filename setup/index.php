<?php
    $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://";
    $server = $_SERVER["HTTP_HOST"];
    $hostname = $protocol.$server;
    // FUNCTIONS
    function createData() {
        $dataFolder = dirname(__DIR__, 1)."/data";
        if (!is_dir($dataFolder)) {
            mkdir($dataFolder, 0754);
            chmod($dataFolder, 0754);
            echo "<p>"."Data file structure created."."</p>";
        }
    }
    function htaccess($x) {
        if (!file_exists("../.htaccess")) :
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
        RewriteRule ^/?$ ".$x." [R=301,L]
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
        RewriteRule (.*)".$x."$1 [R=301,L]
        #AUTHENTICATION
        AuthType Basic
        AuthName \"Password Protected Area\"
        AuthUserFile ".dirname(__DIR__, 1)."/.htpasswd
        Require valid-user
        #PAGES
        ErrorDocument 404 /404.php
        #";
        file_put_contents("../.htaccess", $content);
        echo "<p>"."URL routing and site permissions successfully installed."."</p>";
        endif;
    }
    function htpasswd($y,$z) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!$*()_-";
        $login = substr(str_shuffle($chars),0,rand(2,6));
        $pass = substr(str_shuffle($chars),0,rand(4,8));
        $hash = base64_encode(sha1($pass, true));
        $auth = $login.":{SHA}".$hash;
        $url = $y.$login.":".$pass."@".$z;
        file_put_contents("../.htpasswd", $auth);
        echo "<p>".
        "Your URL authentication combination is ".
        "<strong>".$login.":".$pass."</strong>, and your URL is:<br/>".
        "<a href=\"".$url."\">".$url."</a>.<br/>".
        "<strong>Be sure to save this authentication information!</strong>".
        "</p>";
        echo "<p>".
        "<strong><a href=\"".$url."/setup/\">CLICK HERE</a></strong> ".
        "to reset authentication.".
        "</p>";
        $jsonSettings = json_encode(array ("login"=>$login,"pass"=>$pass));
        file_put_contents("../data/settings.json", $jsonSettings);
    }
    // ACTIONS
    createData();
    htaccess($hostname);
    htpasswd($protocol,$server);