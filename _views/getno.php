<div class="container">
    <p>
        This is a view file I "swap" in case I have a link without a querystring
        parameter for a person or movie id.
        Until I build search forms, feel free to click on either of these links
        and then keep clicking for cross-references.
    </p>
    <ul>
        <li><a href="title.php?id=11235">Local Hero</a></li>
        <li><a href="name.php?id=8635">Buster Keaton</a></li>
    </ul>
    
    <form id="formTitle">
        <div>
            <input type='text' name='title' placeholder="All or part of a movie title" />
            <input type='submit' value='Get Title Stuff' />
        </div>
    </form>
    
    <hr>
    
    <form id="formName">
        <div>
            <input type='text' name='name' placeholder="All or part of a person's name" />
            <input type='submit' value='Get Name Stuff' />
        </div>
    </form>
    
    <hr>
    
    <!-- Create a div which will be the canvasloader wrapper -->	
    <div id="canvasloader-container" class="wrapper"></div>

    <!-- Example row of columns -->
    <div class="row" id='response'>


    </div>
    
    
    <script src="http://heartcode-canvasloader.googlecode.com/files/heartcode-canvasloader-min-0.9.1.js"></script>
    <script>
        $(document).ready(function(){

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
        });
    </script>
        
</div>