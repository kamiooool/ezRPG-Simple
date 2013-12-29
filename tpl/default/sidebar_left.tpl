{if $LOGGED_IN == 'TRUE'}
<div id="sidebar">
<strong>##EZ_GLOBAL_LEVEL##</strong>: {$player->level}<br />
<strong>##EZ_GLOBAL_GOLD##</strong>: {$player->money}<br /><br />

<div class="bar">
	##EZ_GLOBAL_HP##:
	<div class="bar_wrap">
		<div id="hp" data-current="{$player->hp}" data-max="{$player->max_hp}"></div>
	</div>
</div>

<div class="bar">
	##EZ_GLOBAL_EXP##:
	<div class="bar_wrap">
		<div id="exp" data-current="{$player->exp}" data-max="{$player->max_exp}"></div>
	</div>
</div>

<div class="bar">
	##EZ_GLOBAL_ENERGY##:
	<div class="bar_wrap">
		<div id="nrg" data-current="{$player->energy}" data-max="{$player->max_energy}"></div>
	</div>
</div>

{if $new_logs > 0}
<a href="index.php?mod=EventLog" class="red"><strong>{$new_logs} ##EZ_GLOBAL_NEW_LOGS_MSG##</strong></a>
{/if}
</div>
{/if}