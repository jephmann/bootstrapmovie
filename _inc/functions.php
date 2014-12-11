<?php
    
    function link_outward($url, $text)
    {
        $link   = "<a style=\"font-style: italic;\" target=\"_blank\" href=\"{$url}\">{$text}</a>";
        return $link;
    }
    
    function redate($datestring)
    {
        /*
         * covers all dates including pre-1970 and especially pre-1900;
         * reformats as "F d, Y"
         * -- provided that the datestring is not null or empty
         */
        $redate = array();
        list($yyyy, $mm, $dd) = preg_split("/[- ]/", $datestring);
        $f = date('F', mktime(0,0,0,$mm,1)); // full month name
        $d = (int) $dd;
        $y = (int) $yyyy;
        $redate['year'] = $y;
        $redate['day'] = $d;
        $redate['month'] = $f;
        $redate['date'] = "{$f} {$d}, {$y}";
        return $redate;
    }
    
    function sanitize($post, $search)
    {
        /*
         * sanitzes input data;
         * $post = incoming string via input or other means
         * $search = boolean re whether or not we use this string in a search
         */
        $result = filter_input(INPUT_POST, $post, FILTER_SANITIZE_STRING);
        if($search == TRUE)
        {
            $result = str_replace(' ', '+', $result);
        }
        return $result;
    }
    
    function is_today($month, $day)
    {
        /*
         * compares the month and day of a date to today's month and day,
         * regardless of year
         */
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