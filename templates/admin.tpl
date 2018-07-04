<!DOCTYPE html>
<html>
<head>
    <title>{global var=page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
    <link href="/combine.php?files=admin.css,js%2Ffancybox%2Ffancybox.css,css%2Fjquery-ui.min.css,css%2Fjquery-ui.structure.min.css,css%2Fjquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="/combine.php?files=js%2Fjquery.js,js%2Fjquery-ui.min.js,js%2Fscripts_admin.js,js%2Ffancybox%2Ffancybox.js,js%2Ffancybox%2Fmw.js,js%2Fjquery.dragsort.js"></script>
    <script type="text/javascript" src="/3rdparty/ckeditor/ckeditor.js"></script>
</head>
<body>{if $smarty.const.ADMIN_ID==0}{module name=admin_users view_mode=login}{else}
<script>var ckeUploadPath = '{global var=upload_path}';</script>
<table style="width:100%; height:100%;">
<tr style="height:29px">
    <td colspan="2" class="topbar">
        <span class="fr">Привет, <b>{$me.login}</b></span>
        <h2>{$smarty.const.SETTINGS_SITE_TITLE}</h2>
    </td>
</tr>
<tr>
    <td class="leftpane">
        {foreach $modules as $module}
        <a href="{_ action=$module.name tab=$module.name}"{if $tab==$module.name} class="act"{/if}>{$module.title}</a>
        {/foreach}
        <span></span>
        <a href="/" target="_blank"><b>Открыть сайт</b></a>
        <a href="{_ action=admin_users admin_users.view_mode=edit_profile tab=profile}" {if $tab=='profile'}class="act"{/if}>Профиль</a>
        <a href="{_ action=admin_users admin_users.mode=logout}">Выход</a>
        
        <div class="mt20 hd" style="padding:0 10px">
            <div class="mb5">Пользователи за последние 5 минут:</div>
            <b>
            {foreach $here as $u}
            {$u.login}<br/>
            {/foreach}
            </b>
        </div>
    </td>
    <td class="rightpane{if $action!='admin_users'&&$action!='settings'} valign_top{/if}">
        {if $action!=''}
            {module name=$action action=admin}
        {else}<div style="width:400px"></div>{/if}
    </td>
</tr>
</table>

{/if}
</body>
</html>