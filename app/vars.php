<?php

  $root = dirname(dirname(__FILE__));
  $upDir = dirname(__DIR__, 1);

  $name = "ezIPTV";
  $ver = "v0.5";

  $url  = isset($_SERVER["HTTPS"])?"https://":"http://";
  $url .= $_SERVER["SERVER_NAME"];
  $url .= $_SERVER["REQUEST_URI"];
  $urlUp  = dirname($url);

  // $pathRoot = "ezIPTV";
  $pathRoot = "";