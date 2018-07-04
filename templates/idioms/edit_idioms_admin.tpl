<form action="{_ view_mode=$view_mode mode=save id=$id}" method="POST" id="form" enctype="multipart/form-data" style="margin-top:10px">
    <a href="{_}" class="btn icon_back fl">Назад к списку</a>
    <h2 class="ttl">{if $id==''}Добавление фразеологизма{else}Редактирование фразеологизма{/if}</h2>
    <div class="cl mb20"></div>

    {if $ok}<div class="ok mb20">Данные сохранены</div>{/if}
    {if $err}<div class="err mb20">Необходимо заполнить все обязательные поля</div>{/if}

    <table class="form idiom" style="width: 100%">
        <tr>
            <td width="130"{if $err_language} class="err"{/if}>Язык: *</td>
            <td width="400">
                <select name="language" style="width:160px"><option value="">язык фразеологизма</option>
                {foreach $langs as $lang}<option value="{$lang.code}"{if $lang.code==$language} selected{/if}>{$lang.name_native}</option>{/foreach}
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td {if $err_generator} class="err"{/if}>Шаблон фразеологизма: *</td>
            <td><textarea rows="2" name="generator" title="Шаблон фразеологизма" placeholder="Пример: бежать/нестись/не_стоять сломя голову [кому-либо]">{$generator|hsc}</textarea></td>
            <td><div class="popover left hd" id="generator_popover"><p></p></div></td>
        </tr>
        <tr>
            <td {if $err_definition} class="err"{/if}>Определение:</td>
            <td><textarea rows="3" name="definition" title="Определение" placeholder="Значение фразеологизма">{$definition|hsc}</textarea></td>
            <td></td>
        </tr>
        <tr>
            <td>Переводы:<br/><a href="#" onclick="addTranslationInputs(); return false;">+ Добавить</a></td>
            <td id="translations">
                <script>
                    var translationInputsHtml =
                        '<div class="translation_inputs">' +
                        '   <select name="translation_lang[]" title="язык"><option value="">язык</option>' +
                        '   {foreach $langs as $lang}<option value="{$lang.code}">{$lang.code}</option>{/foreach}' +
                        '   </select>' +
                        '   <div><textarea rows="2" name="translation[]" title="Перевод" placeholder="Перевод"></textarea></div>' +
                        '</div>';
                    for (var i = 0; i < ({$translations|count} ? {$translations|count} : 1); ++i) document.writeln(translationInputsHtml);
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
                    for (var i = 0; i < ({$citations|count} ? {$citations|count} : 1); ++i) document.writeln(citationInputsHtml);
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
                <a href="{_}{if $id}&unblock_id={$id}{/if}" class="btn icon_cancel">Отмена</a>
            </td>
            <td></td>
        </tr>
    </table>
    <input type="hidden" name="variants"/>
    <input type="hidden" name="translations"/>
    <input type="hidden" name="citations"/>
</form>

{literal}
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

    {/literal}
    setCitations({$citations|json_encode});
    setTranslations({$translations|json_encode});
    $('div.citation_inputs input').autocomplete({ source: "?ajax=idioms", classes : { "ui-autocomplete" : "autocomplete" } });

    {literal}

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
{/literal}