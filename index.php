<?php
    $page = array (
        'path' => NULL,
        'template' => 'cover',
        'subtitle' => 'BootStrap MovieDataBase',
    );
    require '_views/head.php';
    require '_views/'. $page['template'].'.php';
    require '_views/foot.php';
?>