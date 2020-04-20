<?php
session_start();
error_reporting(0);
require '../lib/Db.php';
$db = new Db();
$connect = $db->db;
$type = strval($_POST['type']);
$date = date("Y-m-d H:i:s");


if (isset($_POST['sect'])) {
    $theme = $_POST['theme'];
    $creator = $_SESSION['USER_LOGIN'];
    $cat = $_POST['cat'];
    $date = date( 'd-m-Y H:i');
    if (mysqli_num_rows(mysqli_query($connect, "SELECT 'ID' FROM `sections` WHERE `Theme` = '$theme'")))
        echo 'Раздел уже существует';

     else {
        mysqli_query($connect, "INSERT INTO `sections` (`Theme`, `Creator`, `Category`)
    VALUES('$theme', '$creator', '$cat')");
    }
}
else if (($_POST['remove-sect'])) {
    $Thread = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID` FROM `threads` WHERE `Section` = '".$_POST['ID']."'"));
    mysqli_query($connect, "DELETE FROM `threads` WHERE `Section` = '".$_POST['ID']."'");
    mysqli_query($connect, "DELETE FROM `sections` WHERE `ID` = '".$_POST['ID']."'");
    mysqli_query($connect, "DELETE FROM `answers` WHERE `ThreadID` = '".$Thread['ID']."'");
    header('Location: /discussions');
}
else if (($_POST['remove-thread'])) {
    mysqli_query($connect, "DELETE FROM `threads` WHERE `ID` = '".$_POST['ID']."'");
    mysqli_query($connect, "DELETE FROM `answers` WHERE `ThreadID` = '".$_POST['ID']."'");
    header('Location: http://localhost/discussions/section/'.$_POST['section'].'');
    mysqli_query($connect,"UPDATE `users` SET `Posts` = `Posts` - 1 WHERE `Login` = '".$_SESSION['USER_LOGIN']."'");
}


else if ($_POST['create_thread']) {
    header('Content-Type: application/json');
    $text = strip_tags($_POST['answer']);

    if (empty($_POST['theme']) || empty($text)) {
       $error =  'Поля не заполнены';
    }

    else if (mysqli_num_rows(mysqli_query($connect, "SELECT `ID` FROM `threads` WHERE `Name` = '".$_POST['forum']."' "))) {
        $error =  'Такое обсуждение уже существует';
    }
    else if (strlen($_POST['theme']) < 15 || strlen($_POST['theme']) > 150) {
        $error =  "Название обсуждения не валидно (от 15 до 100 символов)";
    }
    else if (strlen($text) < 10) {
        $error =  'Длина ответа должна быть не менее 10 символов';
    }
    else {
        $active = 1;
        $rank = $_SESSION['USER_RANK'];
        if ($rank > 2)
            $active = 0;
        $answer = $_POST['answer'];
        $section = mysqli_query($connect, "SELECT `Category` `ID` FROM `sections`");
        mysqli_query($connect, "UPDATE `users` SET `Posts` = `Posts` + 1 WHERE `Login` = '" . $_SESSION['USER_LOGIN'] . "'");
        $query ="INSERT INTO `threads` (`Name`, `Author`, `Date`, `Section`, `Active`) VALUES('" . $_POST['theme'] . "', '" . $_SESSION['USER_LOGIN'] . "', '$date', '" . $_POST['section'] . "', $active)";
        mysqli_query($connect, $query);
        $tid =  mysqli_insert_id($connect);
        $date = date('d-m-Y H:i');
        mysqli_query($connect, "INSERT INTO `answers`(`Login`, `Text`, `ThreadID`, `Date`) VALUES ('$_SESSION[USER_LOGIN]','$answer', $tid, '$date')");

        if ($rank > 2) {
            $success =  'Обсуждение создано и отправлено на модерацию';
         }
        else
            $success =  'Обсуждение создано';

    }
    $result = array(
        'success'  => "$success",
        'error' => "$error",
        'tid' => "$tid",
    );

    echo json_encode($result);
}


else if ($_POST['submit-thread']) { //forum redirect
    header("Location: /discussions/thread/$_POST[id]/");
}
else if ($type == 'bystart') {
   $_SESSION['SORT'] =  "Date ASC";
}
else if ($type == 'bylast') {
    $_SESSION['SORT'] = "Date DESC";
}
else if ($type == 'bypop') {
    $_SESSION['SORT'] = "Thumbup DESC";
}


else if ($_POST['answer']) {
    preg_match_all('/<img[^>]+src="?([^"\']+)?[^>]*>/i', "$_POST[answer]", $images, PREG_SET_ORDER);
    $img = [];

    foreach ( $images as $p) {
        $img[] = stristr($p[1], '/resource', false);
    }

    $img = join( "\n", $img);
    $string =  strip_tags($_POST['answer']);
    if (empty($string) && empty($images))
        echo "Поле пусто";

    else {
        $answer = $_POST['answer'];
        $tid = $_POST['tid'];
        $date = date('d-m-Y H:i');
        mysqli_query($connect, "INSERT INTO `answers`(`Login`,`Text`, `ThreadID`, `Date`, `Files`) VALUES ('$_SESSION[USER_LOGIN]','$answer', '$tid', '$date', '$img')");
    }
}


else if (isset($_FILES['picture'])) {
    $types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
    if (!in_array($_FILES['picture']['type'], $types)) {
        echo 'Запрещенный тип файла!';
    }

    else {
        $path = 'F:\Programms\xampp\htdocs\resource\pics/';
        static $randStr = '0123456789abcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for ($i = 0; $i < 10; $i++) {
            $key = rand(0, strlen($randStr) - 1);
            $rand .= $randStr[$key];
        }
     
        $file = $rand.".jpg";
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], "$path$file")) {
            echo 'ошибка';

        } else
            $size = GetImageSize("$path$file");
            if ($size[0] > 1000) {
                include('F:\Programms\xampp\htdocs\lib\Images.php');
                $image = new images();
                $image->load("$path$file");
                $image->resizeToWidth(1000);
                $image->save("$path$file");
            }
            echo $file;
    }

}
else if (isset($_POST['answid'])) {
    $AnswerID = $_POST['answid'];
    $res = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `Files`, `ThreadID` FROM `answers` WHERE `ID` = '$AnswerID'"));
    $files = $res['Files'];
    $arr = explode("\n", $files);
    for ($i = 0; $i < count($arr); $i++) {
        unlink("..{$arr[$i]}");
    }
    mysqli_query($connect,"DELETE FROM `answers` WHERE `ID` = '$AnswerID'");
    mysqli_query($connect, "UPDATE `threads` SET `AnswerCount` = `AnswerCount`-1 WHERE `ID` = $res[ThreadID] ");
}
else if ($_POST['chatanswer']) {
    $answer = $_POST['chatanswer'];
    $date = date('d-m-Y H:i');
    $login = $_POST['login'];
    mysqli_query($connect, "INSERT INTO `chat`(`Login`,`Text`, `Date`) VALUES ('$login','$answer', '$date')");
}
else if (isset($_POST['query'])) {
    $req = $_POST['query'];
    $req = trim($req);
    $req = strip_tags($req);
    if(!empty($req)) {
        $query = mysqli_query($connect, "SELECT `Name`, `ID` FROM `threads` WHERE  `Name` LIKE '%$req%' AND `Active` = 1");
        $count = mysqli_num_rows($query);
        if ($count > 0) {
            echo "<p class='white'>Результат:</p>";
            while ($res = mysqli_fetch_assoc($query)) {
                echo "<a href='/discussions/thread/$res[ID]'><p class='blue light search-res'>$res[Name]</p></a>";
            }
        }
        else {
            echo "<p class='white'>Результатов нет</p>";
        }
    }
}
?>