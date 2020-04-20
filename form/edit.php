<?php
session_start();
require '../lib/Db.php';
$db = new Db();
$connect = $db->connect;

if (isset($_POST['edit_form'])) {

    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    if(empty($login || $email)) {
        echo 'Нечего изменять';
    }
        else {
            $User = mysqli_num_rows(mysqli_query($connect, "SELECT `ID` FROM `users` WHERE `Login` = '$login'"));
            if ($login != $_SESSION['USER_LOGIN'] && empty($User)) {
                if (strlen($login) < 6 || strlen($login) > 25) {
                    echo 'Неверная форма логина (от 6 до 25 символов)';
                } else {
                    mysqli_query($connect, "UPDATE `users` SET `Login` = '$login' WHERE `ID` = '" . $_SESSION['USER_ID'] . "'");
                    mysqli_query($connect, "UPDATE `sections` SET `Creator` = '$login' WHERE `Creator` = '" . $_SESSION['USER_LOGIN'] . "'");
                    mysqli_query($connect, "UPDATE `threads` SET `Author` = '$login' WHERE `Author` = '" . $_SESSION['USER_LOGIN'] . "'");
                    mysqli_query($connect, "UPDATE `answers` SET `Login` = '$login' WHERE `Login` = '" . $_SESSION['USER_LOGIN'] . "'");
                    echo "Успешное изменение";
                    $_SESSION['USER_LOGIN'] = $login;
                }
            } else echo 'Данный логин уже используется';
        }
        if ($_POST['email'] != $_SESSION['USER_EMAIL'] && !empty($_POST['email'])) {
            echo 'Изменения сохранены';
        }
}
else if ($_POST['avatar']) {
$avatar =  $_POST['avatar'];
$file = '../resource/avatar/'.$_SESSION['USER_ID'].'.jpg';
$ava_arr_1 = explode(';', $avatar);
$ava_arr_2 = explode(',', $ava_arr_1[1]);
$avatar = base64_decode($ava_arr_2[1]);
file_put_contents($file, $avatar);
mysqli_query($connect, "UPDATE `users` SET `Avatar` = '$_SESSION[USER_ID]' WHERE `ID` = '$_SESSION[USER_ID]'");
}
/*  $path = 'F:\Programms\xampp\htdocs\resource\avatar/';

$types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
if (!in_array($_FILES['avatar']['type'], $types)) {
echo 'Запрещенный тип файла!';
} */

?>