<?php
/*--------------------------------------------------
 | Akina Admin Panel
 +--------------------------------------------------
 | version 0.0.3
 | By Vladek aka TerVel
 | URL: https://github.com/TerVel76/akina
 | URL: https://code.google.com/p/akina/
 | Last Changed: 2015-07-15
 +--------------------------------------------------
 | OPEN SOURCE CONTRIBUTIONS
 +--------------------------------------------------
 | function write_ini_file() by Harikrishnan
 | http://stackoverflow.com/questions/1268378/create-ini-file-write-values-in-php
 | в том код был баг, исправил ;)
 |
 | functions from dir.php Version 0.4	Apr 06 2010
 | A script to manage files on your web 
 | Questions, comments, bug reports to : yannickf@yahoo.com
 | SourceForge project phpFileManager:
 | http://sourceforge.net/project/?group_id=1640
 |
 | functions from phpFileManager 0.9.8
 | By Fabricio Seger Kolling
 | Copyright (c) 2004-2013 Fabrício Seger Kolling
 | E-mail: dulldusk@gmail.com
 | URL: http://phpfm.sf.net
 +--------------------------------------------------
 | It is the AUTHOR'S REQUEST that you keep intact the above header information
 | and notify him if you conceive any BUGFIXES or IMPROVEMENTS to this program.
 +--------------------------------------------------
 | LICENSE
 +--------------------------------------------------
 | Licensed under the terms of any of the following licenses at your choice:
 | - GNU General Public License Version 2 or later (the "GPL");
 +--------------------------------------------------
 | CONFIGURATION AND INSTALATION NOTES
 +--------------------------------------------------
 | This program does not include any instalation or configuration
 | notes because it simply does not require them.
 | Just throw this file anywhere in your webserver and enjoy !!
 +--------------------------------------------------
*/

define('akina', 'photohost', true);
header('Content-Type: text/html; charset=utf-8');

// write_ini_file() запись массива в файл INI
function write_ini_file ($assoc_arr, $path, $has_sections=FALSE)
{ 
	    $content = ""; 
	    if ($has_sections)
	    { 
	        foreach ($assoc_arr as $key=>$elem)
	        { 
	            $content .= "[".$key."]\n"; 
	            foreach ($elem as $key2=>$elem2)
	            { 
	                if(is_array($elem2)) 
	                { 
	                    for($i=0;$i<count($elem2);$i++) 
	                    { 
	                        $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
	                    } 
	                } 
	                else if($elem2==='') $content .= $key2." = \n"; 
	                else $content .= $key2." = \"".$elem2."\"\n"; 
	            } 
	        } 
	    } 
	    else
	    { 
	        foreach ($assoc_arr as $key=>$elem)
	        { 
	            if(is_array($elem)) 
	            { 
	                for($i=0;$i<count($elem);$i++) 
	                { 
	                    $content .= $key."[] = \"".$elem[$i]."\"\n"; 
	                } 
	            } 
	            else if($elem==='') $content .= $key." = \n"; 
	            else $content .= $key." = \"".$elem."\"\n"; 
	        } 
	    } 
	
	    if (!$handle = @fopen($path, 'w')) { 
	        return false; 
	    }
	
	    $success = fwrite($handle, $content);
	    fclose($handle);
	
	    return $success; 
}

// содержится файл конфигурации config.php поставляемый по "умолчанию"
function new_config()
{
/* --------------------------------------------------------------------------
 Далее содержится файл конфигурации config.php поставляемый по "умолчанию" 
 По состоянию на v1.0.9h (r77) Jun 26, 2015 
----------------------------------------------------------------------------- */

//////////////////////////////////////параметры изображений//////////////////////////////////////
$config['max_size_mb']=5;
$config['max_size_byte']=$config['max_size_mb']*1048576; // (bytes)
$config['max_height']=5000;
$config['max_width']=5000;
$config['view_one_width']="auto"; //ширина картинки на странице просмотра. картинка одна, большая
$config['view_multi_width']="auto"; //ширина картинок на странице просмотра при мультизагрузке

$config['quality']=100;

$config['mimes']=array('image/gif', 'image/pjpeg', 'image/jpeg', 'image/png', 'image/bmp', 'image/x-ms-bmp');
//расширения которые можно загружать (jpeg и jpe - это jpg)
$config['extensions']=array(
							'gif',
							'jpg',
							'png',
							'bmp',
);

$config['auto_resize']=0;  //Уменьшить изображение, по умолчанию форма: 0 - выключена, 1 - включена
$config['width_resize_elements']=1024; //уменьшать изображения по ширине, по умолчанию в форме
//$config['height_resize_elements']=768; //уменьшать изображения по высоте, по умолчанию в форме
// для исключения искажения изображения добавляется только один параметр, по ширине - имеет приоритет.

$config['auto_preview']=0;  //Создать превью, по умолчанию форма: 0 - выключена, 1 - включена
$config['width_preview_elements']=240; //превью по ширине, по умолчанию в форме
//$config['height_preview_elements']=180; //превью по высоте, по умолчанию в форме
// для исключения искажения изображения добавляется только один параметр, по ширине - имеет приоритет.

//////////////////////////////////////абсолютные пути//////////////////////////////////////

$config['site_dir']=getcwd();
$config['uploaddir']=$config['site_dir'].'/img/';
$config['thumbdir']=$config['site_dir'].'/thumbs/';
$config['working_dir']=$config['site_dir'].'/working/';
$config['working_thumb_dir']=$config['working_dir'].'thumbs/';

//////////////////////////////////////URL//////////////////////////////////////

preg_match('/\/(.*\/).*\.php/', $_SERVER['PHP_SELF'], $out);
$folder = isset($out[1]) ? $out[1]:'';
$config['site_url']='http://'.$_SERVER['HTTP_HOST'].'/'.$folder;
$config['thumbs_url']=$config['site_url'].'thumbs/';
$config['img_url']=$config['site_url'].'img/';

//////////////////////////////////////Шаблон//////////////////////////////////////

//доступные шаблоны 'bluestyle', 'graphene' , 'simple', 'whatsyoursolution'
$config['template_name']='whatsyoursolution'; 
$config['template_path']=$config['site_dir'].'/templates/'.$config['template_name'];
$config['template_url']=$config['site_url'].'templates/'.$config['template_name'];

$config['site_title']='Хостинг картинок AKINA'; //Title страницы, возможно динамическое обновление 
$config['site_header_h1']='Фотохостинг Akina'; //Текст в заголовке сайта тэг H1, возможно динамическое обновление 
$config['site_header_h2']='Хостинг картинок'; //Текст в заголовке сайта тэг H2, возможно динамическое обновление

$config['view_page']=1; //добавлять к коду изображения с превью ссылку на "Страницу просмотра" 0 - выключено, 1 - включено
//если выключено всегда будет ссылка вести прямо на оригинальную картинку 

$config['show_upload_date']=1; //показывать дату/время загрузки изображения на "Странице просмотра" 0 - выключено, 1 - включено

//////////////////////////////////////CURL//////////////////////////////////////

$config['curl_timeout'] = 120;//таймаут для curl
$config['curl_user_agent']='User-Agent: Opera/9.80 (X11; Linux i686; U; ru) Presto/2.9.168 Version/11.50';
$config['curl_headers']=array(
'GET / HTTP/1.1',
'Accept: text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/jpeg, image/gif, image/x-xbitmap, */*;q=0.1',
'Accept-Language: ru,ru-RU;q=0.9,en;q=0.8',
'Accept-Charset: iso-8859-1, utf-8, utf-16, *;q=0.1',
'Accept-Encoding: deflate, gzip, x-gzip, identity, *;q=0',
'Cookie: cookies_enabled=1;',
'Cache-Control: no-cache',
'Connection: Keep-Alive, TE',
'TE: deflate, gzip, chunked, identity, trailers'
);

//////////////////////////////////////Даты - для создания каталогов//////////////////////////////////////

$config['current_month']=date ('Y-m');
$config['current_day']=date ('d');
$config['current_path']=$config['current_month'].'/'.$config['current_day'];
$debug = false; // [true|false] отладка, показывать ошибки PHP включено/выключено

//////////////////////////////////////Прочее//////////////////////////////////////

$config['random_str_quantity']=25;
$config['site_work']=true; // [true|false] сайт работает да/нет
$config['cache_time']=60*60; //в секундах, 1 час.
$config['cachefile']=$config['working_dir']."cachefile.dat"; //файл статистики "Изображений на фотохостинге: х; занимают х.х Kb; за сутки загружено: х"

/* --------------------------------------------------------------------------
Конец файла конфигурации config.php поставляемый по "умолчанию"
----------------------------------------------------------------------------- */

return ($config);
}

