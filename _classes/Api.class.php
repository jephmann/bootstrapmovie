<?php
    /**
     * Description of Api
     *
     * @author Jeffrey
     */
    class Api
        {
            private $key = NULL;
            private $url = NULL;
            
            public static function json_retrieve($json_url)
            {
                $json = file_get_contents($json_url);
                return json_decode($json, true); 
            }

        }