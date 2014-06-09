<?php require '_views/jumbotron.php'; ?>
<div class="container">
    <?php //echo $posters["data"]; ?>    
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Details</h2>
            <?php echo $profiles["data"]; ?>
            <p>
                <?php //echo $title_title ?>
                >
                <?php echo $link_themoviedb_name; ?>
                |
                <?php echo $link_imdb_name; ?>
            </p>
            <?php
                echo $name_born_died;
                echo $li_aka['list'];
            ?>
        </div>
        <div class="col-md-4">
            <h2>As Performer</h2>
            <?php
                echo $cast["data"];
            ?>
        </div>
        <div class="col-md-4">
            <h2>Additional Credits</h2>                
            <?php
                echo $crew["data"];
            ?>
        </div>
    </div>
    <hr>
    <pre>
        <?php print_r($data_name); ?>
    </pre>
    <pre>
        <?php print_r($data_name_credits); ?>
    </pre>
    <pre>
        <?php print_r($data_name_images) ?>
    </pre>
</div>