// сравнение настроек из существующего ocnfig.php и new_config()
function check_array($array,$arr_key)
{
	GLOBAL $config,$new_config,$level;

// расцветка для подсветки элементов
$check_good="#33AA33";
$check_bad="#FF3333";
$check_empty="#666666";
$check_element="#FF7F00";
	//GLOBAL $check_good,$check_bad,$check_empty,$check_element;
	$chcontent="";
	foreach ($array as $key => $value)
	{
		$check_b="<font color='$check_empty'>";
		$check_e="</font>";
	
  	if (!is_array($value))
  	{
      if (!empty($arr_key))
      {
				if (in_array($value, $config[$arr_key]))
	 			{
				  $check_b="<font color='$check_good'>";
				  $check_e="</font>";
				}
			}
			else
			if (isset($config[$key]))
			{
				if ($config[$key]==$new_config[$key])
				{
				  $check_b="<font color='$check_good'>";
				  $check_e="</font>";
				}
				else
				{
				  $check_b="<font color='$check_bad'>";
				  $check_e="</font>";
				}
			}

		  for ($i=0;$i < $level+1 ;$i++)  $chcontent.= "&nbsp;&nbsp;&nbsp;&nbsp;";
		  
 		  if ($level) $ccf=''; else  $ccf="<font color='$check_element'>\$config</font>";
			$chcontent.= $ccf."['<font color='$check_element'>".$key."</font>'] => ".$check_b.$value."&nbsp".$check_e."<br />\n";
		}
		else
		{
			if (array_key_exists($key, $config))
			{
			  $check_b="<font color='#00CC00'>";
			  $check_e="</font>";
			}

		  for ($i=0;$i < $level+1 ;$i++)  $chcontent.= "&nbsp;&nbsp;&nbsp;&nbsp;";
			$chcontent.= "<font color='$check_element'>\$config</font>['<font color='$check_element'>".$key."</font>'] => ".$check_b."Array".$check_e."<br />\n";

		  for ($i=0;$i < $level+1 ;$i++)  $chcontent.= "&nbsp;&nbsp;&nbsp;&nbsp;";
		  $chcontent.= "&nbsp;&nbsp;(<br />\n";
			$level++;
			$chcontent.= check_array($value,$key);
			$level--;
		  for ($i=0;$i < $level+1 ;$i++)  $chcontent.= "&nbsp;&nbsp;&nbsp;&nbsp;";
		  $chcontent.= "&nbsp;&nbsp;)<br />\n";
		}
	}
  return $chcontent;
}

// функция разделения URL на подкаталоги при переходе по ним
function split_dir($str)
{

	$arr=explode('/', $str);
	$f=1; $g=1;
	$ret='<a href="{self_script}">&lt;корень&gt;</a>&nbsp;';

	$p='';
	if($str!='/')
	{
		foreach($arr as $v)
		{
			$ret.='<a href="{self_script}?cd='.$p.$v.'">'.$v.'</a>';
			if($f==0)
				$f=1;
			else
				$ret.=' / ';

			$p.=$v;
			if($g==0)
				$g=1;
			else
				$p.='/';
		}

	}


	return $ret;
}

// функция сравнения
function cmp( $a, $b )
{
	GLOBAL $sort;

	if( $a->inode == $b->inode )
		return 0;

	switch( $sort )
	{
	  case "size":
			return ($a->size > $b->size) ? -1 : 1;
	  case "type":
			return strcmp($a->type, $b->type);
	  case "view":
			return strcmp($a->view, $b->view);
	  case "atime":
			return ($a->atime > $b->atime) ? -1 : 1;
	  case "ctime":
			return ($a->ctime > $b->ctime) ? -1 : 1;
	  case "mtime":
			return ($a->mtime > $b->mtime) ? -1 : 1;
	  case "group":
			return strcmp($a->group, $b->group);
	  case "inode":
			return ($a->inode > $b->inode) ? -1 : 1;
	  case "owner":
			return strcmp($a->owner, $b->owner);
	  case "perms":
			return ($a->perms > $b->perms) ? -1 : 1;
	  case "ext":
			return strcmp($a->ext, $b->ext);
	  case "name":
			return strcmp(strtolower($a->name), strtolower($b->name));
	  default:
			return 1;
	}
}

// вырезание лишнего мусора из GET запроса при переходе по каталогам
function escape_dir($str)
{
	$ret=str_replace("/../", '/', $str);
	$ret=str_replace("/./", '/', $ret);
	$ret=str_replace("/..", '/', $str);
	$ret=str_replace("/./", '/', $ret);
	$ret=str_replace("\\", "", $ret);
	return $ret;
}

// удобоваримыое отображение прав доступа к файлу/каталогу
function formperms($v,$own)
{
 GLOBAL $uid;
 $s=substr(sprintf('%o', $v), -4);
 
 if ($own===$uid)
 		$ret="<font color='grey'>".$s[0]."</font><font color='green'>".$s[1]."</font><font color='grey'>".$s[2].$s[3]."</font>";
 else
 	if ($s[3]==='7' || $s[3]==='6')
 		$ret="<font color='grey'>".$s[0].$s[1].$s[2]."</font><font color='green'>".$s[3]."</font>";
 	else
 		$ret="<font color='grey'>".$s[0].$s[1].$s[2]."</font><font color='red'><b>".$s[3]."<b></font>";

 return $ret;
}

//кодирование переменных для предоставления в GET запрос
function genUrl( $ref, $args, $key = "", $val = "" )
{
	$valist = "";

	reset( $args );

	if( $key != "" )
		$args[ "$key" ] = $val;

	if( !is_array( $args ) )
		return $ref;

	while( list( $key, $val ) = each( $args ) )
  {
		if( $val == "" )
			continue;

		if( $valist == "" )
			$valist .= "?";
		else
			$valist .= "&";

		$valist .= $key."=".rawurlencode($val);
	}
	return $ref.$valist;
}

// удаление файлов и каталогов
function total_delete($arg)
{
	GLOBAL $error, $inform;
	if (file_exists($arg))
	{
		@chmod($arg,0755);
		if (is_dir($arg))
		{
			$handle = opendir($arg);
			while($aux = readdir($handle))
			{
				if ($aux != "." && $aux != "..") total_delete($arg."/".$aux);
			}
			@closedir($handle);
			if (@rmdir($arg))
			{
				$inform[]= "$arg - удален\n";
			}
			else
				$error[]= "Невозможно удалить $arg\n";
		}
		else
		if (@unlink($arg))
			{
				$inform[]= "$arg - удален\n";
			}
		else
			$error[]= "Невозможно удалить $arg\n";

	}
}

// класс с массивом структуры "текущего" каталога
class MyFile {
	var $name;
	var $fpath;
	var $type;
	var $ext;
	var $size;
	var $file;
	var $atime;
	var $ctime;
	var $mtime;
	var $group;
	var $inode;
	var $owner;
	var $perms;

	function set( $filename, $fpath )
	{
		GLOBAL $cd;

		$this->name  = $filename;
		$this->fpath  = $fpath    ;
		$this->file  = $this->fpath."/".$this->name;

		$this->type  = filetype( $this->file );
//		if ($this->type == "dir") $this->size = dirSize( $this->file );	else
		$this->size = sprintf("%u", filesize($this->file));  //$this->size  = filesize( $this->file );
		$this->atime = fileatime( $this->file );
		$this->ctime = filectime( $this->file );
		$this->mtime = filemtime( $this->file );
		$this->group = filegroup( $this->file );
		$this->inode = fileinode( $this->file );
		$this->owner = fileowner( $this->file );
		$this->perms = fileperms( $this->file );

		switch( $this->type )
		{
			case "link":
				$this->ext   = "link";
				break;
			case "file":
				$list = explode( ".", $this->name );
				$nb = sizeof( $list );
				if( $nb > 0 )
					$this->stype = $list[$nb-1];
				else
					$this->stype = "???";
				$this->ext   = $this->stype;
				break;
		  default:
				$this->ext   = $this->type;
				break;
		}
	}

	function formatSize()
	{
//		return decodeSize($his->size);
		return number_format( $this->size, 0, ".", "");
	}
}

