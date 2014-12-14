<?php
    $active = " class=\"active\"";
    switch ($page['file']):
        case 'learn':
            $active_learn   = $active;
            $active_title   = NULL;
            $active_name    = NULL;
            $active_about   = NULL;
            $active_contact = NULL;
            break;
        case 'title':
            $active_learn   = NULL;
            $active_title   = $active;
            $active_name    = NULL;
            $active_about   = NULL;
            $active_contact = NULL;
            break;
        case 'name':
            $active_learn   = NULL;
            $active_title   = NULL;
            $active_name    = $active;
            $active_about   = NULL;
            $active_contact = NULL;
            break;
        case 'about':
            $active_learn   = NULL;
            $active_title   = NULL;
            $active_name    = NULL;
            $active_about   = $active;
            $active_contact = NULL;
            break;
        case 'contact':
            $active_learn   = NULL;
            $active_title   = NULL;
            $active_name    = NULL;
            $active_about   = NULL;
            $active_contact = $active;
            break;
        default:
            $active_learn   = NULL;
            $active_title   = NULL;
            $active_name    = NULL;
            $active_about   = NULL;
            $active_contact = NULL;
            break;
    endswitch;
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $page['path']; ?>index.php">BSMDB: BootStrap MovieDataBase</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo $page['path']; ?>index.php">Home</a></li>
                    <li<?php echo $active_learn; ?>><a href="<?php echo $page['path']; ?>learn.php">Learn</a></li>
                    <li<?php echo $active_title; ?>><a href="<?php echo $page['path']; ?>title.php">By Movie Title</a></li>
                    <li<?php echo $active_name; ?>><a href="<?php echo $page['path']; ?>name.php">By Person's Name</a></li>
                    <li<?php echo $active_about; ?>><a href="<?php echo $page['path']; ?>about.php">About</a></li>
                    <li<?php echo $active_contact; ?>><a href="<?php echo $page['path']; ?>contact.php">Contact</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
