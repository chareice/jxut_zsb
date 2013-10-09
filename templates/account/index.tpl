{include file='header.tpl'}
{if $authenticated}
 不是<a href="/account/logout">{$identity->user_type}?</a>
{/if}
{include file='footer.tpl'}
