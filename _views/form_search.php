<div class="jumbotron">
    <div class="container">
        <h2><?php echo $form_search['h2']; ?></h2>    
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form id="<?php echo $form_search['id']; ?>">
                    <div>
                        <input type="text" name="<?php
                            echo $form_search['text']['name']; ?>" placeholder="<?php
                            echo $form_search['text']['placeholder']; ?>" />
                        <input type="submit" value="<?php echo $form_search['submit']['value']; ?>" />
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div id="canvasloader-container" class="wrapper"></div>        
        </div>
        <div class="col-md-4">
            <div class="row" id='response'></div>        
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
