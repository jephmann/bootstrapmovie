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
    
    $name = sanitize('name');
    $name = "guinness";
    if (strlen($name) != 0)
    {
        $apiName    = new Api;
        $urlName    = $apiName->url_search_name($name);
        $dataName   = Api::retrieve($urlName);
        
        
        $name_page              = $dataName['page'];
        $name_total_pages       = $dataName['total_pages'];
        $name_total_results     = $dataName['total_results'];
        $name_results           = $dataName['results'];
        /*
         * Consider resorting $name_results:
         * - A-Z
         * - Z-A
         * - other?
         */
        
        echo "<h2>{$name_total_results} results for \"{$name}\":</h2>";
        
        $count_results = 0;
        foreach ($name_results as $result)
        {
            $result_id    = $result['id'];
            $result_name  = $result['name'];
            $count_results++;
            echo "<h3>{$count_results}.&nbsp;"
                . "<a href=\"name.php?id={$result_id}\">{$result_name}</a>"
                . "</h3>";
        }
        

        echo "<pre>";
        print_r($dataName);
        echo "</pre>";
    }
    else
    {
        echo "<h3>Name?</h3>";
    }