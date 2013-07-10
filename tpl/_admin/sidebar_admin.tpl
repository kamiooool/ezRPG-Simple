<div id="sidebar">

<div class="pure-menu pure-menu-open">
    <a class="pure-menu-heading shaded_bg">ezRPG Settings</a>
    <ul>
        <li><a href="#">Empty for now</a></li>
    </ul>
</div>

{if isset($ADMIN_MODULES)}
<div class="pure-menu pure-menu-open">
    <a class="pure-menu-heading shaded_bg">Modules with settings</a>
    <ul>
		{foreach from=$ADMIN_MODULES item=item}
			<li><a href="index.php?mod={$item}">{$item}</a></li>
		{/foreach}
    </ul>
</div>
{/IF}

{if isset($PUBLIC_MODULES)}
<div class="pure-menu pure-menu-open">
    <a class="pure-menu-heading shaded_bg">All installed modules</a>
    <ul id="all_modules">
		{foreach from=$PUBLIC_MODULES item=item}
			<li>{$item}</li>
		{/foreach}
    </ul>
</div>
{/IF}

</div>
