<?
    include_once("./config.php");
    include_once("./include/errors.php");
    include_once("./include/autoload.php");
    
    $session = new session("sess");
    
    define('ADMIN_ID', (int)$session->data['admin_id']);

    if (!ADMIN_ID){
    	header('HTTP/1.0: 403 Forbidden');
    	exit;
    }
    
    dbConnect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    
    settings::load();
    
    define('SCRIPT_NAME', '/?');
    
    if ($_REQUEST['path']) $path = $_REQUEST['path'];
    else $path = './media/upload/';
    
    if (!is_dir($path)) mkdir($path, 0777, true);
    
    $result = array('status' => 'error', 'error' => 'файл не загружен');

    foreach ($_FILES as $file){
    	if ($file['tmp_name'] && is_file($file['tmp_name'])){
    		$result['filename'] = $file['name'];
    		$result['size'] = $file['size'];
            if (preg_match('/^(.+)\.([^.]+)$/', translit($file['name']), $m)){
            	$name = $m[1];
            	$ext = '.'.$m[2];
            } else {
            	$name = $file['name'];
            	$ext = '';
            }
            $i = '';
            while(is_file($fname = $path.$name.($i==''?'':"_$i").$ext)) ++$i;
            copy($file['tmp_name'], $fname);
            
            $ext = strtolower($ext);
            if ($ext=='.jpg'||$ext=='.jpeg'||$ext=='.png'||$ext=='.gif'){
                $size = getimagesize($fname);
                $result['width'] = $size[0];
                $result['height'] = $size[1];
                
                if ($result['width']>SETTINGS_MAX_IMG_WIDTH || $result['height']>SETTINGS_MAX_IMG_HEIGHT){
                	resizeImage($fname, SETTINGS_MAX_IMG_WIDTH, SETTINGS_MAX_IMG_HEIGHT, SETTINGS_JPEG_QUAL);
                    $size = getimagesize($fname);
                    $result['width'] = $size[0];
                    $result['height'] = $size[1];
                }
            }
            
            $result['file'] = ltrim($fname, '.');
    		
    		$result['status'] = 'ok';
            unset($result['error']);
    		break;
    	}
    }
    
    echo json_encode($result);
    