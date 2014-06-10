<?php require '_views/jumbotron.php'; ?>
<div class="container">   
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Details</h2>
            <p>
                <?php echo $title_overview; ?>
            </p>                
            <p>
                <strong>Runtime:</strong> <?php echo $title_runtime; ?> minutes
            </p>
            <p>
                <strong>Released:</strong> <?php echo $display_release_date; ?>
            </p>
            <?php
                echo $li_genres["list"];
                echo $li_companies["list"];
                echo $li_countries["list"];
                echo $li_languages["list"];
                echo $title_collection;
            ?>
            <pre>
                In case of emergency uncomment.
                <?php //print_r($data_title); ?>
            </pre>
        </div>
        <div class="col-md-4">
            <h2>Cast</h2>
            <?php
                echo $display_cast;
            ?>
            <pre>
                In case of emergency uncomment.
                <?php //print_r($data_credits); ?>
            </pre>
        </div>
        <div class="col-md-4">
            <h2>Crew</h2>              
            <?php
                echo $display_crew;
            ?>
            <p>
            <?php echo $backdrops["data"]; ?>
            </p>
            <p style="color:red; font-family: Courier, sans-serif; font-style: italic; font-weight: bold;">
                "<?php echo $title_tagline ?>"
            </p>
            <p>
            <?php echo $posters["data"]; ?>
            </p>
            <pre>
                In case of emergency uncomment.
                <?php //print_r($data_title_images); ?>
            </pre>
        </div>
    </div>
    <hr>
</div>