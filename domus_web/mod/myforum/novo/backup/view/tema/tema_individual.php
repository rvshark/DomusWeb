<div>
       <div id='tema'>
           <center>
               <br>
                <h2 class='tema'><?php echo $controlador->tema->name ?></h2>
           </center>
           <div class='problema' style='height:100%; overflow:auto; padding:10px'>
               <b>Problema</b>
               <hr>
                 <?php echo preg_replace('/(\\\\){2,}/','\\', preg_replace('/\\\"/','"',$controlador->tema->intro))  ?>
           </div>
       </div>
</div>