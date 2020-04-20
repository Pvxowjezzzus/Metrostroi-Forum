<?php
$url = $_SERVER['REQUEST_URI'];
$url = str_replace('/profile/', '', $url);
$Login = str_replace('/', '', $url);
$title = 'Профиль '.$Login;
$Profile = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `Login` = '$Login'"));
switch ($Profile['Rank']) {
    case 1:
        $Rank = 'Главный администратор';
        break;
    case 2:
        $Rank = "Администратор";
        break;
    case 3:
        $Rank = "Модерадор";
        break;
    case 4:
        $Rank = "Пользователь";
        break;
}
$path = '/resource/avatar/';
$avatar = $path.$Profile['Avatar'].'.jpg';
?>
<section class="user-prof">
    <div class="profile-wrapper">
        <div class="profile-avatar"><img  src="<?=$avatar?>">
        </div>
        <div class="user-data">
            <h3 class="white">Данные пользователя</h3>
            <div>
                <p class="white">Логин: <?= $Profile['Login']?></p>
                <p class="white">Email: <?= $Profile['Email']?></p>
                <p class="white">Звание: <?= $Rank ?></p>
                <p class="white">Дата регистрации: <?=$Profile['RegDate'] ?></p>
            </div>
        </div>

        <div class="user-stats">
            <h3 class="white">Статистика пользователя</h3>
            <p class="white">Создал обсуждений: <?=$Profile['Posts']?> </p>
            <span class="rep">Репутация: <?= $Profile['Rep']?></span>
        </div>
    </div>
</section>