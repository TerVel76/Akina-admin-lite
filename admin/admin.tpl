<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{site_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{site_http_path}engine.css" media="screen" />
<link rel="stylesheet" type="text/css" href="{site_http_path}admin/style.css" media="screen" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="{site_http_path}js/main.js" type="text/javascript"></script>
<script language=javascript>
{inner_js}
</script>
</head>
<body>

<div id="wrap">

<div id="header">
	<h1><a href="{site_http_path}">{site_header_h1}</a></h1>
	<h2>{site_header_h2}</h2> 
</div>

<div id="menu">
	<ul>
	{menu}
	</ul>
</div>

<div id="content">
<br/>
	{error}{inform}{content}
</div>



</div>

<div id="footer">
Powered by <a href="http://akina-photohost.org">Akina</a> &copy; 2015<br>Coding TerVel </div>
</div>
</body>
</html>