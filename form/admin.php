<?php
require '../lib/Db.php';
$db = new Db();


if(isset($_POST['action']) && $_POST['action']== 'accept') {
    $tid = $_POST['tid'];
    $db->db->query("UPDATE `threads` SET `Active` = 1 WHERE `ID` = $tid");
}
if(isset($_POST['action']) && $_POST['action'] == 'remove') {
    $tid = $_POST['tid'];
    $db->db->query("DELETE FROM `threads` WHERE `ID` = $tid");
}
else if (isset($_POST['rank'])) {
    $rank = $_POST['rank'];
    $uid = $_POST['uid'];
    $db->db->query("UPDATE `users` SET `Rank` = $rank WHERE `ID` = $uid");
}
?>