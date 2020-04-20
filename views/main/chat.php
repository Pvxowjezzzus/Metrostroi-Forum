<?php
session_start();
require 'lib/Db.php';
$db = new Db();
$connect = $db->connect;
?>
<section>
    <header class="chat-header">
        <h3 class="white twenty-fifth ">Глобальный чат</h3>
    </header>

    <div class="chat-output" id="chat">
        <input id="nick" type="hidden" value="<?=$_SESSION['USER_LOGIN'] ?>">
<?php
    $Param = "SELECT * FROM `chat`";
    $Query = mysqli_query($connect, $Param);
    $count = mysqli_num_rows($Query);
    if ($count > 0) {
        while ($chat = mysqli_fetch_assoc($Query)) {
            echo "
                <div class='white light chat-answ'>
                <p class='regular'>$chat[Login]</p>
                $chat[Text]
                </div> 
            ";
        }
    }
?>
    </div>
    <div class="chat-answer">
            <img class='answer-avatar' src='/resource/avatar/<?=$_SESSION['USER_AVATAR']?>.jpg'>
                <div class='answer-area'>
                    <div id='chat-answer'></div>
                </div>
            <button id='send-answer' class="stock-btn btn">Ответить</button>
    </div>
</section>
<?php
if (isset($_SESSION["USER_LOGIN_IN"])) {
    echo '
    <script src="/resource/js/websocket.js" type="module"></script>';
}
?>