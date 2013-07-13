{if $LOGGED_IN == 'TRUE'}
<div id="sidebar">
<strong>Level</strong>: {$player->level}<br />
<strong>Gold</strong>: {$player->money}<br /><br />

<div class="bar">
	HP:
	<div class="bar_wrap">
		<div id="hp" data-current="{$player->hp}" data-max="{$player->max_hp}"></div>
	</div>
</div>

<div class="bar">
	EXP:
	<div class="bar_wrap">
		<div id="exp" data-current="{$player->exp}" data-max="{$player->max_exp}"></div>
	</div>
</div>

<div class="bar">
	ENERGY:
	<div class="bar_wrap">
		<div id="nrg" data-current="{$player->energy}" data-max="{$player->max_energy}"></div>
	</div>
</div>

{if $new_logs > 0}
<a href="index.php?mod=EventLog" class="red"><strong>{$new_logs} New Log Events!</strong></a>
{/if}
</div>
{/if}