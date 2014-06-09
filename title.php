<?php
    $page = array (
        'path' => NULL,
        'template' => 'jumbotron',
    );
    require_once ($page['path'] . '_inc/first.php');
    
    // base URLs
    $url_imdb       = Api::$url_imdb;
    $url_themoviedb = Api::$url_themoviedb;    
    
    $getView = NULL;
    if(isset($_GET['id']))
    {
        // input data
        $id   = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);    
    
        $objTitle   = new Api;
        $url_title  = $objTitle->url_title($id);
        $json_title = file_get_contents($url_title);
        $data_title = json_decode($json_title, true);
        
        // data (all of it, whether I use all of it or not)
        $title_id                   = htmlentities($data_title["id"], ENT_QUOTES, 'UTF-8');                    // integer
        $title_tt                   = htmlentities($data_title["imdb_id"], ENT_QUOTES, 'UTF-8');               // tt#######
        $title_original_title       = htmlentities($data_title["original_title"], ENT_QUOTES, 'UTF-8');        // == or != title
        $title_title                = htmlentities($data_title["title"], ENT_QUOTES, 'UTF-8');                 // == or !=
        $title_adult                = htmlentities($data_title["adult"], ENT_QUOTES, 'UTF-8');                 // null?
        $title_backdrop_path        = htmlentities($data_title["backdrop_path"], ENT_QUOTES, 'UTF-8');         // "/somethingsomething.jpg"
        $title_budget               = htmlentities($data_title["budget"], ENT_QUOTES, 'UTF-8');                // integer 0?
        $title_homepage             = htmlentities($data_title["homepage"], ENT_QUOTES, 'UTF-8');              // null? original_title
        $title_overview             = htmlentities($data_title["overview"], ENT_QUOTES, 'UTF-8');
        $title_popularity           = htmlentities($data_title["popularity"], ENT_QUOTES, 'UTF-8');
        $title_poster_path          = htmlentities($data_title["poster_path"], ENT_QUOTES, 'UTF-8');           // "/somethingsomething.jpg"
        $title_revenue              = htmlentities($data_title["revenue"], ENT_QUOTES, 'UTF-8');               // integer 0?
        $title_runtime              = htmlentities($data_title["runtime"], ENT_QUOTES, 'UTF-8');               // integer of minutes
        $title_status               = htmlentities($data_title["status"], ENT_QUOTES, 'UTF-8');                // whether it's released or not
        $title_tagline              = htmlentities($data_title["tagline"], ENT_QUOTES, 'UTF-8');
        $title_vote_average         = htmlentities($data_title["vote_average"], ENT_QUOTES, 'UTF-8');          // integer?
        $title_vote_count           = htmlentities($data_title["vote_count"], ENT_QUOTES, 'UTF-8');            // integer
        // arrays (no "htmlentities" until looping)
        $title_genres                   = $data_title["genres"];
        $title_production_companies     = $data_title["production_companies"];
        $title_production_countries     = $data_title["production_countries"];
        $title_spoken_languages         = $data_title["spoken_languages"];
        $title_belongs_to_collection    = $data_title["belongs_to_collection"];
        // dates
        $title_release_date         = strtotime(htmlentities($data_title["release_date"], ENT_QUOTES, 'UTF-8'));    // YYYY-MM-DD

        // strings
        $url_imdb_title                 = "{$url_imdb}title/{$title_tt}/fullcredits";
        $link_imdb_title                = link_outward($url_imdb_title, "IMDB");    
        $url_themoviedb_title_format    = str_replace(' ','-',strtolower($title_title));
        $url_themoviedb_title           = "{$url_themoviedb}movie/{$title_id}-{$url_themoviedb_title_format}";
        $link_themoviedb_title          = link_outward($url_themoviedb_title, "TheMovieDB");

        // lists
        $li_genres      = li("Genre", $title_genres);
        $li_companies   = li("Production Companies", $title_production_companies);
        $li_countries   = li("Production Countries", $title_production_countries);
        $li_languages   = li("Spoken Languages", $title_spoken_languages);
        $title_collection = "<p><strong>Collection Notes:</strong></p>";
        $title_collection .= "<ul>";
        $title_collection .= "<li>" . htmlentities($title_belongs_to_collection["name"], ENT_QUOTES, 'UTF-8') . "</li>";
        $title_collection .= "</ul>";
    
        /* movie credits */

        $objCredits  = new Api;
        $url_title_credits  = $objCredits->url_title_credits($id);
        $json_title_credits = file_get_contents($url_title_credits);
        $data_title_credits = json_decode($json_title_credits, true);

        // data (all of it, whether I use all of it or not)
        $title_id   = htmlentities($data_title_credits["id"], ENT_QUOTES, 'UTF-8');                    // integer
        // arrays (no "htmlentities" until looping)
        $title_cast = $data_title_credits["cast"];
        $title_crew = $data_title_credits["crew"];

        // lists
        $cast      = cast($title_cast);
        $crew      = crew($title_crew);
        
        /* movie images */

        $objImages  = new Api;
        $url_title_images  = $objImages->url_title_images($id);
        $json_title_images = file_get_contents($url_title_images);
        $data_title_images = json_decode($json_title_images, true);

        // data (all of it, whether I use all of it or not)
        $title_id           = htmlentities($data_title_images["id"], ENT_QUOTES, 'UTF-8');                    // integer
        // arrays (no "htmlentities" until looping)
        $title_backdrops    = $data_title_images["backdrops"];
        $title_posters      = $data_title_images["posters"];
        
        // lists
        $backdrops  = images($title_backdrops);
        $posters  = images($title_posters);
        
        $jumbotron = array(
            'h1' => '<em>' . $title_title . '</em> (' . date('Y', $title_release_date) . ')',
            'p' => $title_overview,
        );
        $getView = 'title';
    }
    else
    {
        $getView = 'getno';
    }
    
    require '_views/head.php';
    require '_views/navigation.php';
    require '_views/' . $getView . '.php';    
    require '_views/footer.php';
    require '_views/foot.php';
    
    
    function images($list)
    {
        $result             = array();
        $result["error"]    = NULL;
        $result["data"]     = NULL;
        $count              = count($list);
        for ($i=0; $i<$count; $i++)
        {
            $aspect_ratio   = htmlentities($list[$i]["aspect_ratio"], ENT_QUOTES, 'UTF-8');
            $file_path      = htmlentities($list[$i]["file_path"], ENT_QUOTES, 'UTF-8');
            $height         = htmlentities($list[$i]["height"], ENT_QUOTES, 'UTF-8');
            $iso_639_1      = htmlentities($list[$i]["iso_639_1"], ENT_QUOTES, 'UTF-8');
            $vote_average   = htmlentities($list[$i]["vote_average"], ENT_QUOTES, 'UTF-8');
            $vote_count     = htmlentities($list[$i]["vote_count"], ENT_QUOTES, 'UTF-8');
            $width          = htmlentities($list[$i]["width"], ENT_QUOTES, 'UTF-8');
            $result["data"] .= "\n<img height=\"100px\" src=\"https://image.tmdb.org/t/p/original{$file_path}\" />";
        }
        return $result;  
    }
    
    function cast($list)
    {
        $result             = array();
        $result["error"]    = NULL;
        $result["data"]     = NULL;
        $count              = count($list);
        for ($i=0; $i<$count; $i++)
        {
            $order          = htmlentities($list[$i]["order"], ENT_QUOTES, 'UTF-8');
            $cast_id        = htmlentities($list[$i]["cast_id"], ENT_QUOTES, 'UTF-8');
            $id             = htmlentities($list[$i]["id"], ENT_QUOTES, 'UTF-8');
            $credit_id      = htmlentities($list[$i]["credit_id"], ENT_QUOTES, 'UTF-8');
            $profile_path   = htmlentities($list[$i]["profile_path"], ENT_QUOTES, 'UTF-8');
            $name           = htmlentities($list[$i]["name"], ENT_QUOTES, 'UTF-8');
            $character      = htmlentities($list[$i]["character"], ENT_QUOTES, 'UTF-8');
            $result["data"] .= "\n<p><a style=\"font-weight: bold; text-decoration: none;\" href=\"name.php?id={$id}\">{$name}</a>\n<br />&nbsp;<em>as</em> {$character}</p>";
        }
        return $result;        
    }
    
    function crew($list)
    {
        $result             = array();
        $result["error"]    = NULL;
        $result["data"]     = "\n<p>";
        $count              = count($list);
        // TODO: sort array by department, job, name, all ascending
        for ($i=0; $i<$count; $i++)
        {
            $id             = htmlentities($list[$i]["id"], ENT_QUOTES, 'UTF-8');
            $credit_id      = htmlentities($list[$i]["credit_id"], ENT_QUOTES, 'UTF-8');
            $profile_path   = htmlentities($list[$i]["profile_path"], ENT_QUOTES, 'UTF-8');
            $department     = strtoupper(htmlentities($list[$i]["department"], ENT_QUOTES, 'UTF-8'));
            $job            = htmlentities($list[$i]["job"], ENT_QUOTES, 'UTF-8');
            $name           = htmlentities($list[$i]["name"], ENT_QUOTES, 'UTF-8');
            $result["data"] .= "\n<br /><strong>{$department}:\n<br />&nbsp;<em>{$job}:</em></strong>&nbsp<a style=\"font-weight: bold; text-decoration: none;\" href=\"name.php?id={$id}\">{$name}</a>";
        }
        $result["data"] .= "\n</p>";
        return $result;        
    }    
    
    function link_outward($url, $text)
    {
        $link   = "<a style=\"font-style: italic;\" target=\"_blank\" href=\"{$url}\">{$text}</a>";
        return $link;
    }
    
    // bullet list function
    function li($category, $list)
    {
        $result             = array();
        $result["error"]    = NULL;
        $result["list"]     = "<p><strong>{$category}:</strong></p>\n<ul>";
        $count              = count($list);
        for ($i=0; $i<$count; $i++)
        {
            $name           = htmlentities($list[$i]["name"], ENT_QUOTES, 'UTF-8');
            $result["list"] .= "\n<li>{$name}</li>";
        }
        $result["list"]     .= "\n</ul>";
        return $result;
    }