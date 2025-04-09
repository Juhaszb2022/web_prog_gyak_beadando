<?php
include('confing.inc.php');
$keres = current($oldalak);
if(isset($_GET['oldal'])){
    if (isset($oldalak[$_GET['oldal']]&& file_exists("./page/{$oldalak[$_GET['oldal']]['fajl'].tpl.php}")))  {
        $keres = $oldalak[$_GET['oldal']];
    }
    else{
        $keres = $notfound;
        header("HTTP/1.0 404 Not Found");
    }
}
include('./page/index.tpl.php')
?>