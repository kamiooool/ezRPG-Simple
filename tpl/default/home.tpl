{include file="header.tpl" TITLE="##EZ_GLOBAL_HOME##"}

<h1>##EZ_GLOBAL_HOME##</h1>

<div class="left">
<p>
<strong>##EZ_GLOBAL_USERNAME##</strong>: {$player->username}<br />
<strong>##EZ_GLOBAL_EMAIL##</strong>: {$player->email}<br />
<strong>##EZ_GLOBAL_REGISTERED##</strong>: {$player->registered|date_format:'%B %e, %Y %l:%M %p'}<br />
<strong>##EZ_GLOBAL_KILLSDEATHS##</strong>: {$player->kills}/{$player->deaths}<br />
<br />
{if $player->stat_points > 0}
##EZ_GLOBAL_STATPOINTS_LEFT##<br />
<a href="index.php?mod=StatPoints"><strong>##EZ_GLOBAL_STATPOINTS_SPENDNOW##</strong></a>
{else}
##EZ_GLOBAL_NO_STATPOINTS##
{/if}
</p>
</div>


<div class="right">
<p>
<strong>##EZ_GLOBAL_LEVEL##</strong>: {$player->level}<br />
<strong>##EZ_GLOBAL_GOLD##</strong>: {$player->money}<br />
<br />
<strong>##EZ_GLOBAL_STRENGTH##</strong>: {$player->strength}<br />
<strong>##EZ_GLOBAL_VITALITY##</strong>: {$player->vitality}<br />
<strong>##EZ_GLOBAL_AGILITY##</strong>: {$player->agility}<br />
<strong>##EZ_GLOBAL_DEXTERITY##</strong>: {$player->dexterity}<br />
</p>
</div>

{include file="footer.tpl"}