<?php require '_views/jumbotron.php'; ?>
<div class="container">
    <?php //echo $posters["data"]; ?>    
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Details</h2>
            <?php
                echo $display_profiles;
                echo $name_born_died;
                echo $li_aka['list'];
            ?>
            <p>
                <?php echo $name_biography; ?>
            </p>
            <pre>
                In case of emergency uncomment.
                <?php //print_r($data_name); ?>
            </pre>
        </div>
        <div class="col-md-4">
            <h2>As Performer</h2>
            <?php
                echo $display_cast;
            ?>
            <pre>
                In case of emergency uncomment.
                <?php //print_r($data_credits); ?>
            </pre>
        </div>
        <div class="col-md-4">
            <h2>Additional Credits</h2>                
            <?php
                echo $display_crew;
            ?>
        </div>
        <pre>
                In case of emergency uncomment.
            <?php //print_r($data_images) ?>
        </pre>
    </div>
    <hr>
</div>