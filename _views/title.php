<?php require '_views/jumbotron.php'; ?>
<div class="container">   
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Details</h2>
            <p style="color:red; font-family: Courier, sans-serif; font-style: italic; font-weight: bold; background-color: yellow;">
                "<?php echo $title_tagline ?>"
            </p>            
            <?php echo $posters["data"]; ?> 
            <p>
                <?php echo $title_title; ?>
                >
                <?php echo $link_themoviedb_title; ?>
                |
                <?php echo $link_imdb_title; ?>
            </p>                
            <p>
                <strong>Runtime:</strong> <?php echo $title_runtime; ?> minutes
            </p>
            <p>
                <strong>Released:</strong> <?php echo date("F d, Y", $title_release_date); ?>
            </p>
            <?php
                echo $li_genres["list"];
                echo $li_companies["list"];
                echo $li_countries["list"];
                echo $li_languages["list"];
                echo $title_collection;
            ?>
        </div>
        <div class="col-md-4">
            <h2>Cast</h2>
            <?php
                echo $cast["data"];
            ?>
        </div>
        <div class="col-md-4">
            <h2>Crew</h2>            
            <?php echo $backdrops["data"]; ?>                 
            <?php
                echo $crew["data"];
            ?>
        </div>
    </div>
    <hr>
    <pre>
        <?php print_r($data_title); ?>
    </pre>
    <pre>
        <?php print_r($data_title_credits); ?>
    </pre>
    <pre>
        <?php print_r($data_title_images); ?>
    </pre>
</div>