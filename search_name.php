<?php
    $page = array (
        'path' => NULL,
        'template' => NULL,
    );
    
    require_once ($page['path'] . '_inc/first.php');
    require_once ($page['path'] . '_inc/functions.php');
    
    $name = sanitize('name', TRUE);
    if (strlen($name) != 0)
    {
        $apiName    = new ApiMovieDB;
        $urlName    = $apiName->url_search_name($name);
        $dataName   = Api::json_retrieve($urlName);        
        
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
        
        echo "<h3>Top results for \"{$name}\":</h3>";
        
        $count_results = 0;
        foreach ($name_results as $result)
        {
            $result_id                      = $result['id'];
            $result_name                    = $result['name'];
            $result_known_for               = $result['known_for'];
            $known_for_list                 = NULL;
            $known_for_release_date         = NULL;
            $known_for_release_date_year    = NULL;
            foreach ($result_known_for as $known_for)
            {
                if(!empty($known_for['title']))
                {
                    if(!empty($known_for['release_date']))
                    {
                        $known_for_release_date         = redate($known_for['release_date']);
                        $known_for_release_date_year    = $known_for_release_date['year'];
                    }
                    else
                    {
                        $known_for_release_date_year = "----";
                    }
                    $known_for_list .= "<li>{$known_for_release_date_year}&nbsp;<em>{$known_for['title']}</em></li>";
                }
            }
            
            $count_results++;
            echo "<p>{$count_results}.&nbsp;"
                . "<strong>"
                . "<a href=\"name.php?id={$result_id}\">{$result_name}</a>"
                . "</strong>"
                . "<ul>{$known_for_list}</ul>"
                . "</p>";
        }
        echo "<hr />";
        // testing
        echo "<details>";
        echo "<summary>Raw Data (Name Search)</summary>";
        echo "<pre>";
        print_r($dataName);
        echo "</pre>";
        echo "</details>";
    }
    else
    {
        echo "<h3>Name?</h3>";
    }