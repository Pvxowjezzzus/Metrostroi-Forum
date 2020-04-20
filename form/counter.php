<?php
$connect = mysqli_connect('localhost', 'root', '', 'metrostroi-forum');
$uid = intval($_POST['uid']);
$aid = intval($_POST['aid']);
$user = $_POST['authorid'];
$query = "SELECT `ID` FROM `likes` WHERE `UID` = '$uid' and `AID` = '$aid' ";
$a = mysqli_query($connect,$query);
$check = mysqli_fetch_assoc($a);

    if(empty($check['ID'])) {
        $like = mysqli_query($connect, "UPDATE `answers` SET `Thumbup` = `Thumbup`+  1  WHERE `ID` = '$aid'");
        mysqli_query($connect, "INSERT INTO `likes` (`AID`, `UID`) VALUES ($aid, $uid)");
        mysqli_query($connect,"UPDATE `users` SET `Rep` = `Rep` + 1 WHERE `Login` = '$user'");
    }
    else {
        $connect->query("DELETE FROM `likes` WHERE `AID` = '$aid' and `UID` = '$uid'");
        $like = mysqli_query($connect, "UPDATE `answers` SET `Thumbup` = `Thumbup` - 1  WHERE `ID` = '$aid'");
        mysqli_query($connect,"UPDATE `users` SET `Rep` = `Rep` - 1 WHERE `Login` = '$user'");
    }



?>