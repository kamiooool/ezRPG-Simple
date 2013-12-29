{include file="header.tpl" TITLE="##EZ_GLOBAL_REGISTER##"}

<h1>##EZ_GLOBAL_REGISTER##</h1>

<p>##EZ_GLOBAL_REGISTER_MSG##</p>

<form data-module="Register">

<label>##EZ_GLOBAL_USERNAME##</label>
<input type="text" size="40" name="username" />

<label>##EZ_GLOBAL_PASSWORD##</label>
<input type="password" size="40" name="password" />

<label>##EZ_GLOBAL_PASSWORD_VERIFY##</label>
<input type="password" size="40" name="password2" />

<label>##EZ_GLOBAL_EMAIL##</label>
<input type="text" size="40" name="email" />

<label>##EZ_GLOBAL_EMAIL_VERIFY##</label>
<input type="text" size="40" name="email2" />

<br />
<input name="register" type="submit" value="##EZ_GLOBAL_REGISTER##!" class="button" />
</form>

{include file="footer.tpl"}