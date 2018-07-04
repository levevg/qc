{foreach $result as $rec}
<div class="news_item">

    <span class="fr" style="color:#666">{$rec.day} {$rec.month} {$rec.year}</span>
    
    {if $rec.more}

	    <h1><a href="/news-{$rec.id}.html">{$rec.title}</a></h1>
	
	    {$rec.intro}
    
        <br/><a style="line-height:25px" href="/news-{$rec.id}.html">Продолжение...</a>
    
    {else}
    
	    <h1>{$rec.title}</h1>
	    
	    {$rec.intro}
    
    {/if}
</div>
<div class="cl mb30"></div>
{/foreach}