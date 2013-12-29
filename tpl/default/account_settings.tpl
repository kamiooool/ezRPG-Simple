{include file="header.tpl" TITLE="##EZ_GLOBAL_ACCOUNT_SETTINGS##"}

<h1>##EZ_GLOBAL_ACCOUNT_SETTINGS##</h1>

<p>##EZ_GLOBAL_ACCOUNT_PAGE_MSG##</p>

<form data-module="AccountSettings">

<label>##EZ_GLOBAL_CURRENT_PASSWORD##</label>
<input type="password" size="40" name="current_password" autocomplete="off" />

<label>##EZ_GLOBAL_NEW_PASSWORD##</label>
<input type="password" size="40" name="new_password" autocomplete="off" />

<label>##EZ_GLOBAL_VERIFY_NEW_PASSWORD##</label>
<input type="password" size="40" name="new_password2" autocomplete="off" />

<br />
<input name="change_password" type="submit" value="##EZ_GLOBAL_CHANGE_PASSWORD##" class="button" />

</form>

{include file="footer.tpl"}