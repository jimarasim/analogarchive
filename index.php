<?php

include 'AnalogArchive.php'; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html><head><title>Analog Archive</title></head>
    <body>
        <?php
            echo(AnalogArchive::GetHostUrl()."<br /><hr>");
            
            try
            {
                AnalogArchive::CatalogMedia();
            }
            catch(Exception $ex)
            {
                echo("exception:".$ex->getMessage()."<br />trace:".$ex->getTraceAsString());
            }
        ?>
    </body>
</html>

