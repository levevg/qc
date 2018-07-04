<?php

function smarty_block_block1($params, $content, $template, &$repeat){
	return '<div class="block"><div style="width:171px;padding-bottom:12px">
                '.$content.'
            </div></div><div class="block_bot"></div>';
}