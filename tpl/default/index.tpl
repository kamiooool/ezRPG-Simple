{include file="header.tpl" TITLE="Home"}

<h1>Home</h1>

<p>
Welcome to ezRPG "Simple". You are viewing default theme, which was created specially for you to understand the basics of this PHP engine. For now, you can use the login form to enter the game or admin panel, or register as a new player.
</p>

<form data-module="Login">
<label>Username</label>
<input type="text" name="username" />

<label>Password</label>
<input type="password" name="password" />

<br />
<input name="login" type="submit" class="button" value="Login!">
</form>

{include file="footer.tpl"}