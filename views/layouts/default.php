<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resource/css/main.css">
    <link rel="stylesheet" href="/lib/slick-slider/slick.css">
    <title><?=$title?></title>
</head>
<body>
<?= head();?>
<div class="enter_modal signup_modal" id="modal">
    <div class="enter_content">
        <div class="form">
            <div class="modal_header">
                <button class="close-modal btn">&times;</button>
                <h2 class="white seventeen-fifth bold\">Регистрация</h2>
                <p class="fifteen light white">Добро Пожаловать в Metrostroi Forum</p>
            </div>
            <form id="signup" class="signup" method="post">
                <input type="login" placeholder="Логин"  id="login" class="input" >
                <input type="email" placeholder="Email"  id="email" class="input">
                <input type="password" placeholder="Пароль" id="passwd" class="input">
                <input type="password" placeholder="Пароль x2" id="passwd2" class="input">
                <div class="captcha">
                    <p class="white light fifteen">Проверка безопасности</p>
                    <input class='captcha-input' id='captcha' type='text' placeholder='<?= captcha() ?>'>
                    <input id="quest" type="hidden">
                </div>
                <input type="submit"  class="verify-signup" name="enter-signup" value="Зарегистрироваться">
            </form>
        </div>
    </div>
</div>
<div class="enter_modal auth_modal" id="modal">
    <div class="enter_content">
        <div class="form">
            <button class="close-modal btn">&times;</button>
            <div class="modal_header">

                <h2 class="white seventeen-fifth bold">Авторизация</h2>
                <p class="fifteen light white">Добро Пожаловать в Metrostroi Forum</p>
            </div>
            <form id="auth" class="auth" method="post">
                <input type="text" placeholder="Логин"  class="input" autocomplete="off" id="auth_login">
                <input type="password" placeholder="Пароль"  class="input" id="auth_passwd">
                <div class="captcha">
                    <p class="white light fifteen">Проверка безопасности</p>
                    <input class='captcha-input' id='auth_captcha' type='text' placeholder='<?= captcha() ?>'>
                    <input id="auth_quest" type="hidden">
                </div>
                    <input type="submit" class="verify-auth" name="enter-auth" value='Авторизоваться'>
            </form>
        </div>
    </div>
</div>
<?=$content; ?>
<?= prefooter();?>
<?=footer();?>
</body>
<script src="/resource/js/jquery-3.4.1.min.js"></script>
<script src="/resource/js/main.js"></script>
<script src="/resource/js/modal.js"></script>
<script src="/resource/js/guest.js"></script>
<script src="/resource/js/animate.js"></script>
<script src="/lib/slick-slider/slick.min.js"></script>
</html>
