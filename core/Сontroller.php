<?php
require 'core/View.php';
require 'lib/Images.php';

abstract class Controller
{
    public $route;
    public $view;

    public function loadModel($name)
    {
        $nameModel = ucfirst($name);
        $pathModel = 'models/'.$nameModel.'.php';

        if (file_exists($pathModel))
        {
            include_once $pathModel;

            if (class_exists($nameModel))
            {
                return new $nameModel();
            }
            else
                echo "Не удалось загрузить класс модели: ".$nameModel;
        } else
            echo "Не удалось найти файл модели: ".$pathModel;

    }

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);


        function captcha()
        {
            $questions = array(
                1 => 'Напряжение контактного рельса',
                2 => 'Заводское название номерного',
                3 => 'АЛС-...',
                4 => 'Количество положений 013 крана'
            );

            $num = mt_rand(1, count($questions));
            echo $questions[$num];

        }

        function head()
        {
            if (strlen("$_SESSION[USER_LOGIN]",) > 15)
                $login = substr("$_SESSION[USER_LOGIN]", 0, 15) . '...';

            else $login = $_SESSION['USER_LOGIN'];
            if ($_SESSION['USER_LOGIN_IN'] == 1) {
                $Menu = "
        <li class=\"menu_item-li\"><a href=\"/chat\"><i class=\"menu_item\" aria-hidden=\"true\"></i>Чат</a></li>
        <li class=\"menu_item-li\">
            <button class='search-btn' id='search-btn'></button>
        </li>
        <ul class='last'>
           
            <li class=\"menu_item-li last\"'>
                <a href=\"/profile/\">
                 <img class='mini-avatar' src='/resource/avatar/$_SESSION[USER_AVATAR].jpg'>
                 $login
                </a>
              <ul class=\"prof-drop\">            
                   <li class=\"prof-item\">
                       <form  method=\"post\" action=\"/form/logout.php\">
                            <input class='btn stock-btn' name=\"logout\" type=\"submit\" value=\"выйти\">
                       </form>
                   </li>
              </ul>
              </li>
         </ul>  
        <a href='drop' class='prof-btn'>
         <span></span></a>";
            } else $Menu = '
            <li class="menu_item-li">
                <button class=\'search-btn\' id=\'search-btn\'></button>
            </li>
            <li class="menu_item-li last"><button class=\'auth_btn white seventeen\' id="auth-btn">Вход</button>
            <button class=\'signup_btn white seventeen\' id="signup-btn">Регистрация</button>';

            echo "<header class=\"nav_menu\">
    <ul class=\"menu\">
   
        <li class=\"menu_item-li logo\"><a href=\"\main\"><img class='logo' src='/resource/img/logo.png'></a> </li>
        <li class=\"menu_item-li\"><a href=\"\main\"><i class=\"menu_item\" aria-hidden=\"true\"></i>Главная</a></li>
        <li class=\"menu_item-li\"><a href=\"\discussions\"><i class=\"menu_item\" aria-hidden=\"true\"></i>Обсуждения</a></li>
        <li class=\"menu_item-li\"><a href=\"\"><i class=\"menu_item\" aria-hidden=\"true\"></i>Поддержка</a></li>
        $Menu

    </ul>
</header>
<div class='search-bar'>
    <p class='twenty white bold'>Поиск по обсуждениям</p>
    <input type='search'>
    <p id='search-res'></p>
</div>
";
        }


        function prefooter()
        {
            echo "
               <section class=\"pre-footer\">
    <div class=\"community-block\">
        <div class=\"triangle\"></div>
        <div class=\"rectangle\"></div>
    </div>
    <div class=\"postscriptum-block\">
        <div class=\"postscript-txt\">
            <h2 class=\"white bold thirty\">Lorem ipsum okefakeg espektos!</h2>
            <p class=\"white light twenty-fifth\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
            totam rem aperiam doloremque laudantium, totam rem aperiam.</p>
        </div>
    </div>
</section>
    ";
        }

        function footer()
        {
            echo "
        <footer class='footer'>
    <p class=\"white light seventeen\">Metrostroi Project from Garry's Mod</p>
    <p class=\"white light seventeen\">© 2019 PvxowJezzzus - Copyright All termes Reserved </p>
</footer>
    ";
        }


    }
}
?>
