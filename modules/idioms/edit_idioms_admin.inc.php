<?php

    require_once 'modules/languages/languages.class.php';

    $rec = SQLSelectOne("SELECT * FROM idioms WHERE id='{$this->id}'");

    global $translations, $citations;

    loadTranslations($this->id);

    loadCitations($this->id);

    $variants = SQLSelect("SELECT * FROM idiom_variants WHERE idiom_id='{$this->id}'");

    $tags = SQLSelect("SELECT tags.*,  GROUP_CONCAT(tags_localized.language, ':', tags_localized.name ORDER BY language SEPARATOR '\n') AS tags ".
                      "FROM tags JOIN idiom_tags JOIN tags_localized ".
                      "ON (tags.id=idiom_tags.tag_id) AND (tags_localized.tag_id=tags.id) ".
                      "WHERE idiom_id='{$this->id}' GROUP BY tags.id");

    if ($this->mode=='save'){
        $ok = 1;

        $rec['generator'] = trim($_REQUEST['generator']);
        if ($rec['generator'] == '') {
            $ok = false;
            $out['err_generator'] = 1;
        }

        $rec['definition'] = trim($_REQUEST['definition']);

        $rec['language'] = $_REQUEST['language'];
        if ($rec['language'] == '') {
            $ok = false;
            $out['err_language'] = 1;
        }

        if ($ok){

            SQLExec("START TRANSACTION");

            if ($rec['id']) {
                SQLUpdate('idioms', $rec);
            } else {
                $this->id = $rec['id'] = SQLInsert('idioms', $rec);
            }

            saveTranslations($this->id);
            saveCitations($this->id);

            SQLExec("COMMIT");

            $out['ok'] = 1;
            if ($_REQUEST['close']){
                $this->redirect(array('mode'=>'ok'));
                exit;
            }
        } else {
            $out['err'] = 1;

            $translations = json_decode($_REQUEST['translations'], true);
            $citations = json_decode($_REQUEST['citations'], true);
        }
    }

    out($rec, $out);

    $out['langs'] = languages::all();
    $out['translations'] = (array)$translations;
    $out['citations'] = (array)$citations;

    function saveTranslations($id) {
        $oldTranslations = $GLOBALS['translations'];
        $newTranslations = json_decode($_REQUEST["translations"], true);

        $remove_ids = array();
        for ($i = count($newTranslations); $i < count($oldTranslations); ++$i) {
            $remove_ids[] = (int)$oldTranslations[$i]["id"];
        }

        while (count($oldTranslations) < count($newTranslations)) $oldTranslations[] = array();
        $oldTranslations = array_slice($oldTranslations, 0, count($newTranslations));

        for ($i = 0; $i < count($newTranslations); ++$i) {
            $tr = array('idiom_id' => $id, 'language' => $newTranslations[$i]['language'], 'translation' => $newTranslations[$i]['translation']);
            if ($oldTranslations[$i]['id']) {
                $tr['id'] = $oldTranslations[$i]['id'];
                SQLUpdate('translations', $tr);
            } else {
                $tr['id'] = SQLInsert('translations', $tr);
            }
        }

        if (count($remove_ids)) {
            SQLExec("DELETE FROM translations WHERE id IN (".implode(',', $remove_ids).")");
        }

        loadTranslations($id);
    }

    function saveCitations($id) {
        $oldCitations = $GLOBALS['citations'];
        $newCitations = json_decode($_REQUEST["citations"], true);

        $remove_ids = array();
        for ($i = count($newCitations); $i < count($oldCitations); ++$i) {
            $remove_ids[] = (int)$oldCitations[$i]["id"];
        }

        while (count($oldCitations) < count($newCitations)) $oldCitations[] = array();
        $oldCitations = array_slice($oldCitations, 0, count($newCitations));

        for ($i = 0; $i < count($newCitations); ++$i) {
            $tr = array('idiom_id' => $id, 'citation' => $newCitations[$i]['citation'], 'source_id' => getSourceId($newCitations[$i]['source']));
            if ($oldCitations[$i]['id']) {
                $tr['id'] = $oldCitations[$i]['id'];
                SQLUpdate('citations', $tr);
            } else {
                $tr['id'] = SQLInsert('citations', $tr);
            }
        }

        if (count($remove_ids)) {
            SQLExec("DELETE FROM citations WHERE id IN (".implode(',', $remove_ids).")");
        }

        loadCitations($id);
    }

    function loadTranslations($id) {
        global $translations;
        $translations = SQLSelect("SELECT * FROM translations WHERE idiom_id='$id' ORDER BY id");
    }

    function loadCitations($id) {
        global $citations;
        $citations = SQLSelect("SELECT citations.*, sources.title AS source FROM citations LEFT JOIN sources ".
                               "ON (citations.source_id = sources.id) WHERE idiom_id = '$id'");
    }

    function getSourceId($source) {
        $source = trim($source);
        if ($source == '') return 0;
        global $citations;
        foreach ($citations as $c) {
            if (mb_strtolower($c['source']) == mb_strtolower($source)) return $c['source_id'];
        }
        return SQLInsert('sources', array('title' => $source));
    }