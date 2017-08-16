<?php
    define("CURRENT_WORKING_DIR", str_replace("\\", "/", $dirname = dirname(__FILE__)));
    require CURRENT_WORKING_DIR . '/libs/root-src/standalone.php';
    header("Content-Type: text/html; charset=utf-8");
    
    $oCollection = umiObjectsCollection::getInstance();

    include CURRENT_WORKING_DIR . '/libs/phpQuery/phpQuery.php';
    
    $url = 'https://www.yell.ru/moscow/com/magazin-kalyan-hat_7895278/';
    
    $html = file_get_contents($url); 

    
//    $url = 'http://otzovik.com/reviews/magazin_kalyanov_kalyan-hat_russia_moscow/';
//    $curl = curl_init($url);
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //Записать http ответ в переменную, а не выводить в буфер 
//    $page = curl_exec($curl);
//    
//    
    $yellPageDocument = phpQuery::newDocument($html);
    
    $hentry = $yellPageDocument->find('.reviews__item');
    
    echo '<pre>';
    foreach($hentry as $el){
        $pq = pq($el);
        $json = $pq->attr('data-review');
        $site_source = 'yell.ru';
        $commentArray = json_decode($json, true);
        $raiting_points = (int)$pq->find('.rating__value')->text();
        $pro = '';
        $contra = '';
        $author = $pq->find('.reviews__item-user-name')->text();
        $review_link = $pq->find('.reviews__item-anchor')->find('a')->attr('href');
        
        $sql_check = "SELECT * FROM `shop_kalyan`.`cms3_external_reviews` WHERE `site_source` = '{$site_source}' AND `review_id` = '{$commentArray['id']}'";
        //$result = l_mysql_query($sql_check);
        
        
        // Занесение нового комментария в базу данных
        $res = l_mysql_query($sql_check);
        if(mysql_num_rows($res) == 0){
            $sql = "INSERT INTO `shop_kalyan`.`cms3_external_reviews` "
                    . "(`id`, `active`, `site_source`, `review_id`,`raiting_points`, `pro`, `contra`, `author_nickname`, `review`, `review_link`) "
                    . "VALUES (NULL, 1, '{$site_source}', '{$commentArray['id']}', '{$raiting_points}', '{$pro}', '{$contra}', '{$author}', '{$commentArray['text']}','{$review_link}');";
            $insert_res = l_mysql_query($sql);
        }else{
            echo "Для сайта {$site_source} комментарий с ID {$commentArray['id']} уже есть.";
        }

    }
    echo '</pre>';
    echo 'ok';
    
    /*
     * ID                       int
     * ID площадки              int
     * ID отзыва на площадке    int
     * Рейтинг ЗА               int
     * Рейтинг ПРОТИВ           int
     * Ник автора               string(155)
     * Текст отзыва             varchar
     */

    
?>