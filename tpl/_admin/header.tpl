<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../tpl/default/assets/css/style.css" type="text/css" />	
	<title>ezRPG Settings:: {$TITLE|default:""}</title>
	
	{foreach from=$INIT_JS_LIBS item=item}{$item}{/foreach}
	
</head>

<body>
<div id="wrapper">

<header id="header" role="banner">
	<span id="title">ezRPG</span>
</header>

<ul id="nav">
	<li><a href="index.php">Admin</a></li>
	<li><a href="index.php?mod=Members">Members</a></li>
	<li><a href="../index.php">Back</a></li>
	<li><a href="../index.php?mod=Logout">Log Out</a></li>
</ul>

{include file="../_admin/sidebar_admin.tpl"}

<div id="admin_body">
<div id="messages"></div>
