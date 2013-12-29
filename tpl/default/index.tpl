{include file="header.tpl" TITLE="##EZ_GLOBAL_WELCOME##"}

<h1>##EZ_GLOBAL_WELCOME##</h1>

<p>##EZ_GLOBAL_WELCOME_MSG##</p>

<form data-module="Login">
<label>##EZ_GLOBAL_USERNAME##</label>
<input type="text" name="username" />

<label>##EZ_GLOBAL_PASSWORD##</label>
<input type="password" name="password" />

<br />
<input name="login" type="submit" class="button" value="##EZ_GLOBAL_LOGIN##">
</form>

{include file="footer.tpl"}