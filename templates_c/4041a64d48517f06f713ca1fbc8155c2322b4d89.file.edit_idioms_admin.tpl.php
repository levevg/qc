<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:47:32
         compiled from "/var/www/unseen/qc.unseen.in/templates/idioms/edit_idioms_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16955203515b3a2cf44439e9-80504876%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4041a64d48517f06f713ca1fbc8155c2322b4d89' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/idioms/edit_idioms_admin.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16955203515b3a2cf44439e9-80504876',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function__')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function._.php';
?><form action="<?php echo smarty_function__(array('view_mode'=>$_smarty_tpl->getVariable('view_mode')->value,'mode'=>'save','id'=>$_smarty_tpl->getVariable('id')->value),$_smarty_tpl);?>
" method="POST" id="form" enctype="multipart/form-data" style="margin-top:10px">
    <a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
" class="btn icon_back fl">Назад к списку</a>
    <h2 class="ttl"><?php if ($_smarty_tpl->getVariable('id')->value==''){?>Добавление фразеологизма<?php }else{ ?>Редактирование фразеологизма<?php }?></h2>
    <div class="cl mb20"></div>

    <?php if ($_smarty_tpl->getVariable('ok')->value){?><div class="ok mb20">Данные сохранены</div><?php }?>
    <?php if ($_smarty_tpl->getVariable('err')->value){?><div class="err mb20">Необходимо заполнить все обязательные поля</div><?php }?>

    <table class="form idiom" style="width: 100%">
        <tr>
            <td width="130"<?php if ($_smarty_tpl->getVariable('err_language')->value){?> class="err"<?php }?>>Язык: *</td>
            <td width="400">
                <select name="language" style="width:160px"><option value="">язык фразеологизма</option>
                <?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('langs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value){
?><option value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['code'];?>
"<?php if ($_smarty_tpl->tpl_vars['lang']->value['code']==$_smarty_tpl->getVariable('language')->value){?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['lang']->value['name_native'];?>
</option><?php }} ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td <?php if ($_smarty_tpl->getVariable('err_generator')->value){?> class="err"<?php }?>>Шаблон фразеологизма: *</td>
            <td><textarea rows="2" name="generator" title="Шаблон фразеологизма" placeholder="Пример: бежать/нестись/не_стоять сломя голову [кому-либо]"><?php echo hsc($_smarty_tpl->getVariable('generator')->value);?>
</textarea></td>
            <td><div class="popover left hd" id="generator_popover"><p></p></div></td>
        </tr>
        <tr>
            <td <?php if ($_smarty_tpl->getVariable('err_definition')->value){?> class="err"<?php }?>>Определение:</td>
            <td><textarea rows="3" name="definition" title="Определение" placeholder="Значение фразеологизма"><?php echo hsc($_smarty_tpl->getVariable('definition')->value);?>
</textarea></td>
            <td></td>
        </tr>
        <tr>
            <td>Переводы:<br/><a href="#" onclick="addTranslationInputs(); return false;">+ Добавить</a></td>
            <td id="translations">
                <script>
                    var translationInputsHtml =
                        '<div class="translation_inputs">' +
                        '   <select name="translation_lang[]" title="язык"><option value="">язык</option>' +
                        '   <?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('langs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value){
?><option value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['code'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['code'];?>
</option><?php }} ?>' +
                        '   </select>' +
                        '   <div><textarea rows="2" name="translation[]" title="Перевод" placeholder="Перевод"></textarea></div>' +
                        '</div>';
                    for (var i = 0; i < (<?php echo count($_smarty_tpl->getVariable('translations')->value);?>
 ? <?php echo count($_smarty_tpl->getVariable('translations')->value);?>
 : 1); ++i) document.writeln(translationInputsHtml);
                </script>
            </td>
            <td><div class="popover left hd" id="translations_hint"><p>Для удаления перевода достаточно<br/>оставить поле пустым</p></div></td>
        </tr>
        <tr>
            <td>Цитаты:<br/><a href="#" onclick="addCitationInputs(); return false;">+ Добавить</a></td>
            <td id="citations">
                <script>
                    var citationInputsHtml =
                            '<div class="citation_inputs">' +
                            '    <textarea rows="3" name="citation[]" title="Цитата" placeholder="Цитата или пример"></textarea>' +
                            '    <input type="text" name="citation_src[]" title="Источник" placeholder="Источник"/>' +
                            '</div>';
                    for (var i = 0; i < (<?php echo count($_smarty_tpl->getVariable('citations')->value);?>
 ? <?php echo count($_smarty_tpl->getVariable('citations')->value);?>
 : 1); ++i) document.writeln(citationInputsHtml);
                </script>
            </td>
            <td><div class="popover left hd" id="citations_hint"><p>Для удаления цитаты достаточно<br/>оставить поле пустым</p></div></td>
        </tr>
        <tr>
            <td>Сокращения:</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Теги:</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Связи:</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" class="center" style="padding-top:15px">
                <input type="hidden" name="close" id="close" value="0"/>
                <a href="#" onclick="$('#form').submit(); return false;" class="btn icon_save">Сохранить</a>
                &nbsp;&nbsp;
                <a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('id')->value){?>&unblock_id=<?php echo $_smarty_tpl->getVariable('id')->value;?>
<?php }?>" class="btn icon_cancel">Отмена</a>
            </td>
            <td></td>
        </tr>
    </table>
    <input type="hidden" name="variants"/>
    <input type="hidden" name="translations"/>
    <input type="hidden" name="citations"/>
