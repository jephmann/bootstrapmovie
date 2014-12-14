<?php
    $page = array (
        'path' => NULL,
        'template' => 'jumbotron',
        'subtitle' => 'BootStrap MovieDataBase',
    );
    $jumbotron = array (
        'h1' => 'Greetings from BSMDB!',
        'p' => 'A line or two of introductory text.',    
    );
    $btn_themoviedb = NULL;
    $btn_imdb       = NULL;
    require '_views/head.php';
    require '_views/navigation.php';
    require '_views/jumbotron.php';
    require '_views/learn.php';
    require '_views/footer.php';
    require '_views/foot.php';
?>