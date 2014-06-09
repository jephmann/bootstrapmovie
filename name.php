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
    
        $objName   = new Api;
        $url_name  = $objName->url_name($id);
        $json_name = file_get_contents($url_name);
        $data_name = json_decode($json_name, true);
        
        // data (all of it, whether I use all of it or not)
        $name_id                   = htmlentities($data_name["id"], ENT_QUOTES, 'UTF-8');                    // integer
        $name_nm                   = htmlentities($data_name["imdb_id"], ENT_QUOTES, 'UTF-8');               // nm#######
        $name_name                = htmlentities($data_name["name"], ENT_QUOTES, 'UTF-8');                 // == or !=
        $name_adult                = htmlentities($data_name["adult"], ENT_QUOTES, 'UTF-8');                 // null?
        $name_homepage             = htmlentities($data_name["homepage"], ENT_QUOTES, 'UTF-8');              // null? original_name
        $name_biography             = htmlentities($data_name["biography"], ENT_QUOTES, 'UTF-8');
        $name_place_of_birth           = htmlentities($data_name["place_of_birth"], ENT_QUOTES, 'UTF-8');
        $name_popularity           = htmlentities($data_name["popularity"], ENT_QUOTES, 'UTF-8');
        $name_profile_path          = htmlentities($data_name["profile_path"], ENT_QUOTES, 'UTF-8');           // "/somethingsomething.jpg"
        // arrays (no "htmlentities" until looping)
        $name_also_known_as     = $data_name["also_known_as"];
        // dates
        $name_birthday         = strtotime(htmlentities($data_name["birthday"], ENT_QUOTES, 'UTF-8'));    // YYYY-MM-DD
        $name_deathday         = strtotime(htmlentities($data_name["deathday"], ENT_QUOTES, 'UTF-8'));    // YYYY-MM-DD
        // dates
        $name_birthday         = htmlentities($data_name["birthday"], ENT_QUOTES, 'UTF-8');    // YYYY-MM-DD
        $name_deathday         = htmlentities($data_name["deathday"], ENT_QUOTES, 'UTF-8');    // YYYY-MM-DD

        // strings
        $url_imdb_name                 = "{$url_imdb}name/{$name_nm}/";
        $link_imdb_name                = link_outward($url_imdb_name, "IMDB");    
        $url_themoviedb_name_format    = str_replace(' ','-',strtolower($name_name));
        $url_themoviedb_name           = "{$url_themoviedb}person/{$name_id}-{$url_themoviedb_name_format}";
        $link_themoviedb_name          = link_outward($url_themoviedb_name, "TheMovieDB");
        
        $name_born_died = NULL;
        if($name_birthday != NULL or $name_deathday != NULL)
        {
            $name_born_died = "<p>";
            if($name_birthday != NULL)
            {
                $name_birthday = strtotime($name_birthday);
                $name_birthday = date("F d, Y", $name_birthday);
                if($name_place_of_birth != NULL)
                {
                    $name_birthday .= ", in {$name_place_of_birth}";
                }
                $name_born_died .= "<p><strong>Born:</strong>&nbsp;{$name_birthday}</p>";          
            }
            if($name_deathday != NULL)
            {
                $name_deathday = strtotime($name_deathday);
                $name_deathday = date("F d, Y", $name_deathday);
                $name_born_died .= "<p><strong>Died:</strong>&nbsp;{$name_deathday}</p>";                
            }
            $name_born_died .= "</p>";
        }

        // lists
        //$li_aka      = li("Alias", $name_also_known_as, "also_known_as" );
        $li_aka      = NULL;
        
    
        /* person credits */

        $objCredits  = new Api;
        $url_name_credits  = $objCredits->url_name_credits($id);
        $json_name_credits = file_get_contents($url_name_credits);
        $data_name_credits = json_decode($json_name_credits, true);

        // data (all of it, whether I use all of it or not)
        $name_id   = htmlentities($data_name_credits["id"], ENT_QUOTES, 'UTF-8');                    // integer
        // arrays (no "htmlentities" until looping)
        $name_cast = $data_name_credits["cast"];
        $name_crew = $data_name_credits["crew"];

        // lists
        $cast      = cast($name_cast);
        $crew      = crew($name_crew);
        
        /* movie images */

        $objImages  = new Api;
        $url_name_images  = $objImages->url_name_images($id);
        $json_name_images = file_get_contents($url_name_images);
        $data_name_images = json_decode($json_name_images, true);

        // data (all of it, whether I use all of it or not)
        $name_id           = htmlentities($data_name_images["id"], ENT_QUOTES, 'UTF-8');                    // integer
        // arrays (no "htmlentities" until looping)
        $name_profiles     = $data_name_images["profiles"];
        
        // lists
        $profiles  = images($name_profiles);
        
        
        $jumbotron = array(
            'h1' => $name_name,
            'p' => $name_biography,
        );
        $getView = 'name';
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
            $adult          = htmlentities($list[$i]["adult"], ENT_QUOTES, 'UTF-8');
            $character      = htmlentities($list[$i]["character"], ENT_QUOTES, 'UTF-8');
            $credit_id      = htmlentities($list[$i]["credit_id"], ENT_QUOTES, 'UTF-8');
            $id             = htmlentities($list[$i]["id"], ENT_QUOTES, 'UTF-8');
            $original_title = htmlentities($list[$i]["original_title"], ENT_QUOTES, 'UTF-8');
            $poster_path    = htmlentities($list[$i]["poster_path"], ENT_QUOTES, 'UTF-8');
            $release_date   = htmlentities($list[$i]["release_date"], ENT_QUOTES, 'UTF-8');
            $title          = htmlentities($list[$i]["title"], ENT_QUOTES, 'UTF-8');
            //$media_type     = htmlentities($list[$i]["media_type"], ENT_QUOTES, 'UTF-8');
            
            $release_date = strtotime($release_date);
            $year = date('Y',$release_date);
            $result["data"] .= "\n<p>{$year} <a style=\"font-weight: bold; text-decoration: none; font-style: italic\" href=\"title.php?id={$id}\">{$title}</a>\n<br />&nbsp;<em>as</em> {$character}</p>";
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
            $adult          = htmlentities($list[$i]["adult"], ENT_QUOTES, 'UTF-8');
            $credit_id      = htmlentities($list[$i]["credit_id"], ENT_QUOTES, 'UTF-8');
            $department      = htmlentities($list[$i]["department"], ENT_QUOTES, 'UTF-8');
            $id             = htmlentities($list[$i]["id"], ENT_QUOTES, 'UTF-8');
            $original_title = htmlentities($list[$i]["original_title"], ENT_QUOTES, 'UTF-8');
            $poster_path    = htmlentities($list[$i]["poster_path"], ENT_QUOTES, 'UTF-8');
            $release_date   = htmlentities($list[$i]["release_date"], ENT_QUOTES, 'UTF-8');
            $title          = htmlentities($list[$i]["title"], ENT_QUOTES, 'UTF-8');
            $job     = htmlentities($list[$i]["job"], ENT_QUOTES, 'UTF-8');
            
            $department = strtoupper($department);
            
            $release_date = strtotime($release_date);
            $year = date('Y',$release_date);
            $result["data"] .= "\n<br />{$year} <a style=\"font-weight: bold; text-decoration: none; font-style: italic\" href=\"title.php?id={$id}\">{$title}</a>"
            . "\n<br />&nbsp;&nbsp;<strong>{$department}:&nbsp;<em>{$job}:</em></strong>";
        }
        $result["data"] .= "\n</p>";
        return $result;        
    }        
    
    function link_outward($url, $text)
    {
        $link   = "<a style=\"font-style: italic;\" target=\"_blank\" href=\"{$url}\">{$text}</a>";
        return $link;
    }