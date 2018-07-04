{if $paging}
<div class="paging">
<b>Страницы:</b>
{if $first_page}<a href="?pg={$first_page}{$paging_params}" title="Первая" style="letter-spacing:-4px">&lt;&lt;&nbsp;</a>{/if}
{if $prev_page}<a href="?pg={$prev_page}{$paging_params}" title="Предыдущая">&lt;</a>{/if}
{strip}
{foreach $pages as $page}
<a href="?pg={$page.page}{$paging_params}"{if $page.current} class="act"{/if}>{$page.page}</a>
{/foreach}
{/strip}
{if $next_page}<a href="?pg={$next_page}{$paging_params}" title="Следующая">&gt;</a>{/if}
{if $last_page}<a href="?pg={$last_page}{$paging_params}" title="Последняя" style="letter-spacing:-4px">&gt;&gt;&nbsp;</a>{/if}
</div>
{/if}