// phpinfo и другое
function server_info(){
    if (!@phpinfo()) echo 'NoPhpinfo'."...";
    echo "<br><br>";
	    $a=ini_get_all();
	    $output="<table border=1 cellspacing=0 cellpadding=4 align=center>";
	    $output.="<tr><th colspan=2>ini_get_all()</td></tr>";
	    while(list($key, $value)=each($a)) {
	        list($k, $v)= each($a[$key]);
	        $output.="<tr><td align=right>$key</td><td>$v</td></tr>";
	    }
	    $output.="</table>";
	echo $output;
    echo "<br><br>";
	    $output="<table border=1 cellspacing=0 cellpadding=4 align=center>";
	    $output.="<tr><th colspan=2>\$_SERVER</td></tr>";
	    foreach ($_SERVER as $k=>$v) {
	        $output.="<tr><td align=right>$k</td><td>$v</td></tr>";
	    }
	    $output.="</table>";
	echo $output;
    echo "<br><br>";
    echo "<table border=1 cellspacing=0 cellpadding=4 align=center>";
    $safe_mode=trim(ini_get("safe_mode"));
    if ((strlen($safe_mode)==0)||($safe_mode==0)) $safe_mode=false;
    else $safe_mode=true;
    $is_windows_server = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
    echo "<tr><td colspan=2>".php_uname();
    echo "<tr><td>safe_mode<td>".($safe_mode?"on":"off");
    if ($is_windows_server) echo "<tr><td>sisop<td>Windows<br>";
    else echo "<tr><td>sisop<td>Linux<br>";
    echo "</table><br><br><table border=1 cellspacing=0 cellpadding=4 align=center>";
    $display_errors=ini_get("display_errors");
    $ignore_user_abort = ignore_user_abort();
    $max_execution_time = ini_get("max_execution_time");
    $upload_max_filesize = ini_get("upload_max_filesize");
    $memory_limit=ini_get("memory_limit");
    $output_buffering=ini_get("output_buffering");
    $default_socket_timeout=ini_get("default_socket_timeout");
    $allow_url_fopen = ini_get("allow_url_fopen");
    $magic_quotes_gpc = ini_get("magic_quotes_gpc");
    ignore_user_abort(true);
    ini_set("display_errors",0);
    ini_set("max_execution_time",0);
    ini_set("upload_max_filesize","10M");
    ini_set("memory_limit","20M");
    ini_set("output_buffering",0);
    ini_set("default_socket_timeout",30);
    ini_set("allow_url_fopen",1);
    ini_set("magic_quotes_gpc",0);
    echo "<tr><td> <td>Get<td>Set<td>Get";
    echo "<tr><td>display_errors<td>$display_errors<td>0<td>".ini_get("display_errors");
    echo "<tr><td>ignore_user_abort<td>".($ignore_user_abort?"on":"off")."<td>on<td>".(ignore_user_abort()?"on":"off");
    echo "<tr><td>max_execution_time<td>$max_execution_time<td>0<td>".ini_get("max_execution_time");
    echo "<tr><td>upload_max_filesize<td>$upload_max_filesize<td>10M<td>".ini_get("upload_max_filesize");
    echo "<tr><td>memory_limit<td>$memory_limit<td>20M<td>".ini_get("memory_limit");
    echo "<tr><td>output_buffering<td>$output_buffering<td>0<td>".ini_get("output_buffering");
    echo "<tr><td>default_socket_timeout<td>$default_socket_timeout<td>30<td>".ini_get("default_socket_timeout");
    echo "<tr><td>allow_url_fopen<td>$allow_url_fopen<td>1<td>".ini_get("allow_url_fopen");
    echo "<tr><td>magic_quotes_gpc<td>$magic_quotes_gpc<td>0<td>".ini_get("magic_quotes_gpc");
    echo "</table><br><br>";
    echo "
    <script language=\"Javascript\" type=\"text/javascript\">
    <!--
        window.moveTo((window.screen.width-800)/2,((window.screen.height-600)/2)-20);
        window.focus();
    //-->
    </script>";
    echo "</body>\n</html>";
}

//загружаем предустановки
if(!include_once('config.php')) die('Can\'t find config.php');

$init_php=false;
//инициализация и проверка
if (file_exists('init.php'))
{
	$init_php=true;
	if(!include_once('init.php')) die('Can\'t find init.php');
}

//загружаем функции
if(!include_once('functions.php')) die('Can\'t find functions.php');


if (!function_exists('check_perm')){
function check_perm($chk_obj,$errmod=false)
{
	GLOBAL $error;
	//проверка прав доступа к каталогам/файлам
	$processUser = posix_getpwuid(posix_geteuid());
	$uid=$processUser['uid']; //UID пользователя от имени которого работает WEB сервер

	if(!file_exists($chk_obj))
	{
		if ($errmod) $error[]="$chk_obj не найден";
		return false;
	}

	/* здесь  перепроверка каталогов и вывод где ошибка */
	$perms = substr(decoct(@fileperms($chk_obj)), 2);
	$fown = @fileowner($chk_obj);
	if (is_dir($chk_obj))
	{
		if (($uid!=$fown and $perms[2]!='7') || ($uid==$fown and $perms[0]!='7'))
		{
	 		if ($errmod) $error[]="Ошибка установки прав на каталог $chk_obj";
	 		return false;
		}
		else
			return true;
	}
	else
	{
		if (($uid!=$fown and $perms[3]!='6') || ($uid==$fown and $perms[1]!='6'))
		{
	 		if ($errmod) $error[]="Ошибка установки прав на файл $chk_obj";
	 		return false;
		}
		else
			return true;
	}
	
}}

/* здесь  перепроверка каталогов и вывод где ошибка */
check_perm($config['working_dir'],1);
check_perm($config['working_thumb_dir'],1);
check_perm($config['uploaddir'],1);
check_perm($config['thumbdir'],1);

//если старый конфиг не содержит IniFile
if (!isset($IniFile) and isset($config['working_dir']))
{ $IniFile=$config['working_dir'].'config.ini';
	$OldConfigNoINI=1;
}

check_perm($IniFile,1);

preg_match('/\/(.*\/).*\.php/', $_SERVER['PHP_SELF'], $out);
$folder_adm = isset($out[1]) ? $out[1]:'';
if ((!isset($config['site_http_path'])) ||
    ((isset($config['site_http_path'])) && ($config['site_http_path']!='http://'.$_SERVER['HTTP_HOST'].'/'.$folder_adm))
    )
	$config['site_http_path']='http://'.$_SERVER['HTTP_HOST'].'/'.$folder_adm;

//$config['site_url']='http://'.$_SERVER['HTTP_HOST'].'/'.$folder_adm;
//$config['thumbs_url']=$config['site_url'].'thumbs/';
//$config['img_url']=$config['site_url'].'img/';


if (!isset($debug)) $debug=false;

$template = @file_get_contents($config['site_dir'].'/admin/admin.tpl')
		or die('Template admin.tpl don\'t find.');

//проверка прав доступа к каталогам
$processUser = posix_getpwuid(posix_geteuid());
$uid=$processUser['uid']; //UID пользователя от имени которого работает WEB сервер

//предустановка для шаблона
$parse_tpl=array();
$parse_tpl['{site_title}']='ADMIN Lite Panel - Akina Фотохостинг.';
$parse_tpl['{site_header_h1}']='Akina. ADMIN Panel';
$parse_tpl['{site_header_h2}']='';
$parse_tpl['{menu}']='<li><a href="?">[Главное меню]</a></li>';
$parse_tpl['{content}']='';
$parse_tpl['{inner_js}']='';
$parse_stat='';
$passwd='';

// Стартуем сессию
session_start();
header("http/1.0 200 Ok");
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                          // HTTP/1.0

	if (!file_exists($IniFile))
	{
		$passwd=random_string(8, 'lower,numbers');
		$IniData = array('admin' => array('pass' => $passwd));
		if (!@write_ini_file($IniData, $IniFile, true)) $error[]="Ошибка записи в файл $IniFile [1]";
		else
			$parse_stat="--- угадайте пароль <font color='red'>:)</font> ---<br>\n";

	}
	else
	{
		if (!isset($ini_array))	$ini_array = @parse_ini_file($IniFile,true);
		if (isset($ini_array['admin']['pass']))
		{
					$tmppasswd=$ini_array['admin']['pass'];
					if ($tmppasswd[0]!='{')
					{
						$passwd="{".md5($tmppasswd);
						$IniData = array('admin' => array('pass' => $passwd));
						if (!@write_ini_file($IniData, $IniFile, true)) $error[]="Ошибка записи в файл $IniFile [2]";
					}
					else
						$passwd=$tmppasswd;
					unset($tmppasswd);
		}
		else
		{
			$passwd=random_string(8, 'lower,numbers');
			$IniData = array('admin' => array('pass' => $passwd));
			if (!@write_ini_file($IniData, $IniFile, true)) $error[]="Ошибка записи в файл $IniFile [3]";
			else
				$parse_stat="--- угадайте пароль <font color='red'>:)</font> ---<br>\n";
		}
	
	}

