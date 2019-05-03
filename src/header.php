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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.7/css/mdb.min.css" rel="stylesheet">
    <?/* FONT */?>
        <!-- <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700|Montserrat:400,700&amp;subset=latin-ext" rel="stylesheet"> -->
  <style>
    td {
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      cursor: pointer !important;
      }
    td.off {
      overflow: none !important;
      text-overflow: none !important;
      cursor: auto !important;
      }
    .md-form {
      margin-top: 1rem !important;
      margin-bottom: 4rem !important;
    }
    li.url {
      display: inline-block;
      list-style: none;
      margin-right: 2rem;
      margin-bottom: .35rem;
    }
    li.url a {
      display: inline-block;
      width: 7rem !important;
      color: #007bff;
    }
    li.url input {
      display: inline !important;
      width: 24rem !important;
      /* height: calc(1.5em + .75rem + 2px); */
      height: 1.25rem !important;
      padding: .1rem .25rem !important;
      border: none !important;
      color: #999;
    }
    li.url input:focus {
      border: none !important;
    }
    tr.off:hover {
      background: none !important;
    }
    .uploadForm span {
      /* position: absolute;
      top: .65rem;
      left: 0;
      -webkit-transition: .2s ease-out;
      -o-transition: .2s ease-out;
      transition: .2s ease-out;
      cursor: text; */
      color: #757575 !important;
      font-size: 12.8px !important;
      font-weight: 300 !important;
    }
    .uploadForm input {
      border: none !important;
    }
  </style>
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
          <a class="nav-link" href="/">List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/add">Create New URL</a>
        </li>
      </ul>
      <ul class="navbar-nav nav-flex-icons">
        <li class="nav-item">
          <a class="nav-link" href="/setup">Reset Pass</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/git">Update</a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!--Main Navigation-->
<div style="margin: 6rem 1rem 4rem 1rem">
<pre>test</pre>