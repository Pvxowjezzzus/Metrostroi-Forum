<?php
class Pagination {

    private $max = 5;
    private $route;
    private $current_page;
    private $total;
    private $limit;
    private $offset;

    public function __construct($route, $total, $offset, $limit = 5) {
        $this->route = $route;
        $this->total = $total;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->amount = $this->amount();
        $this->setCurrentPage();
    }

    public function get() {
        $links = null;
        $limits = $this->limits();
        $html = '<nav><ul class="paginate">';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li class="page-item"><span class="page-link">'.$page.'</span></li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }
        $this->offset = ($this->page - 1) * $this->limit;
        if ($this->offset >= $this->total) {
            header('Location: /discussions');
        }

        if (!is_null($links)) {
            if ($this->current_page > 1) {
                $links = $this->generateHtml($this->current_page-1, 'Назад').$links;
            }
            if ($this->current_page < $this->amount) {
                $links .= $this->generateHtml($this->current_page+1, 'Вперед');
            }
        }
        $html .= $links.' </ul></nav>';
        return $html;
    }
    public function validate($thread) {
        if ($this->total)
            if ($this->offset >= $this->total) {
                header("Location: /discussions/forum/$thread/");
            }
    }
    private function generateHtml($page, $text = null) {
        if (!$text) {
            $text = $page;
        }

        $url = $_SERVER['REQUEST_URI'];
        if (preg_match('/page/', $url)) {
            $url = stristr($url, '/page/', true);
        }
        if ($page == 1) {
            return '
<li class="page-item"><a class="page-link" href="'.$url.'"  >'.$text.'</a></li>';
        }

        return '
<li class="page-item"><a class="page-link" href="'.$url.'/page/'.$page.'">'.$text.'</a></li>';


    }

    private function limits() {
        $left = $this->current_page - round($this->max / 2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;

        }
        else {

            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;

        }
        return array($start, $end);
    }

    public function setCurrentPage() {
        $url = $_SERVER['REQUEST_URI'];
        $page = stristr($url,'/page/', false);
        $page = str_replace('/page/', '', $page);
        if (!isset($page) || empty($page)) {
            $page = 1;
        }
        if (isset($page)) {
            $currentPage = $page;
        } else {
            $currentPage = 1;

        }
        $this->current_page = $currentPage;
            if ($this->current_page > 0) {
                if ($this->current_page > $this->amount) {
                    $this->current_page = $this->amount;
                }
            } else {
                $this->current_page = 1;
    
            }
        if ( $this->current_page  > ceil($this->total / $this->limit)) {  // предотвращаем отображение страниц, которые выходит за пределы текущих данных
            header('/discussions');
        }
        }
    
        private function amount() {
            return ceil($this->total / $this->limit);

        }
    }
    ?>