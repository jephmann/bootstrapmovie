        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="<?php echo $page['path']; ?>js/bootstrap.min.js"></script>
        <script src="http://heartcode-canvasloader.googlecode.com/files/heartcode-canvasloader-min-0.9.1.js"></script>
<script>
    $(document).ready(function(){

        $('#formName').submit(function(){
            
            var cl = new CanvasLoader('canvasloader-container');
            cl.show(); // Hidden by default
            // This bit is only for positioning - not necessary
            var loaderObj = document.getElementById("canvasLoader");
            loaderObj.style.position = "absolute";
            loaderObj.style["top"] = cl.getDiameter() * -0.5 + "px";
            loaderObj.style["left"] = cl.getDiameter() * -0.5 + "px";

            // show that something is loading
            $('#response').html("<b>Loading...</b>");

            /*
             * 'search.php' - where you will pass the form data
             * $(this).serialize() - to easily read form data
             * function(data){... - data contains the response from search.php
             */
            $.post('search_name.php', $(this).serialize(), function(data){

                // show the response
                $('#response').html(data);

                cl.hide();

            }).fail(function() {

                // just in case posting your form failed
                alert( "Posting failed." );

                cl.hide();

            });

            // to prevent refreshing the whole page page
            return false;

        });

        $('#formTitle').submit(function(){

            var cl = new CanvasLoader('canvasloader-container');
            cl.show(); // Hidden by default
            // This bit is only for positioning - not necessary
            var loaderObj = document.getElementById("canvasLoader");
            loaderObj.style.position = "absolute";
            loaderObj.style["top"] = cl.getDiameter() * -0.5 + "px";
            loaderObj.style["left"] = cl.getDiameter() * -0.5 + "px";

            // show that something is loading
            $('#response').html("<b>Loading...</b>");

            /*
             * 'search.php' - where you will pass the form data
             * $(this).serialize() - to easily read form data
             * function(data){... - data contains the response from search.php
             */
            $.post('search_title.php', $(this).serialize(), function(data){

                // show the response
                $('#response').html(data);

                cl.hide();

            }).fail(function() {

                // just in case posting your form failed
                alert( "Posting failed." );

                cl.hide();

            });

            // to prevent refreshing the whole page page
            return false;

        });
            
      });
    </script>
    </body>
</html>