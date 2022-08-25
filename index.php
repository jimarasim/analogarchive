<?php

include 'AnalogArchive.php'; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
<head>
    <title>Analog Archive</title>
    <link rel="Stylesheet" href="stylebase.css" />
    <link rel="Shortcut Icon" href="favicon.ico" />
    <script src="jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="analogarchivecodebase.js"></script>  
</head>
<body>
<center>
    <table>
        <tr>
            <td id="albumarttd">
                <img id="albumart" src="favicon.ico" alt="" />
            </td>
            <td>
                <h2>Analog Archive</h2>
                <div id="currentsong">
                    <b class="current">Artist:</b><span id="artist"></span>
                    <b class="current">Album:</b><span id="album"></span>
                    <b class="current">Title:</b><span id="title"></span>
                    <b class="current">Track:</b><span id="track"></span>
                    <b class="current"></b><a id="file" href="" download=""><img src="download_button.png" /></a>
                </div>
                <br />
                <audio id="analogplayer" controls="" preload="none">
                    <source src="" type="audio/mpeg">Your browser does not support the HTML5 Audio Tag for type="audio/mpeg"<br />
                </audio>
            </td>
            <td>
                <ul>
                    <li>This site is dedicated to rare recordings; to preserve those that cannot easily be found via modern day streaming services, nor saved elsewhere</li>
                    <li>Vinyl mp3s ripped at 192kbps</li>
                    <li>Buy these at <b><a href="https://discogs.com">discogs.com</a></b> or your local record store.</li>
                    </li>
                </ul>
            </td>
        </tr>
    </table>
    <div class="control">
        <input type="button" id="clear" value="Clear Playlist"/>
    </div>
    <?php
                            $queryString = filter_input(INPUT_GET, 'mediaFolder');
                            
                            if($queryString==='analog') {
                                echo("<b><a class='highlighted' href='/?mediaFolder=analog'>ANALOG</a></b> ");
                                echo("<a href='/?mediaFolder=live'>LIVE</a> ");
                                echo("<a href='/?mediaFolder=digital'>DIGITAL</a> ");
                            } else if ($queryString==='digital') {
                                echo("<a href='/?mediaFolder=analog'>ANALOG</a> ");
                                echo("<a href='/?mediaFolder=live'>LIVE</a> ");
                                echo("<b><a class='highlighted' href='/?mediaFolder=digital'>DIGITAL</a></b> ");
                            } else {
                                echo("<a href='/?mediaFolder=analog'>ANALOG</a> ");
                                echo("<b><a class='highlighted' href='/?mediaFolder=live'>LIVE</a></b> ");
                                echo("<a href='/?mediaFolder=digital'>DIGITAL</a> ");
                            }
                        ?>
    <div id="playlistdiv">
        <ul id="analogplaylist">
        </ul>
    </div>
<?php
    try{
        AnalogArchive::CatalogMedia();
    }
    catch(Exception $ex){
        echo("CANT GET MEDIA:".$ex->getMessage()."<br />trace:".$ex->getTraceAsString());
    }
?>
</center>   
</body>

</html>

