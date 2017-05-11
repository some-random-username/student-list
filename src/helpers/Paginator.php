<?php
namespace src\helpers;

class Paginator {
    public static function paginate($params) {
        while ($params['page']++ < $params['num_pages']) {
            if ($params['page'] == $params['cur_page']) {
                echo '<li class="active"><a>' . $params['page'] . '</a></li>';
            } else {
                echo "<li><a href=\"?page=" . $params['page'] . "\">" . $params['page'] . "</a></li>";   
            }
        }
    }
}
