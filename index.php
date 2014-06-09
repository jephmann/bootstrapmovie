<?php
    $page = array (
        'path' => NULL,
        'template' => 'cover',
    );
    require '_views/head.php';
    require '_views/'. $page['template'].'.php';
    require '_views/foot.php';
?>