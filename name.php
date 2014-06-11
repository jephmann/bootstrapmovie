<?php
    $page = array (
        'path' => NULL,
        'template' => 'jumbotron',
    );
    require_once ($page['path'] . '_inc/first.php');
    
    // base URLs
    $url_imdb       = Api::$url_imdb;
    $url_themoviedb = Api::$url_themoviedb;
    
    /*
     * Swapping (including/requiring) Views, per GET/POST id
     */
    $getView = NULL;
    if(isset($_GET['id']))
    {
        // input data
        $id   = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);    
    
        $objName        = new Api;
        $urlName        = $objName->url_name($id);
        $data_name      = Api::retrieve($urlName);
        
        $objCredits     = new Api;
        $urlCredits     = $objCredits->url_name_credits($id);
        $data_credits   = Api::retrieve($urlCredits);
        
        $objImages      = new Api;
        $urlImages      = $objImages->url_name_images($id);
        $data_images    = Api::retrieve($urlImages);
        
        /*
         * REDUNDANT ID DATA
         * $name_id     = htmlentities($data_name["id"], ENT_QUOTES, 'UTF-8');         * 
         * $name_id     = htmlentities($data_credits["id"], ENT_QUOTES, 'UTF-8');
         * $name_id     = htmlentities($data_images["id"], ENT_QUOTES, 'UTF-8');
         */
        
        /* name stuff (all of it, whether I use all of it or not) */
        $name_nm                = htmlentities($data_name["imdb_id"], ENT_QUOTES, 'UTF-8');         // nm#######
        $name_name              = htmlentities($data_name["name"], ENT_QUOTES, 'UTF-8');            // == or !=
        $name_adult             = htmlentities($data_name["adult"], ENT_QUOTES, 'UTF-8');           // null?
        $name_homepage          = htmlentities($data_name["homepage"], ENT_QUOTES, 'UTF-8');        // null? original_name
        $name_biography         = htmlentities($data_name["biography"], ENT_QUOTES, 'UTF-8');
        $name_place_of_birth    = htmlentities($data_name["place_of_birth"], ENT_QUOTES, 'UTF-8');
        $name_popularity        = htmlentities($data_name["popularity"], ENT_QUOTES, 'UTF-8');
        $name_profile_path      = htmlentities($data_name["profile_path"], ENT_QUOTES, 'UTF-8');    // "/somethingsomething.jpg"
        // arrays (no "htmlentities" until looping)
        $name_also_known_as     = $data_name["also_known_as"];
        // dates
        $name_birthday          = htmlentities($data_name["birthday"], ENT_QUOTES, 'UTF-8');    // YYYY-MM-DD
        $name_deathday          = htmlentities($data_name["deathday"], ENT_QUOTES, 'UTF-8');    // YYYY-MM-DD

        // strings
        $url_imdb_name                 = "{$url_imdb}name/{$name_nm}/";
        $link_imdb_name                = link_outward($url_imdb_name, "IMDB");    
        $url_themoviedb_name_format    = str_replace(' ','-',strtolower($name_name));
        $url_themoviedb_name           = "{$url_themoviedb}person/{$id}-{$url_themoviedb_name_format}";
        $link_themoviedb_name          = link_outward($url_themoviedb_name, "TheMovieDB");
        
        $name_born_died = NULL;
        if(!empty($name_birthday) or !empty($name_deathday))
        {
            $name_born_died = "<p>";
            if(!empty($name_birthday))
            {
                $display_birthday = redate($name_birthday);
                if($name_place_of_birth != NULL)
                {
                    $name_birthday .= ",<br />&nbsp;in {$name_place_of_birth}";
                }
                $name_born_died .= "<p><strong>Born:</strong>&nbsp;{$display_birthday}</p>";          
            }
            if(!empty($name_deathday))
            {
                $display_deathday = redate($name_deathday);
                $name_born_died .= "<p><strong>Died:</strong>&nbsp;{$display_deathday}</p>";                
            }
            $name_born_died .= "</p>";
        }

        // lists
        $li_aka      = NULL;
        //$li_aka      = li("Alias", $name_also_known_as, "also_known_as" );
        
    
        /* credits (all of it, whether I use all of it or not) */
        
        // arrays (no "htmlentities" until looping)
        $cast = $data_credits["cast"];
        $crew = $data_credits["crew"];

        // lists
        
        $display_cast = NULL;
        if (empty($cast))
        {
            $display_cast   = "<p>NO PERFORMANCE CREDITS</p>";
        }
        else
        {
            // sort cast
            foreach ($cast as $key => $row)
            {
                $cast_release_date[$key] = $row['release_date'];
            }
            array_multisort($cast_release_date, SORT_ASC, $cast);
            // display cast
            for ($i=0; $i<count($cast); $i++)
            {
                $cast_adult          = htmlentities($cast[$i]["adult"], ENT_QUOTES, 'UTF-8');
                $cast_character      = htmlentities($cast[$i]["character"], ENT_QUOTES, 'UTF-8');
                $cast_credit_id      = htmlentities($cast[$i]["credit_id"], ENT_QUOTES, 'UTF-8');
                $cast_id             = htmlentities($cast[$i]["id"], ENT_QUOTES, 'UTF-8');
                $cast_original_title = htmlentities($cast[$i]["original_title"], ENT_QUOTES, 'UTF-8');
                $cast_poster_path    = htmlentities($cast[$i]["poster_path"], ENT_QUOTES, 'UTF-8');
                $cast_release_date   = htmlentities($cast[$i]["release_date"], ENT_QUOTES, 'UTF-8');
                $cast_title          = htmlentities($cast[$i]["title"], ENT_QUOTES, 'UTF-8');
                if (empty($cast_release_date))
                {
                    $cast_year   = "[??]";
                }
                else
                {
                    $cast_release_date   = strtotime($cast_release_date);
                    $cast_year           = date('Y',$cast_release_date);                
                }
                if (!empty($cast_character))
                {
                    $cast_character  = "\n<br />&nbsp;<em>as</em> {$cast_character}";
                }
                $display_cast .= "\n<p><strong>{$cast_year}</strong>"
                    . " <a style=\"font-weight: bold; text-decoration: none; font-style: italic\" href=\"title.php?id={$cast_id}\">"
                    . "{$cast_title}"
                    . "</a>"
                    . "{$cast_character}"
                    . "</p>";
            }
        }        
        
        $display_crew = NULL;
        if(empty($crew))
        {
            $display_crew   = "<p>NO ADDITIONAL CREDITS</p>";
        }
        else
        {        
            // sort crew
            foreach ($crew as $key => $row)
            {
                $crew_release_date[$key] = $row['release_date'];
                $crew_department[$key]   = $row['department'];
                $crew_job[$key]          = $row['job'];
            }
            array_multisort($crew_release_date, SORT_ASC, $crew);
            // display_crew
            for ($j=0; $j<count($crew); $j++)
            {
                $adult          = htmlentities($crew[$j]["adult"], ENT_QUOTES, 'UTF-8');
                $credit_id      = htmlentities($crew[$j]["credit_id"], ENT_QUOTES, 'UTF-8');
                $department     = strtoupper(htmlentities($crew[$j]["department"], ENT_QUOTES, 'UTF-8'));
                $id             = htmlentities($crew[$j]["id"], ENT_QUOTES, 'UTF-8');
                $original_title = htmlentities($crew[$j]["original_title"], ENT_QUOTES, 'UTF-8');
                $poster_path    = htmlentities($crew[$j]["poster_path"], ENT_QUOTES, 'UTF-8');
                $release_date   = htmlentities($crew[$j]["release_date"], ENT_QUOTES, 'UTF-8');
                $title          = htmlentities($crew[$j]["title"], ENT_QUOTES, 'UTF-8');
                $job            = htmlentities($crew[$j]["job"], ENT_QUOTES, 'UTF-8');
                if (empty($release_date))
                {
                    $year   = "[??]";
                }
                else
                {
                    $release_date   = strtotime($release_date);
                    $year           = date('Y',$release_date);                
                }
                $display_crew   .= "\n<p>"
                    . "{$year}"
                    . " <a style=\"font-weight: bold; text-decoration: none; font-style: italic\" href=\"title.php?id={$id}\">"
                    . "{$title}"
                    . "</a>"
                    . "\n<br />&nbsp;"
                    . "&nbsp;{$department}:"
                    . "&nbsp;{$job}"
                    . "\n</p>";
            }
        }
        
        foreach($crew as $item)
        {
            $jobs[] = $item['job'];
        }
        $jobs = array_unique($jobs);
        foreach($jobs as $ky => $rw)
        {
            $jb[$ky] = $rw;
        }
        array_multisort($jb, SORT_ASC, $jobs);
        var_dump($jobs);
        foreach ($jobs as $job)
        {
            echo "<p>{$job}</p>";
        }
        
        /* movie images */

        // data (all of it, whether I use all of it or not)

        // arrays (no "htmlentities" until looping)
        $profiles     = $data_images["profiles"];
        
        // lists
        
        // not sorting profiles
        
        // display profiles
        $display_profiles   = NULL;
        for ($k=0; $k<count($profiles); $k++)
        {
            $profiles_aspect_ratio   = htmlentities($profiles[$k]["aspect_ratio"], ENT_QUOTES, 'UTF-8');
            $profiles_file_path      = htmlentities($profiles[$k]["file_path"], ENT_QUOTES, 'UTF-8');
            $profiles_height         = htmlentities($profiles[$k]["height"], ENT_QUOTES, 'UTF-8');
            $profiles_iso_639_1      = htmlentities($profiles[$k]["iso_639_1"], ENT_QUOTES, 'UTF-8');
            $profiles_vote_average   = htmlentities($profiles[$k]["vote_average"], ENT_QUOTES, 'UTF-8');
            $profiles_vote_count     = htmlentities($profiles[$k]["vote_count"], ENT_QUOTES, 'UTF-8');
            $profiles_width          = htmlentities($profiles[$k]["width"], ENT_QUOTES, 'UTF-8');
            $display_profiles .= "\n<img"
                . " height=\"100px\""
                . " src=\"https://image.tmdb.org/t/p/original{$profiles_file_path}\" />";
        }
        
        $jumbotron = array(
            'h1' => $name_name,
            'p' => $link_themoviedb_name . ' | ' . $link_imdb_name,
        );
        $page['subtitle'] = $name_name;
        $getView = 'name';
    }
    else
    {
        $page['subtitle'] = "SELECT NAME";
        $getView = 'getno';
    }
    
    // HTML
    require '_views/head.php';
    require '_views/navigation.php';
    require '_views/' . $getView . '.php';    
    require '_views/footer.php';
    require '_views/foot.php';
    
    function link_outward($url, $text)
    {
        $link   = "<a style=\"font-style: italic;\" target=\"_blank\" href=\"{$url}\">{$text}</a>";
        return $link;
    }
    
    /* something's wrong here */
    // bullet list function
    function li($category, $list, $offset)
    {
        $result             = array();
        $result["error"]    = NULL;
        if(!empty($list))
        {
            $result["list"]     = "<p><strong>{$category}:</strong></p>\n<ul>";
            $count              = count($list);
            for ($i=0; $i<$count; $i++)
            {
                $item           = htmlentities($list[$i]["id"], ENT_QUOTES, 'UTF-8');
                $result["list"] .= "\n<li>{$item}</li>";
            }
            $result["list"]     .= "\n</ul>";
        }
        return $result;
    }
    
    function redate($datestring)
    {
        // covers all dates including pre-1970 and especially pre-1900; reformats as "F d, Y"
        list($yyyy, $mm, $dd) = preg_split("/[- ]/", $datestring);
        $f      = date('F', mktime(0,0,0,$mm,1)); // full month name
        $d      = (int) $dd;
        $y      = (int) $yyyy;
        $redate = "{$f} {$d}, {$y}";
        return $redate;        
    }