</form>


<script>
$(function() {
    $('[name=generator]').focus(function(){
        $('#generator_popover').removeClass('hd');
    }).blur(function(){
        $('#generator_popover').addClass('hd');
    }).on('input', function () {
        updateIdiomVariants();
    });

    $('#form').submit(formSubmit);

    updateIdiomVariants();

    
    setCitations(<?php echo json_encode($_smarty_tpl->getVariable('citations')->value);?>
);
    setTranslations(<?php echo json_encode($_smarty_tpl->getVariable('translations')->value);?>
);
    $('div.citation_inputs input').autocomplete({ source: "?ajax=idioms", classes : { "ui-autocomplete" : "autocomplete" } });

    

    $('div.translation_inputs textarea').focus(function(){
        $('#translations_hint').removeClass('hd');
        offsetPopover($('#translations_hint'), $(this));
    }).blur(function(){
        $('#translations_hint').addClass('hd');
    });

    $('div.citation_inputs textarea').focus(function(){
        $('#citations_hint').removeClass('hd');
        offsetPopover($('#citations_hint'), $(this));
    }).blur(function(){
        $('#citations_hint').addClass('hd');
    });
});

function updateIdiomVariants() {
    var html = '<b>Пример:</b><br/>бежать/нестись/не_стоять сломя голову [кому-либо]';

    var variants = [];

    var gen = $('[name=generator]').val();

    gen = gen.replace(/\[.+]/g, function(m){ return m.replace(' ', '_'); });
    gen = gen.replace(/\s*[\\\/]\s*/g, '/');
    var ps = gen.split(/\s+/);
    var parts = [];
    var total = 1;
    for (var i = 0; i < ps.length; ++i) {
        var p = ps[i], o;
        if (o = p.match(/^\[(.+)]$/)) {
            parts[i] = [o[1], ''];
        } else {
            parts[i] = p.split('/');
        }
        total *= parts[i].length;
    }
    for (var j = 0; j < total; ++j) {
        var k = j, variant = [];
        for (i = 0; i < parts.length; ++i) {
            variant[variant.length] = parts[i][k % parts[i].length];
            k = Math.floor(k / parts[i].length);
        }
        variants[variants.length] = variant.join(' ').replace(/_/g, ' ').trim();
    }

    if (variants.length != 1) {
        html += '<br/><br/><b>Варианты (' + variants.length + '):</b><br/>';

        for (i = 0; i < variants.length; ++i) {
            html += variants[i] + '<br/>';
        }
    }

    $('[name=variants]').val(variants.join("\n"));

    $('#generator_popover p').html(html);
}

function addTranslationInputs() {
    $('#translations').append(translationInputsHtml);
}

function addCitationInputs() {
    $('#citations').append(citationInputsHtml);
}

function setCitations(citations) {
    var divs = $('div.citation_inputs');
    for (var i = 0; i < citations.length; ++i) {
        divs.eq(i).find('textarea').val(citations[i]["citation"]);
        divs.eq(i).find('input').val(citations[i]["source"]);
    }
}

function setTranslations(translations) {
    var divs = $('div.translation_inputs');
    for (var i = 0; i < translations.length; ++i) {
        divs.eq(i).find('textarea').val(translations[i]["translation"]);
        divs.eq(i).find('select').val(translations[i]["language"]);
    }
}

function getCitations() {
    var citations = [];
    var ok = true;
    $('div.citation_inputs').each(function(){
        var $this = $(this);
        var source = $this.find('input').val().trim();
            citation = $this.find('textarea').val().trim();
        if (citation != '') {
            citations[citations.length] = { source: source, citation: citation };
        }
    });
    if (ok) {
        $('div.citation_inputs').parents('tr').first().find('td').first().removeClass('err');
    } else {
        $('div.citation_inputs').parents('tr').first().find('td').first().addClass('err');
    }
    return ok ? citations : null;
}

function getTranslations() {
    var translations = [];
    var ok = true;
    $('div.translation_inputs').each(function(){
        var $this = $(this);
        var select = $this.find('select'),
            lang = select.val(),
            tran = $this.find('textarea').val().trim();

        select.removeClass('err');

        if (tran != '') {
            if (lang != '') {
                translations[translations.length] = { language: lang, translation: tran };
            } else {
                select.addClass('err');
                ok = false;
            }
        }
    });
    if (ok) {
        $('div.translation_inputs').parents('tr').first().find('td').first().removeClass('err');
    } else {
        $('div.translation_inputs').parents('tr').first().find('td').first().addClass('err');
    }
    return ok ? translations : null;
}

function formSubmit() {
    var citations = getCitations();
    var translations = getTranslations();

    if (citations === null) return false;
    if (translations === null) return false;

    $('input[name=translations]').val(JSON.stringify(translations));
    $('input[name=citations]').val(JSON.stringify(citations));

    return true;
}

function offsetPopover(popover, target) {
    popover.css('marginTop', (target.position().top - popover.position().top) + 'px');
}
</script>
