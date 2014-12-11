<?php
    $page = array (
        'path' => NULL,
        'template' => NULL,
    );
    
    require_once ($page['path'] . '_inc/first.php');

    function sanitize($post)
    {
        $result = filter_input(INPUT_POST, $post, FILTER_SANITIZE_STRING);
        return $result;
    }

    $title = sanitize('title');
    //$title = 'local';
    if (strlen($title) != 0)
    {
        $apiTitle = new Api;
        $urlTitle = $apiTitle->url_search_title($title);
        $dataTitle = Api::retrieve($urlTitle);
        
        
        $title_page              = $dataTitle['page'];
        $title_total_pages       = $dataTitle['total_pages'];
        $title_total_results     = $dataTitle['total_results'];
        $title_results           = $dataTitle['results'];
        /*
         * Consider resorting $title_results:
         * - A-Z
         * - Z-A
         * - date ascending
         * - date descending
         * - other?
         */
        
        echo "<h2>{$title_total_results} results for \"{$title}\":</h2>";
        
        $count_results = 0;
        foreach ($title_results as $result)
        {
            $result_id    = $result['id'];
            $result_title  = $result['title'];
            $count_results++;
            echo "<p>{$count_results}.&nbsp;"
                . "<strong><em>"
                . "<a href=\"title.php?id={$result_id}\">{$result_title}</a>"
                . "</em></strong>"
                . "</p>";
        }
        // testing
        echo "<pre>";
        print_r($dataTitle);
        echo "</pre>";
    }
    else
    {
        echo "<h3>Title?</h3>";
    }