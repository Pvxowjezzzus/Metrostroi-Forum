<?php
require 'core/Model.php';
class Main extends Model
{

     function selfprofile() {
        $data = mysqli_query($this->conn->db,"SELECT `Avatar`, `RegDate`, `Posts`,`Rep` FROM `users` WHERE `ID` = '$_SESSION[USER_ID]'");
            $user = mysqli_fetch_assoc($data);
            return  $user;

    }
     function AdminPanel($type) {
        if (isset($_SESSION['USER_LOGIN_IN']) && $_SESSION['USER_RANK'] < 3) {
            if ($type == 'btn') return '<button class="tab-btn" onclick="showPanel(2)">Админ Панель</button>';
            else if ($type == 'content')
                if (isset($_SESSION['USER_LOGIN_IN']) && $_SESSION['USER_RANK'] < 3)
                    $Param = "SELECT * FROM `threads`  ORDER BY `ID` DESC";
                    $Threads = '';
                    foreach($this->conn->db->query($Param) as $Thread) {
                           $section = mysqli_fetch_assoc($this->conn->db->query("SELECT `Theme` FROM `sections` WHERE `ID` = '$Thread[Section]'"));
                    /*    if ($Thread['Active'] == 0)
                           $actions =  "<td data-label='Действия'>
                                                <p>Активация</p>                          
                                                    <button class='btn action' data-action='accept' data-tid='$Thread[ID]' title='Принять' ><span class='accept'></span></button>
                                                    <button class='btn action' data-action='remove' data-tid='$Thread[ID]' title='Удалить'><span class='remove'></span></button>
                                              </td>";
                        else
                            $actions = "<td data-label='Действия'>
                                            <button class='btn action' data-action='remove' data-tid='$Thread[ID]' title='Удалить'>
                                                <span class='remove'></span>
                                            </button></td>";*/
                           $Threads .= "<tbody>
                                            <tr>
                                               <td data-label='ID'>$Thread[ID]</td>
                                               <td data-label='Обсуждение'>$Thread[Name]</td>
                                               <td data-label='Автор'>$Thread[Author]</td>
                                               <td data-label='Дата создания'>$Thread[Date]</td>    
                                               <td data-label='Раздел'>$section[Theme]</td>"
                                               .(($Thread['Active'] == 0)? "
                                               <td data-label='Действия'>
                                                    <p>Активация</p>                          
                                                        <button class='btn action' data-action='accept' data-tid='$Thread[ID]' title='Принять' ><span class='accept'></span></button>
                                                        <button class='btn action' data-action='remove' data-tid='$Thread[ID]' title='Удалить'><span class='remove'></span></button                                                   
                                               </td>" :"
                                               <td data-label='Действия'> 
                                                    <button class='btn action' data-action='remove' data-tid='$Thread[ID]' title='Удалить'>
                                                        <span class='remove'></span>
                                                    </button>
                                            </td>").
                                            "</tr>
                                        </tbody>";}

                    $ThreadRoot = "<div class='TabPanel'>
                            <h2 class='white twenty'>Панель Администратора</h2>
                                <h3 class='white regular'>Обсуждения</h3>                          
                                <table class='table threads-root'>                   
                                    <thead>
                                        <tr>
                                           <th>ID</th>
                                           <th>Обсуждение</th>
                                           <th>Автор</th>
                                           <th>Дата создания</th>
                                           <th>Раздел</th>
                                           <th>Действия</th>
                                        </tr>
                                    </thead>".$Threads.
                                "</table>";

                    $Param = "SELECT * FROM `users`  ORDER BY `ID` ASC";
                    $Users = '';
                    foreach($this->conn->db->query($Param) as $User) {
                        $Users .= "<tbody>
                                    <tr>
                                         <td data-label='ID'>$User[ID]</td>
                                         <td data-label='Логин'>$User[Login]</td>
                                         <td data-label='Email'>$User[Email]</td>
                                         <td data-label='Дата регистрации'>$User[RegDate]</td>
                                         <td data-label='Ранг'>$User[Rank]</td>
                                         <td data-label='Обсуждения'>$User[Posts]</td>
                                         <td data-label='Репутация'>$User[Rep]</td>
                                         <td>
                                            <form class='rank-switch' method='post' data-uid='$User[ID]'>
                                                <select name='rank'>
                                                    <optgroup  class='blue' label='Ранги'>
                                                        <option>---------</option>
                                                        <option value='4' class='blue'>Пользователь</option>
                                                        <option value='3' class='blue' >Модератор</option>
                                                        <option value='2' class='blue'>Администратор</option>
                                                    </optgroup>
                                                </select>
                                            <button type='submit' class='btn'>ОК</button>
                                            </form>
                                         </td>
                                    </tr>
                                </tbody>";}

                    $UserRoot = "
                            <h3 class='white regular'>Пользователи</h3>
                                <table class='table users-root'>
                                    <thead>
                                        <tr>
                                           <th>ID</th>
                                           <th>Логин</th>
                                           <th>Email</th>
                                           <th>Дата регистрации</th>
                                           <th>Ранг</th>
                                           <th>Обсуждения</th>
                                           <th>Репутация</th>
                                           <th>Повышение</th>
                                        </tr>
                                    </thead>".$Users.
                                "</table>
                              </div>";

                        return "$ThreadRoot.$UserRoot";
                    }
     }

}
?>