if(!isset($_SESSION['Admin_Ok']))
{

	if((isset($_POST['act'])) and (isset($_POST['pass'])) and ("{".md5($_POST['pass'])==$passwd))
	{
		$_SESSION['Admin_Ok']=1;
		$parse_tpl['{site_header_h1}']='Akina. Вход';
		$parse_tpl['{site_header_h2}']='Вход выполнен успешно. Ждите.';
		$parse_tpl['{content}']='Ждите перенаправления...';
		$_SESSION['Preview']=1; //по умолчанию показываем превью картинок
		$_SESSION['ViewLog']=1; //по умолчанию показываем протокол успешных операций

		header( "refresh:0;url=".$_SERVER["PHP_SELF"] );
	}
	else
	{
		if((isset($_POST['pass'])) and ("{".md5($_POST['pass'])!=$passwd))
			$error[]="<font color=red>Пароль не верный</font>";

		if (isset($_SESSION['Admin_Ok'])) unset($_SESSION['Admin_Ok']);

		$parse_tpl['{site_title}']='Akina. Вход';
		$parse_tpl['{site_header_h2}']='Akina Вход';
		$parse_tpl['{content}']='
		<b>Akina Admin</b> приветствует вас!<br>'.$parse_stat.'<br><br>
		<form action="?" method="post" class="configform">
		<input name="act" type="hidden" value="ok">
		Пароль: <input name="pass" type="password" value=""><br><br>
		<input type="submit" value=" Вход " />
		</form><br>';

	}
}
else
{	//isset($_SESSION['Admin_Ok'])

	if ( (isset($_SESSION['Files']) && (!isset($_GET['nofiles'])) ) || (isset($_GET['files'])) ) //файловая панель
	{	
		clearstatcache();

		if (isset($_POST['act']))
		{
			switch($_POST['act'])
			{

				case 'set' :
											if (isset($_POST['prev']) && ($_POST['prev']=='1')) $_SESSION['Preview']=1;
											else if (isset($_SESSION['Preview'])) unset($_SESSION['Preview']);

											if (isset($_POST['log']) && ($_POST['log']=='1')) $_SESSION['ViewLog']=1;
											else if (isset($_SESSION['ViewLog'])) unset($_SESSION['ViewLog']);
											
										break;
				default :
											$parse_tpl['{content}'].="<font color=red>функция _POST не определана</font>\n";
											header( "refresh:1;url=?" );
										break;

			}

		}
		elseif (isset($_GET['act']))
		{
			switch($_GET['act'])
			{

				default :
											$parse_tpl['{content}'].="<font color=red>функция _GET не определана</font>\n";
											header( "refresh:1;url=?" );
										break;

			}

		}

			if(isset($_GET['step']))
			{
  			$step = $_GET['step'];
				$args["step"] = $step;
  		}
			else
  			$step = 100;

			if(isset($_GET['cd']))
  			$cd = escape_dir($_GET['cd']);
			else
  			$cd = '';

			if(isset($_GET['sort']))
			{
  			$sort = $_GET['sort'];
				$args["sort"] = $sort;
  		}
			else
  			$sort = "name";

			$ref = "{self_script}";

			if(isset($_GET['from']))
			{
  			$from = $_GET['from'];
				$args["from"] = $from;
			}
			else
  			$from = 0;

			if(isset($_GET['to']))
			{
  			$to = $_GET['to'];
				$args["to"] = $to;
			}
			else
				$to = $from + $step;

		if (!isset($_SESSION['Files'])) $_SESSION['Files']=1;
		if (isset($_SESSION['Preview'])) $chkdp="checked"; else $chkdp="";
		if (isset($_SESSION['ViewLog'])) $chkdl="checked"; else $chkdl="";
	$parse_tpl['{site_header_h2}']='Akina. Файлы на хостинге.';
	$parse_tpl['{menu}'] ='<li><a href="?nofiles=1">[Главное меню]</a></li>';
	$parse_tpl['{menu}'].='<li><a href="?act=setting&nofiles=1">[Настройки]</a></li>';
	$parse_tpl['{menu}'].='<li><a href="?act=logoff&nofiles=1">[Выход]</a></li>';
	$parse_tpl['{menu}'].="<li><INPUT TYPE='checkbox' ID='check_prev' NAME='prev' VALUE='1' ".$chkdp." title='Показывать Превью картинок'> Превью <INPUT TYPE='checkbox' ID='check_log' NAME='log' VALUE='1' ".$chkdl." title='Показывать Лог успешных операций'> Лог</li>";
	

	$parse_tpl['{content}']="\n";

			$template_dir= "";

// js подтверждения удаления
			$parse_tpl['{inner_js}'].="
function confirmDelete()
{if (confirm('Вы подтверждаете удаление выделеных объектов?')) {return true;} else {return false;}}\n";

			$parse_tpl['{inner_js}'].="
$(function() {
    $('#check_prev').on('change', sendChBoxStatus);
    $('#check_log').on('change', sendChBoxStatus);
    
    function sendChBoxStatus() {
    if (confirm('Does the status of this survey really changed?')) {
        prev_val = $('#check_prev').is(':checked') ? 1 : 0;
        log_val = $('#check_log').is(':checked') ? 1 : 0;
        $.post( '".$_SERVER["PHP_SELF"]."', { act: 'set', prev: prev_val, log: log_val}, location.reload());
    }
    }
});";
//	<FORM NAME='del' METHOD='post' ACTION='?cd=".$cd."'><INPUT TYPE='hidden' NAME='act' VALUE='set'><INPUT TYPE='checkbox' NAME='prev' VALUE='01' ".$chkdp." >Показывать Превью <INPUT TYPE='checkbox' NAME='log' VALUE='01' ".$chkdl." >Показывать Лог <INPUT TYPE='submit' VALUE=' Set '></form>


// js превью картинок 
			if (isset($_SESSION['Preview'])) $parse_tpl['{inner_js}'].="
 // Image preview script powered by jQuery (http://www.jquery.com)
 // written by Alen Grakalic (http://cssglobe.com)
 // for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 
this.imagePreview = function(){	
	/* CONFIG */
		
		xOffset = 10;
		yOffset = 10;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	$(\"a.preview\").hover(function(e){
		this.t = this.title;
		this.title = \"\";	
		var c = (this.t != \"\") ? \"<br/>\" + this.t : \"\";
		$(\"body\").append(\"<p id='preview'><img src='\"+ this.href +\"' alt='Image preview' />\"+ c +\"</p>\");								 
		$(\"#preview\")
			.css(\"top\",(e.pageY - xOffset) + \"px\")
			.css(\"left\",(e.pageX + yOffset) + \"px\")
			.fadeIn(\"fast\");						
    },
	function(){
		this.title = this.t;	
		$(\"#preview\").remove();
    });	
	$(\"a.preview\").mousemove(function(e){
		$(\"#preview\")
			.css(\"top\",(e.pageY - xOffset) + \"px\")
			.css(\"left\",(e.pageX + yOffset) + \"px\");
	});			
};


// starting the script on page load
$(document).ready(function(){
	imagePreview();
});\n";

// debug
//echo "<!-- \n";
//if( isset($_POST)){echo "\nPOST \n";  print_r($_POST); echo "\n";}
//echo "cd: $cd\n";
//if( isset($_POST["nb"])){echo "\nPOST nb: \n";  print_r($_POST["nb"]); echo "\n";}
//echo "\n -->\n";


			$fpath = $config['uploaddir'].$cd;
			$args["cd"] = $cd;

			if( isset( $_POST['nb'] ) ) //удаление файлов и каталогов
			{

				$inform[]= "Удаляем:<br>\n";
				for( $i = 0; $i < $_POST['nb']; $i++ )
				{
					if( isset( $_POST["id_$i"] ) )
					{
						$file = $fpath."/".$_POST["id_$i"];
						total_delete($file);
						$file = $config['thumbdir'].$cd."/".$_POST["id_$i"];
						total_delete($file);
					}
				}
			}
			
					$template_dir.= split_dir($cd)."<br><br>\n";
		if (file_exists($fpath))
		{
///////////////читаем каталог 
					$d = dir($fpath);
					$n =0;
					while( $entry=$d->read() )
					{
						$lFiles[ $n ] = new MyFile;
						$lFiles[ $n ]->set( $entry, $fpath );
						$n++;
					}
					$d->close();
///////////////закончили читать


			if(($from-$step) >= 0 )
			{
				$template_dir.= "<a href='".genUrl( $ref, $args, "from", $from-$step )."' >&laquo;&nbsp;Prev</a>&nbsp/\n";
			}
			if($to <= $n)
			{
				$template_dir.= "<a href='".genUrl( $ref, $args, "from", $to )."' >Next&nbsp;&raquo;</a><br/>\n";
			}
			
					//форма + шапка таблицы
					$template_dir.= "<FORM NAME='del' METHOD='post' ACTION='".genUrl( $ref, $args )."'>\n";
					$template_dir.= "<TABLE >\n";
					$template_dir.= "<TR>\n";
					$template_dir.= "<TH>&nbsp;&check;&nbsp;</TH>\n";
					//$template_dir.= "<TH><a href='".genUrl( $ref, $args, "sort", "type" )."'>Type</a></TH>\n";
					$template_dir.= "<TH width=250><a href='".genUrl( $ref, $args, "sort", "name" )."'>Имя</a></TH>\n";
					$template_dir.= "<TH width=70><a href='".genUrl( $ref, $args, "sort", "size" )."'>Размер</a></TH>\n";
					//$template_dir.= "<TH><a href='".genUrl( $ref, $args, "sort", "ext"   )."'>ext</a></TH>\n";
					$template_dir.= "<TH width=118><a href='".genUrl( $ref, $args, "sort", "mtime" )."'>mtime</a></TH>\n";
					$template_dir.= "<TH width=118><a href='".genUrl( $ref, $args, "sort", "atime" )."'>atime</a></TH>\n";
					//$template_dir.= "<TH width=118><a href='".genUrl( $ref, $args, "sort", "ctime" )."'>создан</a></TH>\n";
					$template_dir.= "<TH><a href='".genUrl( $ref, $args, "sort", "perms" )."'>perms</a></TH>\n";
					//$template_dir.= "<TH><a href='".genUrl( $ref, $args, "sort", "group" )."'>group</a></TH>\n";
					//$template_dir.= "<TH><a href='".genUrl( $ref, $args, "sort", "owner" )."'>owner</a></TH>\n";
					//$template_dir.= "<TH><a href='".genUrl( $ref, $args, "sort", "inode" )."'>inode</a></TH>\n";
						$template_dir.= "</TR>\n";
					//конец шапки таблицы
			
					//сортируем
					@usort( $lFiles, cmp );
			
			for( $i = 0; $i < $n; $i++ )
			{
				if( ( $i < $from ) || ( $i >= $to ) )
					continue;
				$k = $i;
				if (( $lFiles[ $k ]->name != "lost+found" ) && ($lFiles[ $k ]->name[0] != "."))
				{
					$template_dir.= "<TR>\n";
					$template_dir.= "<TD ID='td01'><INPUT TYPE='checkbox' NAME='id_$k' VALUE='".$lFiles[ $k ]->name."'></TD>\n";
			
					if ($cd =="" )
						$tcd = $lFiles[ $k ]->name;
			  	else
						$tcd = $cd."/".$lFiles[ $k ]->name;
			
					//$dform = "d.m.Y, H:i";
					$dform = "Y.m.d H:i";
			//  	echo "<TD ID='td02'>".$lFiles[ $k ]->type."</TD>\n";
			
			  	$template_dir.= "<TD ID='td03'>&nbsp;";
			
			  	if ( $lFiles[ $k ]->type == "dir" )
			  	{
			      if ($cd =="" )
			        $tcd = $lFiles[ $k ]->name;
			      else
			        $tcd = $cd."/".$lFiles[ $k ]->name;
				  	$template_dir.= "<a href='".genUrl( $ref, $args, "cd", $tcd )."'><b><i>".$lFiles[ $k ]->name."</i></b></a>";
			    	$template_dir.= "</TD>\n";
			  		$template_dir.= "<TD ID='td04'>---</TD>\n";
					}
					else
					{
				  	
				  		//$template_dir.= $lFiles[ $k ]->name;
				  		if (file_exists($config['thumbdir']."/".$cd."/".$lFiles[ $k ]->name))
				  		{	$template_dir.="<a href='".$config['thumbs_url'].$cd."/".$lFiles[ $k ]->name."' class='preview'>".$lFiles[ $k ]->name."</a>";
				  		}
				  		else
				  		{	$template_dir.="<a href='".$config['img_url'].$cd."/".$lFiles[ $k ]->name."' class='preview'>".$lFiles[ $k ]->name."</a>";
				  		}
				  	
			    	$template_dir.= "</TD>\n";
			  		$template_dir.= "<TD ID='td04'>".formatfilesize($lFiles[ $k ]->formatSize())."</TD>\n";
			  	}
				//	$template_dir.= "<TD ID='td05'>".$lFiles[ $k ]->ext  ."</TD>\n";
					$template_dir.= "<TD ID='td06'>".date( $dform, $lFiles[ $k ]->mtime )."</TD>\n";
					$template_dir.= "<TD ID='td07'>".date( $dform, $lFiles[ $k ]->atime )."</TD>\n";
					//$template_dir.= "<TD ID='td08'>".date( $dform, $lFiles[ $k ]->ctime )."</TD>\n";
					$template_dir.= "<TD ID='td09'>".formperms($lFiles[ $k ]->perms,$lFiles[ $k ]->owner)."</TD>\n";
				//	$template_dir.= "<TD ID='td10'>".$lFiles[ $k ]->group."</TD>\n";
				//	$template_dir.= "<TD ID='td11'>".$lFiles[ $k ]->owner."</TD>\n";
				//	$template_dir.= "<TD ID='td12'>".$lFiles[ $k ]->inode."</TD>\n";
					$template_dir.= "</TR>\n";
				}
			}
			
			$template_dir.= "</TABLE>\n";
			
			$from = $from - $step;
			if( isset( $cd ) )
			{
				$template_dir.= "<INPUT TYPE='hidden' NAME='cd' VALUE='$cd'>\n";
			}
			$template_dir.= "<INPUT TYPE='hidden' NAME='nb' VALUE='$n'>\n";
			//$template_dir.= "<INPUT TYPE='hidden' NAME='act' VALUE='delete'>\n";
			
			//$template_dir.= "<br />from=$from;to=$to;n=$n\n";
			$template_dir.= "<br />\n";
			if( $from >=  0 )
			{
				$template_dir.= "<a href='".genUrl( $ref, $args, "from", $from )."' >&laquo;&nbsp;Prev</a>&nbsp/\n";
			}
			if( $to   <= $n )
			{
				$template_dir.= "<a href='".genUrl( $ref, $args, "from", $to )."'   >Next&nbsp;&raquo;</a><br/>\n";
			}
			$template_dir.= "<br /><INPUT TYPE='submit' VALUE=' Delete ' onclick='return confirmDelete();'>\n</FORM>\n";
			
			$parse_dir['{self_script}'] = $_SERVER["PHP_SELF"];
			
			$parse_tpl['{content}'].=parse_template($template_dir, $parse_dir);
			unset($parse_dir);
		}
		else
			$error[]="Folder non exists ".$fpath;


	}
	elseif (isset($_POST['act']))
	{
		switch($_POST['act'])
		{
			case 'logoff' : //выход
											if (isset($_SESSION['Admin_Ok'])) unset($_SESSION['Admin_Ok']);
											if (isset($_SESSION['Files'])) unset($_SESSION['Files']);
											$parse_tpl['{site_header_h1}']='Akina. Выход';
											$parse_tpl['{site_header_h2}']='Выход из панели выполнен успешно. Ждите ...';
											$parse_tpl['{content}']='Выход из панели выполнен успешно. Ждите ...';
											header( "refresh:0;url=".$_SERVER["PHP_SELF"] );
										break;

			case 'changepass' : //смена пароля
											$parse_tpl['{site_header_h2}']='Akina. Смена пароля.';
											if (isset($_SESSION['Files'])) unset($_SESSION['Files']);
											if((isset($_POST['pass'])) and ("{".md5($_POST['pass'])==$passwd))
											{
												if((isset($_POST['passn'])) and (isset($_POST['passrn'])) and ($_POST['passn']=$_POST['passrn']))
												{
													$parse_tpl['{content}'].="Всё ок!\n<br>\n";
													$ini_array['admin']['pass']="{".md5($_POST['passn']);
													if (!@write_ini_file($ini_array, $IniFile, true)) $error[]="Ошибка записи в файл $IniFile [4]";
												}
												else
													$error[]="Пароли не совпадают.";
											}
											else
											{
													$error[]="Основной пароль не верный.";
											}
											header( "refresh:3;url=".$_SERVER["PHP_SELF"]."?act=chpass" );
										break;
			case 'saveini' : //созранение конфигурации

											$parse_tpl['{site_header_h2}']='Akina. Сохранение настроек.';

											$IniData = array( 'config' => $config,
	                											'debug' => array('debug' => $debug,),
	                											'admin' => array('pass' => $passwd,),
																			);
													foreach ($_POST as $key => $value)
													{
														if (isset($IniData['config'][$key]))
														$IniData['config'][$key]=$value;
													}
											$IniData['config']['max_size_byte']=$IniData['config']['max_size_mb']*1048576; // (bytes)
											//убить временные параметры из конфигурации
											unset($IniData['config']['current_month']);
											unset($IniData['config']['current_day']);
											unset($IniData['config']['current_path']);
											unset($IniData['config']['site_dir']);
											//unset($IniData['config']['template_path']);
											//unset($IniData['config']['template_url']);
											unset($IniData['config']['uploaddir']);
											unset($IniData['config']['thumbdir']);
											unset($IniData['config']['working_dir']);
											unset($IniData['config']['working_thumb_dir']);
											unset($IniData['config']['site_url']);
											unset($IniData['config']['thumbs_url']);
											unset($IniData['config']['img_url']);
											unset($IniData['config']['site_http_path']);
											if (!$init_php)
											{ 
												$IniData['config']['template_path']=$config['site_dir'].'/templates/'.$IniData['config']['template_name'];
												$IniData['config']['template_url']=$config['site_url'].'templates/'.$IniData['config']['template_name'];
											}
											

											if (!write_ini_file($IniData, $IniFile, true))
												$error[]="Ошибка записи в файл $IniFile [5]";
											else
												$parse_tpl['{content}'].=" Файл $IniFile сохранен успешно.\n";
											//echo "<pre>";	print_r($_POST);echo "</pre>";

											header( "refresh:1;url=".$_SERVER["PHP_SELF"] );
										break;
			default :
											$parse_tpl['{content}'].="<font color=red>функция _POST не определана</font>\n";
											header( "refresh:1;url=".$_SERVER["PHP_SELF"] );
										break;

		}

	}
	elseif (isset($_GET['act']))
	{
		switch($_GET['act'])
		{
			case 'logoff' :
											if (isset($_SESSION['Admin_Ok'])) unset($_SESSION['Admin_Ok']);
											if (isset($_SESSION['Files'])) unset($_SESSION['Files']);
											$parse_tpl['{site_header_h1}']='Akina. Выход';
											$parse_tpl['{site_header_h2}']='Выход из панели выполнен успешно. Ждите ...';
											$parse_tpl['{content}']='Выход из панели выполнен успешно. Ждите ...';
											header( "refresh:0;url=".$_SERVER["PHP_SELF"] );
										break;
			case 'chpass' :
											if (isset($_SESSION['Files'])) unset($_SESSION['Files']);
											$parse_tpl['{site_title}']='Akina Фотохостинг. ADMIN Panel.';
											$parse_tpl['{site_header_h2}']='Akina. Смена пароля.';
											$parse_tpl['{content}']='
											'.$parse_stat.'
											<br>
											<form action="?" method="post">
											<input name="act" type="hidden" value="changepass">
											Cтарый пароль: <input name="pass" type="password" value=""><br><br>
											Пароль новый: <input name="passn" type="password" value=""><br>
											Пароль новый повтор: <input name="passrn" type="password" value=""><br><br>
											<input type="submit" value="Сменить" />
											</form>
											<br>';
										break;

			case 'setting' :
//											clearstatcache();
											if (isset($_SESSION['Files'])) unset($_SESSION['Files']);

											$parse_tpl['{site_header_h2}']='Akina. Настройки.';
											$parse_tpl['{menu}'].='<li><a href="?act=logoff">[Выход]</a></li>';

											if (isset($OldConfigNoINI)) $error[]= "Ваша конфигурация не поддерживает настройку через INI файл.\n";;
											$new_config = new_config();

											$parse_tpl['{content}'].= "<FORM NAME='saveini' ACTION='?' METHOD='post'>\n";
											$parse_tpl['{content}'].= "<TABLE class='configform'>\n";
											$parse_tpl['{content}'].="
	<col class='row1'>
	<col class='row2'>

	<tr>
		<th colspan='2'>Общие настройки</th>
	</tr>
	<tr>
		<td><h4>Отладка</h4><h5>\$debug</h5></td>
		<td><b>".(($debug)? '<font color=red>true</font>':'false')."</b><br>
		изменяется только в config.php
		</td>
	</tr>
	<tr>
		<td><b>Сайт работает</b><h5>\$config['site_work']</h5></td>
		<td>
			<input type='radio' name='site_work' value='true' ".(($config['site_work'])? 'checked=\'checked\'':'')." /> Да<br />
			<input type='radio' name='site_work' value='false' ".(($config['site_work'])? '':'checked=\'checked\'')." /> Нет</td>
	</tr>
	<tr>
		<td><h4>Временная зона</h4><h5>date_default_timezone_set()</h5></td>
		<td><b>".(date_default_timezone_get())."</b><br>
		изменяется только в config.php
		</td>
	</tr>
	<tr>
		<td><h4>Название сайта</h4><h5>\$config['site_title']</h5><h6>Имя сервера, на котором запущен фотохостинг</h6></td>
		<td><input class='post' type='text' size='25' maxlength='100' name='site_title' value='".$config['site_title']."' /></td>
	</tr>
	<tr>
		<td><h4>Имя сервера в заголовке 1</h4><h5>\$config['site_header_h1']</h5><h6>Имя сервера, отображаемое в заголовке &lt;H1&gt;</h6></td>
		<td><input class='post' type='text' size='25' maxlength='100' name='site_header_h1' value='".$config['site_header_h1']."' /></td>
	</tr>
	<tr>
		<td><h4>Имя сервера в заголовке 2</h4><h5>\$config['site_header_h1']</h5><h6>Имя сервера, отображаемое в заголовке &lt;H2&gt;</h6></td>
		<td><input class='post' type='text' size='25' maxlength='100' name='site_header_h2' value='".$config['site_header_h2']."' /></td>
	</tr>
";
										
											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Абсолютные пути (изменяется только в config.php)</th>
	</tr>
	<tr>
		<td><h5>\$config['site_dir']</h5></td>
		<td>".$config['site_dir']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['uploaddir']</h5></td>
		<td>".$config['uploaddir']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['thumbdir']</h5></td>
		<td>".$config['thumbdir']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['working_dir']</h5></td>
		<td>".$config['working_dir']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['working_thumb_dir']</h5></td>
		<td>".$config['working_thumb_dir']."<br>
		</td>
	</tr>
";
											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>URL (изменяется только в config.php)</th>
	</tr>
	<tr>
		<td><h5>\$folder</h5></td>
		<td>".$folder."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['site_url']</h5></td>
		<td>".$config['site_url']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['thumbs_url']</h5></td>
		<td>".$config['thumbs_url']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['img_url']</h5></td>
		<td>".$config['img_url']."<br>
		</td>
	</tr>
";
if (isset($config['site_http_path']))
											$parse_tpl['{content}'].="
	<tr>
		<td><h5>\$config['site_http_path']</h5></td>
		<td>".$config['site_http_path']."<br>
		</td>
	</tr>
";
											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Параметры загружаемых изображений</th>
	</tr>
	<tr>
		<td>Длинна случайного кода для изображения<h5>\$config['random_str_quantity']</h5></td>
		<td>".$config['random_str_quantity']."<br>
		</td>
	</tr>
	<tr>
		<td>Максимальный размер<h5>\$config['max_size_mb']</h5></td>
		<td><input class='post' type='numeric' name='max_size_mb' size='5' maxlength='4' value='".$config['max_size_mb']."' /> Мб</td>
	</tr>
	<tr>
		<td>Максимальная ширина<h5>\$config['max_width']</h5></td>
		<td><input type='numeric' name='max_width' value='".$config['max_width']."' maxlength='6' size='6' />&nbsp;px</td>
	</tr>
	<tr>
		<td>Максимальная высота<h5>\$config['max_height']</h5></td>
		<td><input type='numeric' name='max_height' value='".$config['max_height']."' maxlength='6' size='6' />&nbsp;px</td>
	</tr>
	<tr>
		<td>Качество при сохранении<h5>\$config['quality']</h5></td>
		<td><input type='numeric' name='quality' value='".$config['quality']."' maxlength='3' size='3' />&nbsp;&percnt;</td>
	</tr>
";	
										$parse_tpl['{content}'].="
	<tr>
		<td>Типы mimes<h5>\$config['mimes']</h5></td>
		<td>";

//http://php.net/manual/ru/function.image-type-to-mime-type.php
$image_mime_type=array('image/gif','image/jpeg','image/png','image/bmp');
		foreach ($image_mime_type as $fn)
		{ 
			if (in_array($fn,$config['mimes']))
				$sel_elem="checked='checked'";
			else
				$sel_elem="";
    	$parse_tpl['{content}'].= "<input type='checkbox' name='mimes[]' value='".$fn."' ".$sel_elem.">".$fn."<br />\n";
		}

										$parse_tpl['{content}'].="
		</td>
	</tr>
	<tr>
		<td>Расширения <h5>\$config['extensions']</h5></td>
		<td>";

$image_ext_type=array('gif','jpg','png','bmp');
		foreach ($image_ext_type as $fn)
		{ 
			if (in_array($fn,$config['extensions']))
				$sel_elem="checked='checked'";
			else
				$sel_elem="";
    	$parse_tpl['{content}'].= "<input type='checkbox' name='extensions[]' value='".$fn."' ".$sel_elem.">".$fn."<br />\n";
		}

										$parse_tpl['{content}'].="
		</td>
	</tr>
";

if (isset($config['width_resize_elements']))
	$width_resize_elements="value='".$config['width_resize_elements']."'";
else
	$width_resize_elements="readonly='readonly' disabled";

if (isset($config['height_resize_elements']))
	$height_resize_elements="value='".$config['height_resize_elements']."'";
else
	$height_resize_elements="readonly='readonly' disabled";

											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Форма загрузки</th>
	</tr>
	<tr>
		<td><b>Форма \"Уменьшить изображение\"</b><br/>(по умолчанию)<h5>\$config['auto_resize']</h5></td>
		<td>
			<input type='radio' name='auto_resize' value='1' ".(($config['auto_resize'])? 'checked=\'checked\'':'')." /> Активна<br />
			<input type='radio' name='auto_resize' value='0' ".(($config['auto_resize'])? '':'checked=\'checked\'')." /> Не активна</td>
	</tr>
	<tr>
		<td>Ширина (по умолчанию)<h5>\$config['width_resize_elements']</h5></td>
		<td><input type='numeric' name='width_resize_elements' ".$width_resize_elements." maxlength='8' size='6' />&nbsp;px</td>
	</tr>
	<tr>
		<td>Высота (по умолчанию)<h5>\$config['height_resize_elements']</h5></td>
		<td><input type='numeric' name='height_resize_elements' ".$height_resize_elements." maxlength='8' size='6' />&nbsp;px</td>
	</tr>
";

if (isset($config['width_preview_elements']))
	$width_preview_elements="value='".$config['width_preview_elements']."'";
else
	$width_preview_elements="readonly='readonly' disabled";

if (isset($config['height_preview_elements']))
	$height_preview_elements="value='".$config['height_preview_elements']."'";
else
	$height_preview_elements="readonly='readonly' disabled";

											$parse_tpl['{content}'].="
	<tr>
		<td><b>Форма \"Создать превью\"</b><br/>(по умолчанию)<h5>\$config['auto_preview']</h5></td>
		<td>
			<input type='radio' name='auto_preview' value='1' ".(($config['auto_preview'])? 'checked=\'checked\'':'')." /> Активна<br />
			<input type='radio' name='auto_preview' value='0' ".(($config['auto_preview'])? '':'checked=\'checked\'')." /> Не активна</td>
	</tr>
	<tr>
		<td>Ширина превью (по умолчанию)<h5>\$config['width_preview_elements']</h5></td>
		<td><input type='numeric' name='width_preview_elements' ".$width_preview_elements." maxlength='8' size='6' />&nbsp;px</td>
	</tr>
	<tr>
		<td>Высота превью (по умолчанию)<h5>\$config['height_preview_elements']</h5></td>
		<td><input type='numeric' name='height_preview_elements' ".$height_preview_elements." maxlength='8' size='6' />&nbsp;px</td>
	</tr>
";

											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Шаблоны</th>
	</tr>
	<tr>
		<td>Текущий шаблон<h5>\$config['template_name']</h5></td>
		<td>".$config['template_name']."<br>
		</td>
	</tr>
	<tr>
		<td>Выбор шаблона<h5>\$config['template_name']</h5></td>
		<td><select name='template_name'>
";
		$dir = opendir(dirname($config['template_path']));
		while($tpl_name = readdir($dir))
		{
		echo "<!-- $tpl_name -->\n";
			if (is_dir(dirname($config['template_path'])."/".$tpl_name) and file_exists(dirname($config['template_path'])."/".$tpl_name."/index.tpl") and $tpl_name != '.' and $tpl_name != '..')
			{
				$filename=basename($tpl_name);
				if ($config['template_name']===$tpl_name)
					$sel_elem="selected='selected'";
				else
					$sel_elem="";
    		$parse_tpl['{content}'].= "<option value='".$filename."' ".$sel_elem.">".$filename."</option>";
   		}
		}

$parse_tpl['{content}'].="
				</select>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['template_path']</h5></td>
		<td>".$config['template_path']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['template_url']</h5></td>
		<td>".$config['template_url']."<br>
		</td>
	</tr>
";
if (isset($config['font_path']))
{

											$parse_tpl['{content}'].="
	<tr>
		<td><h5>\$config['font_path']</h5></td>
		<td>".$config['font_path']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['font_prev']</h5></td>
		<td>".$config['font_prev']."<br>
		</td>
	</tr>
";

	if (!isset($config['font_prev'])) $font_prev_elements="readonly='readonly' disabled";

											$parse_tpl['{content}'].="
	<tr>
		<td>Выбор шрифта<h5>\$config['font_prev']</h5></td>
		<td><select name='font_prev' ".$font_prev_elements.">
";
//http://www.1001fonts.com
		if (isset($config['font_path']))
		foreach (glob($config['font_path']."*.{otf,ttf}",GLOB_BRACE) as $fn)
		{ 
			$filename=basename($fn);
			if ($config['font_prev']===$filename)
				$sel_elem="selected='selected'";
			else
				$sel_elem="";
    	$parse_tpl['{content}'].= "<option value='".$filename."' ".$sel_elem.">".$filename."</option>";
		}

											$parse_tpl['{content}'].="
				</select>
		</td>
	</tr>
";
}

if (isset($config['view_page']))
	{$view_page=$config['view_page'] ? 1 : 0;}
else
	$view_page=0;

if (isset($config['show_upload_date']))
	{$show_upload_date=$config['show_upload_date'] ? 1 : 0;}
else
	$show_upload_date=0;

if (isset($config['show_delete_file']))
	{$show_delete_file=$config['show_delete_file'] ? 1 : 0;}
else
	$show_delete_file=0;

											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Страницу просмотра</th>
	</tr>
	<tr>
		<td><b>Добавлять к коду изображения с превью ссылку</b> на \"Страницу просмотра\"<h5>\$config['view_page']</h5></td>
		<td>
			<input type='radio' name='view_page' value='1' ".(($view_page)? 'checked=\'checked\'':'')." /> Да<br />
			<input type='radio' name='view_page' value='0' ".(($view_page)? '':'checked=\'checked\'')." /> Нет</td>
	</tr>
	<tr>
		<td><b>Показывать дату/время</b> загрузки изображения<h5>\$config['show_upload_date']</h5></td>
		<td>
			<input type='radio' name='show_upload_date' value='1' ".(($show_upload_date)? 'checked=\'checked\'':'')." /> Да<br />
			<input type='radio' name='show_upload_date' value='0' ".(($show_upload_date)? '':'checked=\'checked\'')." /> Нет</td>
	</tr>";

/*											$parse_tpl['{content}'].="
	<tr>
		<td><b>включить и показывать \"Удаление файлов\"</b><h5>\$config['show_delete_file']</h5></td>
		<td>
			<input type='radio' name='show_delete_file' value='1' ".($show_delete_file ? 'checked=\'checked\'':'')." /> Включена<br />
			<input type='radio' name='show_delete_file' value='0' ".($show_delete_file ? '':'checked=\'checked\'')." /> Выключена</td>
	</tr>
";*/

											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Настройки cURL (изменяется только в config.php)</th>
	</tr>
	<tr>
		<td><h5>\$config['curl_timeout']</h5></td>
		<td>".$config['curl_timeout']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['curl_user_agent']</h5></td>
		<td>".$config['curl_user_agent']."<br>
		</td>
	</tr>
	<tr>
		<td><h5>\$config['curl_headers']</h5></td>
		<td>
";

//".$config['curl_headers']."<br>
	    foreach ($config['curl_headers'] as $ch) {
	        $parse_tpl['{content}'].=$ch."<br />";
	    }
											$parse_tpl['{content}'].="
		</td>
	</tr>
";

/*											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Настройки страниц</th>
	</tr>
	<tr>
		<td><h4>Язык по умолчанию</h4></td>
		<td><select name='default_lang'><option value='belarusian'>Belarusian</option><option value='russian' selected='selected'>Russian</option></select></td>
	</tr>
	<tr>
		<td>При нажатии на эскиз изображение открывается :</td>
		<td><input type='radio' name='thumbnails_mode' value='0'  /> <b>в новом окне браузера</b> (совм. со всеми брузерами)<br /><input type='radio' name='thumbnails_mode' value='1' checked='checked' /> <b>Highslide JS</b> (Javascript должен быть вкл.)</td>
	</tr>
	<tr>
		<td>Максимальные параметры эскиза</td>
		<td>Ширина <input type='numeric' name='thumbnails_width' value='150' maxlength='4' size='4' />
		&nbsp;&nbsp;Высота <input type='numeric' name='thumbnails_height' value='100' maxlength='4' size='4' /></td>
	</tr>
";*/

/*											$parse_tpl['{content}'].="
<tr>
	<th colspan='2'>Настройки e-mail</th>
</tr>
<tr>
	<td><h4>Адрес e-mail администратора</h4></td>
	<td><input class='post' type='text' size='25' maxlength='100' name='board_email' value='admin@hosting' /></td>
</tr>
<tr>
	<td><h4>Подпись в сообщениях e-mail</h4><h6>Этот текст будет подставляться во все письма, рассылаемые из форумы</h6></td>
	<td><textarea name='board_email_sig' rows='5' cols='30'>http://akina-photohost.org/
</textarea></td>
</tr>
<tr>
	<td><h4>Использовать сервер SMTP для отправки почты</h4><h6>Отметьте, если вы хотите/вынуждены отсылать почту через сервер SMTP, а не локальную почтовую службу</h6></td>
	<td><input type='radio' name='smtp_delivery' value='1' checked='checked' /> Да&nbsp;&nbsp;<input type='radio' name='smtp_delivery' value='0'  /> Нет</td>
</tr>
";
											$parse_tpl['{content}'].="
<tr>
	<td><h4>Имя пользователя для SMTP</h4><h6>Не указывайте имя пользователя если оно не требуется для работы с вашим сервером SMTP</h6></td>
	<td><input class='post' type='text' name='smtp_username' value='' size='25' maxlength='255' /></td>
</tr>
<tr>
	<td><h4>Пароль для SMTP</h4><h6>Не указывайте пароль если он не требуется для работы с вашим сервером SMTP</h6></td>
	<td><input class='post' type='password' name='smtp_password' value='' size='25' maxlength='255' /></td>
</tr>";
*/
											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Статистика загрузки изображений (изменяется только в config.php)</th>
	</tr>
	<tr>
		<td>Частота обновления статистики (в секундах)<h5>\$config['cache_time']</h5></td>
		<td>".$config['cache_time']."<br>
		</td>
	</tr>
	<tr>
		<td>Файл статистики<h5>\$config['cachefile']</h5></td>
		<td>".$config['cachefile']."<br>
		</td>
	</tr>
";
											$parse_tpl['{content}'].="
	<tr>
		<th colspan='2'>Динамические данные</th>
	</tr>
	<tr>
		<td>Год-месяц<h5>\$config['current_month']</h5></td>
		<td>".$config['current_month']."<br>
		</td>
	</tr>
	<tr>
		<td>День<h5>\$config['current_day']</h5></td>
		<td>".$config['current_day']."<br>
		</td>
	</tr>
	<tr>
		<td>Путь к изображениям<h5>\$config['current_path']</h5></td>
		<td>".$config['current_path']."<br>
		</td>
	</tr>
";
											$parse_tpl['{content}'].="
<tr>
	<td class='catBottom' colspan='2'>
	<input name='act' type='hidden' value='saveini' >
		<input type='submit' value='Сохранить' />&nbsp;&nbsp;<input type='reset' value='Вернуть' class='liteoption' />
	</td>
</tr>";
											$parse_tpl['{content}'].= "</TABLE>\n";
											$parse_tpl['{content}'].="</FORM><br>\n";

											$parse_tpl['{content}'].="<br>\n--- config begin ---<br>\n";
											$parse_tpl['{content}'].= check_array($new_config,NULL);;
											$parse_tpl['{content}'].="--- config end ---<br>\n";

										break;

			case 'sysinfo' :  //открываем только в новом окне

										server_info();
										die(); 
										break;
			case '___' :
										break;

			default :
											$parse_tpl['{content}'].="<font color=red>функция _GET не определана</font>\n";
											header( "refresh:1;url=".$_SERVER["PHP_SELF"] );
										break;
		}
	}
	else
	{
			$parse_tpl['{inner_js}'].="
        function server_info(arg){
            var w = 800;
            var h = 600;
            window.open('?act=sysinfo', 'win_serverinfo', 'width='+w+',height='+h+',fullscreen=no,scrollbars=yes,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
        }
        ";

		if (isset($_SESSION['Files'])) unset($_SESSION['Files']);

		if ((isset($debug)) && $debug)
			$error[]='Внимание! Включена отладка ($debug=<font color="blue">true</font>) - ошибки видны посторонним.';
		

		$parse_tpl['{site_header_h2}']='Akina. Основное меню.';
		$parse_tpl['{menu}'].='<li><a href="?act=setting">[Настройки]</a></li>';
		$parse_tpl['{menu}'].='<li><a href="?files=1">[Файлы]</a></li>';
		$parse_tpl['{menu}'].='<li><a href="?act=chpass">[Сменить пароль]</a></li>';
		$parse_tpl['{menu}'].='<li><a href="?act=logoff">[Выход]</a></li>';
	
		$parse_tpl['{content}']="<br>В меню:<br>\n<br>\n";
		$parse_tpl['{content}'].="<a href='?'>[Главное меню]</a> - Вы сейчас здесь ;<br><br>\n";
		$parse_tpl['{content}'].="<a href='?act=setting'>[Настройки]</a> - Настройки Фотохостинга через INI файл, также есть сравнение с предустановками по 'умолчанию' ;<br><br>\n";
		$parse_tpl['{content}'].="<a href='?files=1'>[Файлы]</a> - управление файлами изображений и каталогами Фотохостинга ;<br><br>\n";
		$parse_tpl['{content}'].="<a href='?act=chpass'>[Сменить пароль]</a> - сменить пароль доступа к Панели Управления ;<br><br>\n";
		$parse_tpl['{content}'].="<a href='#' onclick='server_info()'>[SysInfo]</a> - Информация о системе.<br><br>\n";
		$parse_tpl['{content}'].="<a href='?act=logoff'>[Выход]</a> - выход из Панели Управления.<br><br>\n";
		


	}

	
	
}
  

/////////////////// вывод страницы в шаблон ////////////////

if((isset($error)) and (is_array($error)))
	$parse_tpl['{error}']=parse_template("<div class='alert-{type}'><h4 class='alert-heading'>{title}</h4><p>{text}</p></div>", array("{type}" =>'error',"{title}" =>"Ошибка!","{text}" => implode("<br />", $error)));
else
	$parse_tpl['{error}']='';

if((isset($inform)) and (is_array($inform)) and (isset($_SESSION['ViewLog'])) )
	$parse_tpl['{inform}']=parse_template("<div class='alert-{type}'><h4 class='inform-heading'>{title}</h4><p>{text}</p></div>", array("{type}" =>'inform',"{title}" =>"Информация","{text}" => implode("<br />", $inform)));
else
	$parse_tpl['{inform}']='';

if (isset($config['site_http_path']))
	$parse_tpl['{site_http_path}']=$config['site_http_path'];
else
	$parse_tpl['{site_http_path}']=$config['site_url'];

echo parse_template($template, $parse_tpl);

?>
