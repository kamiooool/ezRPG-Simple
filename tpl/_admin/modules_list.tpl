{include file="../_admin/header.tpl" TITLE="Modules List"}

<h1>Modules List</h1>

<table class="pure-table pure-table-horizontal" width="100%">
    <thead>
        <tr class="shaded_bg">
            <th width="30%">Module Name</th>
            <th width="70%">Description</th>
        </tr>
    </thead>

    <tbody>
		{if isset($MODULES_INFO)}
			{foreach from=$MODULES_INFO key=MODULE_NAME item=HEADER}
				<tr>
					{foreach from=$HEADER key=k item=v}
						{if $k == 'Name' && $v}
							<td class="module_name">{$v} {if $HEADER['Version']}<span class="module_meta_version"><sup>{$HEADER['Version']}</sup></span>{/if}</td>
							<td class="module_meta">
						{else if $k == 'Name' && !$v}
							<td class="module_name module_error">{$MODULE_NAME}</td>
							<td class="module_meta module_meta_error">
						{/if}
						{if $k == 'Description' && $v}
							<div class="module_meta_description">{$v}</div>
						{else if $k == 'Description' && !$v}
							<div class="module_meta_description module_meta_error">Warning! This module has no description, and <b>probably</b> is incompatible with this version/package!</div>
						{/if}
						
						{if $k == 'Author' && $v}
							<span class="module_meta_author">Author: {$v}</span>
						{/if}
						
						{if $k == 'AuthorURI' && $v}
							<span class="module_meta_author_uri">Author URI: <a href="{$v}">{$v}</a></span>
						{/if}
						
						{if $k == 'ModuleURI' && $v}
							<span class="module_meta_module_uri">Module URI: <a href="{$v}">{$v}</a></span>
						{/if}
						
						{if $k == 'Package' && $v}
							{if strpos($v, $PACKAGE) !== false}
								<span class="module_meta_package">Supports: <b>{$PACKAGE}</b></span>
							{/if}
						{/if}
					{/foreach}
					</td>
				</tr>
			{/foreach}
		{/IF}
    </tbody>
</table>

{include file="../_admin/footer.tpl"}