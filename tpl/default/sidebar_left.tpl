{if $LOGGED_IN == 'TRUE'}
<div id="sidebar">
<strong>Level</strong>: {$player->level}<br />
<strong>Gold</strong>: {$player->money}<br />

<img src="bar.php?width=140&type=exp" alt="EXP: {$player->exp} / {$player->max_exp}" /><br />
<img src="bar.php?width=140&type=hp" alt="HP: {$player->hp} / {$player->max_hp}" /><br />
<img src="bar.php?width=140&type=energy" alt="Energy: {$player->energy} / {$player->max_energy}" /><br />

{if $new_logs > 0}
<a href="index.php?mod=EventLog" class="red"><strong>{$new_logs} New Log Events!</strong></a>
{/if}
</div>
{/if}