{include file="../_admin/header.tpl" TITLE="Members Admin"}

<h1>Edit Member</h1>

<form data-module="Members">

<p><label>Login</label><br />
<input type="text" disabled="disabled" value="{$member->username}" /></p>

<p><label>Email</label><br />
<input type="text" name="email" value="{$member->email}" /></p>

<p><label>Rank</label><br />
<input type="text" name="rank" value="{$member->rank}" /></p>

<p><label>Money</label><br />
<input type="text" name="money" value="{$member->money}" /></p>

<p><label>Statpoints to spend</label><br />
<input type="text" name="stat_points" value="{$member->stat_points}" /></p>

<input type="hidden" name="id" value="{$member->id}" />
<input type="hidden" name="act" value="edit" />
<p>
If the player has rank 5 or higher, the player will be able to access the admin panel.
</p>

<br />
<input class="button" type="submit" value="Edit" name="edit" />

</form>

{include file="../_admin/footer.tpl"}