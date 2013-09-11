<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="Description" content="ezRPG Project, the free, open source browser-based game engine!" />
	<meta name="Keywords" content="ezrpg, game, game engine, pbbg, browser game, browser games, rpg, ezrpg project" />
	<link rel="stylesheet" href="tpl/default/assets/css/style.css" type="text/css" />	
	<title>ezRPG :: {$TITLE|default:""}</title>
	
	{foreach from=$INIT_JS_LIBS item=item}{$item}{/foreach}
	
</head>

<body>
<div id="wrapper">

<header id="header" role="banner">
	<span id="title">ezRPG</span>
	<span id="time"><strong>Players Online</strong>: {$ONLINE}</span>
</header>

<ul id="nav">
	{if $LOGGED_IN == 'TRUE'}
		<li><a href="index.php">Home</a></li>
		<li><a href="index.php?mod=Members">Members</a></li>
		<li><a href="index.php?mod=AccountSettings">Account</a></li>
	{if $player->rank >= 5}
		<li><a href="admin/index.php">Admin</a></li>
	{/if}
		<li><a href="index.php?mod=Logout">Log Out</a></li>
	{else}
		<li><a href="index.php">Home</a></li>
		<li><a href="index.php?mod=Register">Register</a></li>
	{/if}
</ul>
<br /><br />

{include file="sidebar_left.tpl"}

<div id="{if $LOGGED_IN == 'TRUE'}gamebody{else}body{/if}">

<div id="messages"></div>
