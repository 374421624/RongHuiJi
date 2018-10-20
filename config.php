<?PHP
	header("Content-type: text/html; charset=utf8");
  $mysql_host = "127.0.0.1";
  $mysql_user = "root";
  $mysql_passwd = "root";
  $mysql_db = "test";

  $mysql = new mysqli($mysql_host, $mysql_user, $mysql_passwd, $mysql_db);
  $base_url = "http://47.93.250.19:8081";
  $search_url = "http://47.93.250.19";
?>
