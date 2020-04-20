<?php
require 'core/Сontroller.php';
require 'form/guest.php';
require 'lib/pagination.php';


class ForumController extends Controller {


    public function discussions() {
        if ($_SESSION['USER_LOGIN_IN'] == 1 ) {
            $this->view->layout = 'user';
        }
        $i = array(1,2,3);
        $vars = [
            "cat$i[0]" => array('top' => $this->model->topsections($cat = 1),
                                'all' => $this->model->sections($cat = 1)),
            "cat$i[1]" => array('top' => $this->model->topsections($cat = 2),
                                  'all' => $this->model->sections($cat = 2)),
            "cat$i[2]" => array('top' => $this->model->topsections($cat = 3),
                                'all' => $this->model->sections($cat = 3)),
            "createsect" => $this->model->createbtn(),
        ];
        $this->view->render('Обсуждения', $vars);
    }
    public function section() {
        if ($_SESSION['USER_LOGIN_IN'] == 1 ) {
            $this->view->layout = 'user';
        }
        $valid = $this->model->validsection();
        $vars = [
            "path" => $this->model->path($loc = 'section'),
            "createthread" => $this->model->createthread(),
            "threads" => $this->model->threads(),
            "quill" => $this->model->quill(),
        ];
        $this->view->render("$valid",$vars);
    }

    public function thread() {
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            $this->view->layout = 'user';
        }
        $url = $_SERVER['REQUEST_URI'];
        $page = stristr($url,'/page/', false);
        $page = str_replace('/page/', '', $page);
        if (!isset($page) || empty($page)) {
            $page = 1;
        }

        $url = str_replace('/page/'.$page.'', '', $url);
        $url = substr(".$url.", 20, 20);
        $url = str_replace('/', '', $url);
        $url = substr(".$url.", 1, 7);
        $url = str_replace('.', '', $url);
        $connect = mysqli_connect('localhost', 'root', '', 'metrostroi-forum');
        $answers = mysqli_query($connect,"SELECT * FROM `answers` WHERE `ThreadID` = '$url'");
        $answcount = mysqli_num_rows($answers);
        $max = 5;
        $offset = $max * ($page-1);
        $pagination = new Pagination($this->route, $answcount, $offset, 5);
        $pages = $pagination->validate($url);
        $thread  = $this->model->validthread();
        $vars = [
            'pagination' => $pagination->get(),
            'answcount' => $answcount,
            'url'=> $url,
            'max' => $max,
            'offset' => $offset,
            'page'=> $page,
            'pages'=>$pages,
            'url' => $this->model->url(),
            'path' => $this->model->path($loc = 'thread'),
            'thread' => $thread,
            'threadbar' => $this->model->threadbar(),
            'Rank' => $this->model->rank(),
            'threadel' => $this->model->removethread(),
            'quill' => $this->model->quill(),
        ];

        $this->view->render("$thread", $vars);

    }

}
?>
