<?PHP
  // Author: ruc_skl@163.com (Kunlong She)
  // Created Time:2018-08-20 11:29:24
function RequestInt($str, $default = 0) {
  if (isset($_REQUEST[$str])) {
    return intval($_REQUEST[$str]);
  } else {
    return $default;
  }
}

function Request($str) {
  if (isset($_REQUEST[$str])) {
    $rst = str_replace("'", "''", $_REQUEST[$str]);
    $rst = str_replace("\\", "\\\\", $rst);
    return $rst;
  } else {
    return "";
  }
}

function Str($str) {
  if (empty($str)) {
    return "";
  } else {
    return $str;
  }
}
?>
