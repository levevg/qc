{if $paging}
<div class="paging">
<b>Страницы:</b>
{if $first_page}<a href="{_}&pg={$first_page}{$paging_params}" title="Первая">&lt;&lt;</a>{/if}
{if $prev_page}<a href="{_}&pg={$prev_page}{$paging_params}" title="Предыдущая">&lt;</a>{/if}
{strip}
{foreach $pages as $page}
<a href="{_}&pg={$page.page}{$paging_params}"{if $page.current} class="act"{/if}>{$page.page}</a>
{/foreach}
{/strip}
{if $next_page}<a href="{_}&pg={$next_page}{$paging_params}" title="Следующая">&gt;</a>{/if}
{if $last_page}<a href="{_}&pg={$last_page}{$paging_params}" title="Последняя">&gt;&gt;</a>{/if}
</div>

{/if}