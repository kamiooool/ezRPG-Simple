{include file="../_admin/header.tpl" TITLE="Members Delete"}

<h1>Player delete: {$member->username}</h1>

<p>
You sure you want to delete <strong>{$member->username}</strong>?
</p>

<form data-module="Members">
<input type="hidden" name="id" value="{$member->id}" />
<input type="hidden" name="act" value="delete" />
<input type="submit" name="confirm" value="Delete" />

</form>

{include file="../_admin/footer.tpl"}