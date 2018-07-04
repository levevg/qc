<?php
class admin_users extends module {

    var $name = "admin_users";
    var $title = "Администраторы";
    var $module_category = ""; 	
	
function run(){
	global $session;
	$out = array();
	
	if ($this->view_mode=='edit_profile'){

		$this->edit_profile($out);
		
	} else {
	
		switch ($this->mode) {
			case 'login':
				$out['login'] = $login = $_REQUEST['login'];
				$password = $_REQUEST['password'];
				$id = SQLSelectVal("SELECT id FROM admin_users WHERE login='".mes($login)."' AND password='".md5($password)."'");
				if ($id){
					$session->data['admin_id'] = $id;
					$session->save();
					redirect(SCRIPT_NAME);
				} else $out['error'] = 'Логин или пароль неверны';
				break;
			case 'logout':
			    unset($session->data['admin_id']);
	            $session->save();
	            redirect(SCRIPT_NAME);
	            break;
		}
		
	}
	
	$this->data = $out;
}	

function edit_profile(&$out){
	$rec = SQLSelectOne("SELECT * FROM admin_users WHERE id=".ADMIN_ID);
	if ($this->mode=='save'){
		$login = $_REQUEST['login'];
		$old_password = $_REQUEST['old_password'];
		$password = $_REQUEST['password'];
		$password2 = $_REQUEST['password2'];
		$ok = true;
		$errors = array();
		$rec['login'] = $login;
		if ($login==''){
			$errors[] = 'Логин не может быть пустым';
			$ok = false;
		} else {
			$exists = SQLSelectVal("SELECT id FROM admin_users WHERE login='".mes($login)."' AND id!=".ADMIN_ID);
			if ($exists) {
				$errors[] = 'Логин уже существует';
				$ok = false;
			}
		}
		if ($password!=''){
			if ($old_password=='' || md5($old_password)!=$rec['password']){
				$errors[] = 'Для изменения пароля введите старый пароль';
				$ok = false;
			}
			if ($password!=$password2){
                $errors[] = 'Введённые пароли не совпадают';
                $ok = false;
			}
			$rec['password'] = md5($password);
		}
		if ($ok) {
			if ($rec['id']){
				SQLUpdate('admin_users', $rec);
			} else {
				$rec['id'] = SQLInsert('admin_users', $rec);
			}
			$out['ok'] = 1;
		} else $out['error'] = implode('<br/>', $errors);
	}
	out($rec, $out);
}

}