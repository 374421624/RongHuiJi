<html>

<?PHP
require_once("config.php");

$sql = "select id,name from user limit 10";
$rs = $mysql->query($sql);
while($r = $rs->fetch_array()){
    echo $r[0]." ".$r["name"]."<br>\n";
}


$sql = "select id,name from user where id=0";
$rs = $mysql->query($sql);
if ($r = $rs->fetch_array()){
  echo "";
} else {
  echo "nodata";
}
?>

</html>
