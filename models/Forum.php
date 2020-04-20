<?php
require 'core/Model.php';

class Forum extends Model
{
    public $url;
    public $Row;
    public $thread;
    function url() {
        $url = $_SERVER['REQUEST_URI'];
        $url = preg_replace('~\D+~','', $url);
        $this->url = $url;
    }
    function thread() {
        $Thread = mysqli_fetch_assoc($this->conn->db->query( "SELECT * FROM `threads` WHERE `ID` = '$this->url'"));
        return $Thread;

    }
    function rank() {
        $Author = $this->thread()['Author'];
        $User = mysqli_fetch_assoc($this->conn->db->query( "SELECT `Rank` FROM `users` WHERE `Login` = '$Author'"));
        switch ($User['Rank']) {
            case 1:
                $Rank = 'батя';
                break;
            case 2:
                 $Rank = "админ";
                break;
            case 3:
                 $Rank = "модер";
                break;
            case 4:
                 $Rank = "юзер";
                break;
        }
        return $Rank;

    }

    function topsections($cat) {
           return "SELECT  * FROM `sections` WHERE `Category` = $cat ORDER BY `ID`  DESC LIMIT 4";
    }

    function createbtn() {
        if(isset($_SESSION['USER_LOGIN_IN']) && $_SESSION['USER_RANK'] <= 2) {
            return "<span id='error' class='white light'></span>
                    <button class=\"create-sect\" id=\"create_sect\">Создать Раздел</button>";
        }
    }
    function validsection() {
        $this->url();
        $Row = mysqli_fetch_assoc($this->conn->db->query( "SELECT * FROM `sections` WHERE `ID` = '$this->url'"));
        $this->Row = $Row;
        if ($Row['ID'] != $this->url) {
            exit(header('Location: /discussions'));
        }
        return $Row['Theme'];
    }
    function sections($cat)
    {
        $Param = "SELECT * FROM `sections` WHERE `Category` = $cat ORDER BY `ID` DESC LIMIT 0, 5 ";
        foreach ($this->conn->db->query($Param) as $Row)
            $thread = mysqli_fetch_assoc($this->conn->db->query("SELECT COUNT(`ID`) as count FROM `threads` WHERE `Section` = $Row[ID]"));
            if (strlen($Row['Creator']) > 10)
                $Creator = substr("$Row[Creator]", 0, 10) . '...';
            else {$Creator = $Row['Creator'];}
            $user = mysqli_fetch_assoc($this->conn->db->query("SELECT `Avatar` FROM `users` WHERE `Login` = '$Row[Creator]'"));
            $del = "<form action='/form/handler.php' method='POST'>
                                  <input type='hidden' value='$Row[ID]' name='ID'>
                                  <input class='remove-btn' name='remove-sect' value='del' title='Удалить'  type='submit'>                         
                              </form>
                           </a>";
            $sectinfo = "<ul class='section-info'>
                                <li class='fifteen blue light'>Админ раздела:".
                                 ((isset($_SESSION['USER_LOGIN_IN']) && $_SESSION['USER_LOGIN'] == $Row['Creator']) ? "
                                        <a class='fifteen blue regular user-link' href='/profile' class='seventeen blue light user-link'>
                                            <img class='section-avatar' src='/resource/avatar/$user[Avatar].jpg'> Вы" :
                                        "<a class='fifteen blue regular user-link' href='/profile/$Creator' class='seventeen blue light user-link'>
                                            <img class='section-avatar' src='/resource/avatar/$user[Avatar].jpg'> $Creator").
                                        "</a>
                                </li>
                                <li class='fifteen blue light'>$thread[count] Обсуждений</li>
                            </ul>";
            $section = "<div class=\"section-theme\">
                        <a href='/discussions/section/$Row[ID]' class='section-link' >
                        <img src='/resource/img/sect-theme.png'>
                        <h3 class=\"section-name seventeen blue regular\">$Row[Theme]</h3>"
            .((isset($_SESSION['USER_LOGIN_IN']) && $_SESSION['USER_RANK'] < 2) ? "$del" : "</a>").$sectinfo.
            "</div>";
        if (mysqli_num_rows($this->conn->db->query($Param)) <= 0)
            $section = "<p class='white light'>Нет разделов</p>";
                return "$section";
        }

    function path($loc) {
        if($loc == 'section') {
            $Param = "SELECT * FROM `sections` WHERE `ID` = '$this->url'";
            $query = $this->conn->db->query($Param);
        }
        else if ($loc == 'thread') {
            $Thread = mysqli_fetch_assoc($this->conn->db->query("SELECT `Name`, `Section` FROM `threads` WHERE `ID` = '$this->url'"));
            $Param = "SELECT * FROM `sections` WHERE `ID` = '$Thread[Section]'";
            $query = $this->conn->db->query($Param);
        }
        return $query;
    }

    function createthread() {
        if(isset($_SESSION['USER_LOGIN_IN']))
            return "<button class='create-btn' onclick='thread_create()'>Создать обсуждение</button>";
    }
    function threads() {
        $Row = mysqli_fetch_assoc($this->conn->db->query( "SELECT * FROM `sections` WHERE `ID` = '$this->url'"));
        $Param = "SELECT * FROM `threads` WHERE `Section` = '$Row[ID]' AND `Active` = 1 ORDER BY `ID` DESC";
        $Rank = $this->rank();
        foreach($this->conn->db->query($Param) as $Thread)
        $this->thread = $Thread['ID'];
        $Threads =  "                    
                     <a class='thread'>                                          
                      <form action='/form/handler.php' method='POST'>  
                          <input type='hidden' value='$Thread[ID]' name='id'>          
                          <input type='submit' value='1' class='submit-thread' name='submit-thread'>                                  
                     </form>
                        <div class='rank'><span class='white regular'>$Rank</span></div>                       
                        <div>                            
                            <p class=\"seventeen blue forum-name\">$Thread[Name]</p>    
                            <p class=\"seventeen blue light\">Автор темы: $Thread[Author]</p>
                            <p class=\"seventeen blue light\">Создано: $Thread[Date]</p>                       
                        </div>    
                         
                        <div class='counters'>
                            <div class='msg-counter blue'>$Thread[AnswerCount]
                            <p class='fifteen light'>Ответов</p>
                        </div>
                       
                         <div class='msg-counter blue'>$Thread[ViewCount]
                             <p class='fifteen light'>Просмотров</p>
                        </div>  
                        </div>                             
                        </a>";

    if (mysqli_num_rows($this->conn->db->query($Param)) <= 0)
        $Threads = '<p class="white seventeen regular">Нет обсуждений</p>';
    return $Threads;
    }
    function quill() {
        if (isset($_SESSION["USER_LOGIN_IN"]))
            return '<script src="/lib/quill-image-resize-module/image-resize.min.js"></script>
                    <script src="/resource/js/quill.js" type="module"></script>';
    }

    function validthread() {
        $this->url();
        $Thread = mysqli_fetch_assoc($this->conn->db->query( "SELECT * FROM `threads` WHERE `ID` = '$this->url'"));
        $section =  mysqli_fetch_assoc($this->conn->db->query( "SELECT `Theme`, `Category` FROM `sections` WHERE `ID` = '$Thread[Section]'"));
        if (isset($_SESSION['SORT'])) {
            $sort = $_SESSION['SORT'];
        }
        else {
            $sort = 'Date ASC';
        }
        if ($this->url != $Thread['ID'])
            header('Location: /discussions');
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            $this->conn->db->query("UPDATE `threads` SET `ViewCount` = `ViewCount` + 1 WHERE `ID` = '$Thread[ID]'");
        }
        return $Thread['Name'];
    }
    function removethread() {
        $Thread = mysqli_fetch_assoc($this->conn->db->query("SELECT * FROM `threads` WHERE `ID` = '$this->url'"));
        if (isset($_SESSION['USER_LOGIN_IN']) && $_SESSION['USER_RANK'] <= 2 || $_SESSION['USER_LOGIN'] == $Thread['Author'])
                    return "
                            <form action='/form/handler.php' method='POST'>                              
                                <input type=\"hidden\" value=\"$this->url\" name=\"ID\">
                                <input type=\"hidden\" value=\"$Thread[Section]\" name=\"section\">                           
                                <input class='remove-thread' name='remove-thread' value='Удалить тему' type='submit'>
                            </form>                           
                            </a>";
    }
    function threadbar() {
        return $this->conn->db->query( "SELECT * FROM `threads` WHERE `ID` = '$this->url'");
    }
}
?>
