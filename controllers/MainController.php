<?php
require 'core/Сontroller.php';
require 'form/guest.php';


class  MainController extends Controller {
    public function main() {
        if ($_SESSION['USER_LOGIN_IN'] == 1 ) {
            $this->view->layout = 'user';
        }
        $this->view->render('Metrostroi Forum');
    }


    public function selfprofile() {
        if ($_SESSION['USER_LOGIN_IN'] == 1) {
            $selfprof = $this->model->selfprofile();
            $avatar = "/resource/avatar/$selfprof[Avatar].jpg";
            $regdate = date("d.m.Y", strtotime($selfprof['RegDate']));
            $vars = [
                'user' =>  $selfprof,
                'avatar' => $avatar,
                'regdate' => $regdate,
                'AdminPanelBtn' => $this->model->AdminPanel($type='btn'),
                'AdminPanelCont' => $this->model->AdminPanel($type='content')
            ];
            $this->view->layout = 'user';
            $this->view->render('Мой профиль', $vars);


        }
       else {
           echo '403: Доступ запрещен';
           header("Refresh:2; url=../main");
       }

    }

    public function profile() {

         if ($_SESSION['USER_LOGIN_IN'] == 1) {
             $this->view->layout = 'user';
         }
            $this->view->render('Профиль');
        }


    public function chat() {
        if ($_SESSION['USER_LOGIN_IN'] == 1) {
            $this->view->layout = 'user';
            $this->view->render('Чат');
        }
        else {
            header("HTTP/1.1 404 Not Found");
        }
    }
}
?>
