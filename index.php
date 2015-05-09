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
        <!--google analytics vvv-->
        <script type="text/javascript" src="googleanalytics.js"></script>
      <!--google analytics ^^^-->
    <center>
        <table>
            <tr><td id="albumarttd">
                    <img id="albumart" src="favicon.ico" alt="" />
            </td><td>
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
                </td></tr>
        </table>
        <div class="control">
            <input type="button" id="clear" value="Clear Playlist"/>
        </div>
        <div id="playlistdiv">

            
            <ul id="analogplaylist">
            </ul>
        </div>
        
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
        <ul>
        <li>This site will never have advertising nor anything for sale.</li>
        <li>Vinyl mp3s ripped at 192kbps.  Live recordings PCM 48 kHz/24bit converted to 192kbps mp3s</li>
        <li>Buy these lps at your local record store if you like them. I did.</li>  
        <li>If you cant find them at your local record store, try <a href=http://www.discogs.com/>discogs.com/<a> Fuck Amazon.</li>
        </ul>
        </center>
    </body>

</html>

