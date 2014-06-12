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
    
        $objTitle       = new Api;
        $urlTitle       = $objTitle->url_title($id);
        $data_title     = Api::retrieve($urlTitle);

        $objCredits     = new Api;
        $urlCredits     = $objCredits->url_title_credits($id);
        $data_credits   = Api::retrieve($urlCredits);

        $objImages      = new Api;
        $urlImages      = $objImages->url_title_images($id);
        $data_images    = Api::retrieve($urlImages);
        
        /*
         * REDUNDANT ID DATA
         * $title_id    = htmlentities($data_title["id"], ENT_QUOTES, 'UTF-8');         * 
         * $title_id    = htmlentities($data_credits["id"], ENT_QUOTES, 'UTF-8');;
         * $title_id    = htmlentities($data_images["id"], ENT_QUOTES, 'UTF-8');
         */
        
        /* title stuff (all of it, whether I use all of it or not) */
        $title_tt                   = htmlentities($data_title["imdb_id"], ENT_QUOTES, 'UTF-8');        // tt#######
        $title_original_title       = htmlentities($data_title["original_title"], ENT_QUOTES, 'UTF-8'); // == or != title
        $title_title                = htmlentities($data_title["title"], ENT_QUOTES, 'UTF-8');          // == or !=
        $title_adult                = htmlentities($data_title["adult"], ENT_QUOTES, 'UTF-8');          // null?
        $title_backdrop_path        = htmlentities($data_title["backdrop_path"], ENT_QUOTES, 'UTF-8');  // "/somethingsomething.jpg"
        $title_budget               = htmlentities($data_title["budget"], ENT_QUOTES, 'UTF-8');         // integer 0?
        $title_homepage             = htmlentities($data_title["homepage"], ENT_QUOTES, 'UTF-8');       // null? original_title
        $title_overview             = htmlentities($data_title["overview"], ENT_QUOTES, 'UTF-8');
        $title_popularity           = htmlentities($data_title["popularity"], ENT_QUOTES, 'UTF-8');
        $title_poster_path          = htmlentities($data_title["poster_path"], ENT_QUOTES, 'UTF-8');    // "/somethingsomething.jpg"
        $title_revenue              = htmlentities($data_title["revenue"], ENT_QUOTES, 'UTF-8');        // integer 0?
        $title_runtime              = htmlentities($data_title["runtime"], ENT_QUOTES, 'UTF-8');        // integer of minutes
        $title_status               = htmlentities($data_title["status"], ENT_QUOTES, 'UTF-8');         // whether it's released or not
        $title_tagline              = htmlentities($data_title["tagline"], ENT_QUOTES, 'UTF-8');
        $title_vote_average         = htmlentities($data_title["vote_average"], ENT_QUOTES, 'UTF-8');   // integer?
        $title_vote_count           = htmlentities($data_title["vote_count"], ENT_QUOTES, 'UTF-8');     // integer
        // arrays (no "htmlentities" until looping)
        $title_genres                   = $data_title["genres"];
        $title_production_companies     = $data_title["production_companies"];
        $title_production_countries     = $data_title["production_countries"];
        $title_spoken_languages         = $data_title["spoken_languages"];
        $title_belongs_to_collection    = $data_title["belongs_to_collection"];
        // dates
        $title_release_date         = htmlentities($data_title["release_date"], ENT_QUOTES, 'UTF-8');    // YYYY-MM-DD
        
        if (empty($title_release_date))
        {
            $title_year         = '[??]';
            $display_release_date = 'Unknown';
        }
        else
        {
            $title_year         = date('Y', strtotime($title_release_date));
            $display_release_date = redate($title_release_date);
        }

        // strings
        $url_imdb_title                 = "{$url_imdb}title/{$title_tt}/fullcredits";
        $link_imdb_title                = link_outward($url_imdb_title, "IMDB");    
        $url_themoviedb_title_format    = str_replace(' ','-',strtolower($title_title));
        $url_themoviedb_title           = "{$url_themoviedb}movie/{$id}-{$url_themoviedb_title_format}";
        $link_themoviedb_title          = link_outward($url_themoviedb_title, "TheMovieDB");
        
        $display_tagline = NULL;
        if(!empty($title_tagline))
        {
            $display_tagline = "<em>{$title_tagline}</em></p>";
        }

        // lists
        $li_genres      = li("Genre", $title_genres);
        $li_companies   = li("Production Companies", $title_production_companies);
        $li_countries   = li("Production Countries", $title_production_countries);
        $li_languages   = li("Spoken Languages", $title_spoken_languages);
        $title_collection = "<p><strong>Collection Notes:</strong></p>";
        $title_collection .= "<ul>";
        $title_collection .= "<li>" . htmlentities($title_belongs_to_collection["name"], ENT_QUOTES, 'UTF-8') . "</li>";
        $title_collection .= "</ul>";
    
        /* credits (all of it, whether I use all of it or not) */
        
        // arrays (no "htmlentities" until looping)
        $cast = $data_credits["cast"];
        $crew = $data_credits["crew"];

        // lists
        
        $display_cast   = NULL;
        if (empty($cast))
        {
            $display_cast   = "<p>NO CAST CREDITS</p>";
        }
        else
        {
            // sort cast
            foreach ($cast as $key => $row)
            {
                $cast_order[$key] = $row['order'];
            }
            array_multisort($cast_order, SORT_ASC, $cast);
            // display cast
            for ($i = 0; $i < count($cast); $i++)
            {
                $order          = htmlentities($cast[$i]["order"], ENT_QUOTES, 'UTF-8');
                $cast_id        = htmlentities($cast[$i]["cast_id"], ENT_QUOTES, 'UTF-8');
                $id             = htmlentities($cast[$i]["id"], ENT_QUOTES, 'UTF-8');
                $credit_id      = htmlentities($cast[$i]["credit_id"], ENT_QUOTES, 'UTF-8');
                $profile_path   = htmlentities($cast[$i]["profile_path"], ENT_QUOTES, 'UTF-8');
                $name           = htmlentities($cast[$i]["name"], ENT_QUOTES, 'UTF-8');
                $character      = htmlentities($cast[$i]["character"], ENT_QUOTES, 'UTF-8');
                $display_cast   .= "\n<p>"
                    . "<a style=\"font-weight: bold; text-decoration: none;\" href=\"name.php?id={$id}\">"
                    . "{$name}"
                    . "</a>";
                if (!empty($character))
                {
                    $display_cast .= "\n<br />&nbsp;<em>as</em> {$character}";
                }
                $display_cast .= "</p>";
            }
        }
                                                                                                                                                                              
        $display_sorted_jobs = NULL;
        if(empty($crew))
        {
            $display_sorted_jobs   = "<p>NO ADDITIONAL CREDITS</p>";
        }
        else
        {
            foreach($crew as $item)
            {
                $sortedjobs[] = $item['job'];
            }
            $sortedjobs = array_unique($sortedjobs);
            foreach($sortedjobs as $ky => $rw)
            {
                $jb[$ky] = $rw;
            }
            array_multisort($jb, SORT_ASC, $sortedjobs);
            foreach ($sortedjobs as $jobcategory)
            {
                $display_sorted_jobs .= "\n<p><strong>{$jobcategory}</strong>";
                // sort crew
                foreach ($crew as $key => $row)
                {
                    $crew_name[$key] = $row['name'];
                }
                array_multisort($crew_name, SORT_ASC, $crew);
                // display crew
                for ($j =0; $j < count($crew); $j++)
                {
                    $id             = htmlentities($crew[$j]["id"], ENT_QUOTES, 'UTF-8');
                    $credit_id      = htmlentities($crew[$j]["credit_id"], ENT_QUOTES, 'UTF-8');
                    $profile_path   = htmlentities($crew[$j]["profile_path"], ENT_QUOTES, 'UTF-8');
                    $department     = strtoupper(htmlentities($crew[$j]["department"], ENT_QUOTES, 'UTF-8'));
                    $job            = htmlentities($crew[$j]["job"], ENT_QUOTES, 'UTF-8');
                    $name           = htmlentities($crew[$j]["name"], ENT_QUOTES, 'UTF-8');
                    if ($job == $jobcategory) {
                    $display_sorted_jobs .= "\n<br />"
                        . "&nbsp<a style=\"font-weight: bold; text-decoration: none;\" href=\"name.php?id={$id}\">"
                        . "{$name}"
                        . "</a>";
                    }
                }    
                $display_sorted_jobs .= "\n</p>";
            } 
        }
        
        
        /* movie images */

        // data (all of it, whether I use all of it or not)

        // arrays (no "htmlentities" until looping)
        $title_backdrops    = $data_images["backdrops"];
        $title_posters      = $data_images["posters"];
        
        // lists
        $backdrops  = images($title_backdrops);
        $posters  = images($title_posters);
        
        $jumbotron = array(
            'h1' => '<em>' . $title_title  .'</em> ('. $title_year . ')',
            'p' => $display_tagline . '<p>' . $title_original_title . ' > ' . $link_themoviedb_title . ' | ' . $link_imdb_title,
        );
        $page['subtitle'] = $title_title;
        $getView = 'title';
    }
    else
    {
        $page['subtitle'] = "SELECT TITLE";
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
        if (!empty($list))
        {
            $result["list"]     = "<p><strong>{$category}:</strong></p>\n<ul>";
            $count              = count($list);
            for ($i=0; $i<$count; $i++)
            {
                $name           = htmlentities($list[$i]["name"], ENT_QUOTES, 'UTF-8');
                $result["list"] .= "\n<li>{$name}</li>";
            }
            $result["list"]     .= "\n</ul>";
        }
        else
        {
            $result["list"] = NULL;
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