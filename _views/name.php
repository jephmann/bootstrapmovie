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
            <details>
                <summary>Raw Data (Title)</summary>
                <pre>
                    <?php print_r($data_name); ?>
                </pre>                
            </details>
        </div>
        <div class="col-md-4">
            <h2>As Performer</h2>
            <?php
                echo $display_cast;
            ?>
            <details>
                <summary>Raw Data (Cast and Crew credits)</summary>
                <pre>
                    <?php print_r($data_credits); ?>
                </pre>                
            </details>
        </div>
        <div class="col-md-4">
            <h2>Additional Credits</h2>                
            <?php
                echo $display_crew;
            ?>
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