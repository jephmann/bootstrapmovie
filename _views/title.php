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
                <strong>Original Title:</strong> <em><?php echo $title_original_title; ?></em>
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
            <hr />
            <details>
                <summary>Raw Data (Title)</summary>
                <pre>
                    <?php print_r($data_title); ?>
                </pre>                
            </details>
        </div>
        <div class="col-md-4">
            <h2>Cast</h2>
            <?php
                echo $display_cast;
            ?>
            <hr />
            <details>
                <summary>Raw Data (Cast and Crew credits)</summary>
                <pre>
                    <?php print_r($data_credits); ?>
                </pre>                
            </details>
        </div>
        <div class="col-md-4">
            <h2>Production</h2>              
            <?php
                echo $display_sorted_jobs
            ?>
            <p>
            <?php echo $backdrops["data"]; ?>
            </p>
            <p>
            <?php echo $posters["data"]; ?>
            </p>
            <hr />
            <details>
                <summary>Raw Data (Images)</summary>
                <pre>
                    <?php print_r($data_images); ?>
                </pre>                
            </details>
        </div>
    </div>
    <hr>
</div>