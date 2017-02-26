<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html> 
<html lang="en">
    <head>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <?php echo $meta . $css .$js; ?>
    </head>
    <body>
        <?= $output; ?>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
    </body>
</html>