<?php
    $page = array (
        'path' => NULL,
        'template' => NULL,
    );
    
    require_once ($page['path'] . '_inc/first.php');
    require_once ($page['path'] . '_inc/functions.php');

    $title = sanitize('title', TRUE);
    if (strlen($title) != 0)
    {
        $apiTitle   = new ApiMovieDB;
        $urlTitle   = $apiTitle->url_search_title($title);
        $dataTitle  = Api::json_retrieve($urlTitle);        
        
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
        
        echo "<h3>Top results for \"{$title}\":</h3>";
        
        $count_results = 0;
        foreach ($title_results as $result)
        {
            $result_id              = $result['id'];
            $result_title           = $result['title'];
            $result_release_date    = NULL;
            $result_release_year    = NULL;
            if(!empty($result['release_date']))
            {
                $result_release_date    = redate($result['release_date']);
                $result_release_year    = $result_release_date['year'];
            }
            else
            {
                $result_release_year    = "----";
            }
            
            $count_results++;
            
            echo "<p>{$count_results}.&nbsp;"
                . "<strong><em>"
                . "<a href=\"title.php?id={$result_id}\">{$result_title}</a>"
                . "</em></strong>"
                . "&nbsp;({$result_release_year})"
                . "</p>";
        }
        echo "<hr />";
        // testing
        echo "<details>";
        echo "<summary>Raw Data (Name Search)</summary>";
        echo "<pre>";
        print_r($dataTitle);
        echo "</pre>";
        echo "</details>";
    }
    else
    {
        echo "<h3>Title?</h3>";
    }