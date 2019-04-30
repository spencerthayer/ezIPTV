<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <?/* META */?>
        <meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta charset="utf-8"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <title><?=$name;?> <?=$ver;?></title>
    <?/* SOCIAL SHARE */?>
        <meta property="og:site_name"content="<?=$siteName;?>" />
        <meta property="og:image" content="$URLpath;img/" />
        <meta property="og:url" content="$URLpath;" />
    <?/* MOBILE SETTINGS */?>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon.png"/>
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon.png"/>
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon.png"/>
        <link rel="apple-touch-icon" href="/favicon.png"/>
        <link rel="shortcut icon" href="/favicon.png"/>
    <?/* CSS */?>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/css/mdb.min.css" rel="stylesheet">
    <?/* FONT */?>
        <!-- <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700|Montserrat:400,700&amp;subset=latin-ext" rel="stylesheet"> -->
  <!-- <style>
    td a {
      width: 100%;
      height: 100%;
      display: block;
    }
  </style> -->
</head>
<body>
<!--Main Navigation-->
<header>

  <nav class="navbar fixed-top navbar-expand-lg navbar-dark aqua-gradient scrolling-navbar">
    <a class="navbar-brand" href="javascript:void();"><strong><?=$name;?></strong> <small><?=$ver;?></small></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?=$url;?>">List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$url;?>add">Create New URL</a>
        </li>
      </ul>
      <!-- <ul class="navbar-nav nav-flex-icons">
        <li class="nav-item">
          <a class="nav-link" href="/setup">Setup</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/upgrade">Upgrade</a>
        </li>
      </ul> -->
    </div>
  </nav>

</header>
<!--Main Navigation-->


<main class="my-5">
<div class="container-fluid">