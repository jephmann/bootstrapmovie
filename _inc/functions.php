<?php
    
    function link_outward($url, $text)
    {
        $link   = "<a style=\"font-style: italic;\" target=\"_blank\" href=\"{$url}\">{$text}</a>";
        return $link;
    }
    
    function redate($datestring)
    {
        // covers all dates including pre-1970 and especially pre-1900; reformats as "F d, Y"
        $redate = NULL;
        if (!empty($datestring))
        {
            list($yyyy, $mm, $dd) = preg_split("/[- ]/", $datestring);
            $f      = date('F', mktime(0,0,0,$mm,1)); // full month name
            $d      = (int) $dd;
            $y      = (int) $yyyy;
            $redate = "{$f} {$d}, {$y}";
        }
        return $redate;        
    }
    
    function sanitize($post)
    {
        $string = filter_input(INPUT_POST, $post, FILTER_SANITIZE_STRING);
        $result = str_replace(' ', '+', $string);
        return $result;
    }
    
    function is_today($month, $day)
    {
        $result = NULL;
        if((date('F') == $month) and (date('d') == $day))
        {
            $result = TRUE;
        }
        else
        {
            $result = FALSE;
        }
        return $result;
        
    }