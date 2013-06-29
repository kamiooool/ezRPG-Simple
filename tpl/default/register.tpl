{include file="header.tpl" TITLE="Register"}

<h1>Register</h1>

<p>
Want to join the fun? Fill out the form below to register!
</p>

<form data-module="Register">

<label>Username</label>
<input type="text" size="40" name="username" />

<label>Password</label>
<input type="password" size="40" name="password" />

<label>Verify Password</label>
<input type="password" size="40" name="password2" />

<label>Email</label>
<input type="text" size="40" name="email" />

<label>Verify Email</label>
<input type="text" size="40" name="email2" />

<br />
<input name="register" type="submit" value="Register!" class="button" />
</form>

{include file="footer.tpl"}