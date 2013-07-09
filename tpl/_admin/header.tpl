<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../tpl/_admin/assets/css/style.css" type="text/css" />	
	<title>ezRPG Settings:: {$TITLE|default:""}</title>
	
	{foreach from=$INIT_JS_LIBS item=item}{$item}{/foreach}
	
</head>

<body>
<div id="content">
<div id="wrapper">

<div id="admin_hello">
	<b class="pure-button pure-button-secondary">Welcome, {$player->username}!</b>
	<a href="../index.php" class="pure-button pure-button-warning">Back to Game View »</a>
</div>

<div id="padder">

<header id="header" role="banner">
	<div id="title">ezRPG</div>
</header>

{include file="../_admin/sidebar_admin.tpl"}

<div id="admin_body">
<div id="messages"></div>
