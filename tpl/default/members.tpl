{include file="header.tpl" TITLE="##EZ_GLOBAL_MEMBERS##"}

<table width="90%">
  <tr>
    <th style="text-align: left;">##EZ_GLOBAL_USERNAME##</th>
    <th style="text-align: left;">##EZ_GLOBAL_LEVEL##</th>
  </tr>

{foreach from=$members item=member}
  <tr>
    <td>{$member->username}</td>
    <td>{$member->level}</td>
  </tr>
{/foreach}
</table>

<span class="space"></span>

<span style="display: block; width: 90%; text-align: center;">
<strong>
<a href="index.php?mod=Members&page={$prevpage}">##EZ_GLOBAL_PREVPAGE##</a> | <a href="index.php?mod=Members&page={$nextpage}">##EZ_GLOBAL_NEXTPAGE##<</a>
</strong>
</span>

{include file="footer.tpl"}