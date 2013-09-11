{include file="header.tpl" TITLE="Stat Points"}

<h1>Stat Points</h1>

<p>
Here you can use your stat points to increase your stats! You have <strong>{$player->stat_points}</strong> points to use!
<br /><br />
You receive stat points when you first sign up to the game, and also each time when you level up!
</p>

<form data-module="StatPoints" id="stat_str">
<input type="submit" class="button" value="Strength" />
</form>

<p>
<strong>Strength</strong> - This increases the damage you do in battle, and increases your weight limit so you can carry more items.
</p>

<form data-module="StatPoints" id="stat_vit">
<input type="submit" class="button" value="Vitality" />
</form>

<p>
<strong>Vitality</strong> - This increases the amount of health you have and decreases the amount of damage you receive in battle.
</p>

<form data-module="StatPoints" id="stat_agi">
<input type="submit" class="button" value="Agility" />
</form>

<p>
<strong>Agility</strong> - This increases your chance to completely dodge and attack and take no damage in battle!
</p>

<form data-module="StatPoints" id="stat_dex">
<input type="submit" class="button" value="Dexterity" />
</form>

<p>
<strong>Dexterity</strong> - This helps you aim better so you are less likely to miss your opponent.
</p>

{include file="footer.tpl"}