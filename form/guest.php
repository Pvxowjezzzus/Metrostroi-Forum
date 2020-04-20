<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'metrostroi-forum');
$errors = array();
$date = date("Y-m-d H:i:s");
$options = array (
    'salt'=> '$2y$10$SW2pEdKOuxE3P2Ef7/yvsOFMQUbxS5XjQ2qg2sgYhtu49I4PJ.AX6',
);

function match_empty() {
    if (empty($_POST['login']) || empty($_POST['email']) || empty($_POST['passwd']) || empty($_POST['passwd2'])) {
        $errors[] = 'Не заполнены все поля';
        echo "Не заполнены все поля\n";
    }

}
function email_valid() {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email указан неверно';
        echo "Email указан неверно \n";
    }

}
function captcha_valid($captcha)
    {
        $answers = array(
            1 => '750',
            2 => '81-717',
            3 => 'АРС',
            4 => '7',
        );

        if (!array_search($captcha, $answers)) {
            echo "Капча не пройдена\n";
        }
        else {
            echo '1';
        }

}
if ((isset($_POST['signup']))) {
    match_empty();
    email_valid();
    if (strlen($_POST['login']) < 6 || strlen($_POST['login']) > 25) {
        echo "Неверная форма логина (от 6 до 25 символов) \n";
        $errors[] = 'Неверная форма логина (от 6 до 25 символов)';
    }
    if ($_POST['passwd2'] != $_POST['passwd']) {
        $errors[] = 'Повторный пароль указан неверно';
        echo "Повторный пароль указан неверно\n";
    }
    if (!preg_match('/^[A-z0-9]{8,30}$/', $_POST['passwd'])) {
        $errors[] = ' Неверная форма пароля (от 8 до 30 символов)';
        echo "Неверная форма пароля (от 6 до 30 символов) \n";
    }
    else if (empty($errors)) {
        $answers = array(
            1 => '750',
            2 => '81-717',
            3 => 'АРС',
            4 => '7',
        );

        if (!array_search($_POST['captcha'], $answers)) {
            echo "Капча не пройдена\n";
        } else {
            $login = trim($_POST['login']);
            $email = trim($_POST['email']);
            $Rank = 4;
            $avatar = 'raw';
            $passwd = password_hash($_POST['passwd'], PASSWORD_DEFAULT, $options);
            if (mysqli_num_rows(mysqli_query($connect, "SELECT `ID` FROM `users` WHERE `Email` = '$email' "))) {
                echo "Данный Email уже используется \n";
            } else if (mysqli_num_rows(mysqli_query($connect, "SELECT `ID` FROM `users` WHERE `login` = '$login' "))) {
                echo "Данный Логин уже используется";
            } else {
                $connect->query("INSERT INTO `users` (`Login`,`Email`, `Password`, `Rank`, `RegDate`, `Avatar`)
                VALUES('$login','$email', '$passwd', '$Rank', '$date', '$avatar')");
                $connect->close();
                echo "Вы успешно зарегистрированы";

            }
        }
    }
}

else if (isset($_POST['auth'])) {
    $login = $_POST['auth_login'];
    if (!empty($_POST['auth_passwd']))
        $passwd = password_hash($_POST['auth_passwd'], PASSWORD_DEFAULT, $options);
    else
        $passwd = $_POST['auth_passwd'];
    $str = '{"action":"auth", "login":"'.$login.'", "passwd":"'.$passwd.'"}';
    $json = json_decode($str, false);
    switch ($json->action) {
        case "auth":
            if (empty($login) || empty($_POST['auth_passwd']))
                echo 'Не заполнены все поля';

            else

                if (!mysqli_num_rows(mysqli_query($connect, "SELECT `ID` FROM `users` WHERE `Login` = '$login' AND `Password` = '$passwd'"))) {
                    echo "Пользователь не найден \n";
                } else {

                    if (empty($errors)) {
                        $answers = array(
                            1 => '750',
                            2 => '81-717',
                            3 => 'АРС',
                            4 => '7',
                        );

                        if (!array_search($_POST['auth_captcha'], $answers))
                            echo "Капча не пройдена\n";
                        else
                            echo "Успех";
                        $_SESSION['USER_LOGIN_IN'] = 1;
                        $data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'"));
                        $_SESSION['USER_ID'] = $data['ID'];
                        $_SESSION['USER_LOGIN'] = $data['Login'];
                        $_SESSION['USER_EMAIL'] = $data['Email'];
                        $_SESSION['USER_RANK'] = $data['Rank'];
                        $_SESSION['USER_AVATAR'] = $data['Avatar'];
                    }
                }
    }
}

?>