<?php

include 'AnalogArchive.php'; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html><head>
        <title>Analog Archive</title>
        <link rel="Stylesheet" href="stylebase.css" />
        <link rel="Shortcut Icon" href="favicon.ico" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="analogarchivecodebase.js"></script>  
    </head>
    <body>
        <h1>Analog Archive</h1>
        
        <div id="currentsong">
        <b class="current">Artist:</b><span id="artist"></span>
       
        <b class="current">Album:</b><span id="album"></span>
        
        <b class="current">Title:</b><span id="title"></span>
        
        <b class="current">Track:</b><span id="track"></span>
        
        <b class="current">File:</b><a id="file" href="" target="_blank"></a>
        </div>
        <br />
        <audio id="analogplayer" controls="" preload="none">
            <source src="" type="audio/mpeg">
            Your browser doesn't support the HTML5 Audio Tag for type="audio/mpeg"<br />
        </audio>
        <br />
        <img id="albumart" src="favicon.ico" alt="" />
        
        <br />
        Playlist:<br />
        <div id="playlistdiv">

            <input type="button" id="clear" value="Clear Playlist"/><br />
            <ul id="analogplaylist">
            </ul>
        </div>
        <br />
        Check songs to add to Playlist:<br />
        <div id="songlistdiv">
        <?php
            
            
            try
            {
                AnalogArchive::CatalogMedia();
            }
            catch(Exception $ex)
            {
                echo("CANT GET MEDIA:".$ex->getMessage()."<br />trace:".$ex->getTraceAsString());
            }
            
        ?>
        </div>
        
    </body>
</html>

