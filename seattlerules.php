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
    <title>Seattlerules Wordpress Template</title>
    <script src="jquery-2.1.4.min.js"></script>
    <link rel="Stylesheet" href="seattlerulesanalogarchive.css" />
    <script type="text/javascript" src="seattlerulesanalogarchive.js"></script>  
</head>
<body>
Now Playing:<br />
<span id="artist"></span><br />
<span id="album"></span><br /> 
<span id="title"></span><br />   
<audio id="analogplayer" controls="" preload="none">
    <source src="" type="audio/mpeg">Your browser does not support the HTML5 Audio Tag for type="audio/mpeg"<br />
</audio><br />
<?php
$baseUrl = "http://localhost:8888";
$baseServerPath = "/Applications/MAMP/htdocs";
$artist = "Melvins";
$album = "live at the showbox market 20141018";

try{
        $songs = AnalogArchive::GetSongData();
        echo('<div class="divTable">');
        echo('<div class="divTableBody">');
        foreach($songs as $song) {
            if($song["artist"]===$artist && $song["album"]===$album) {
                $song["file"] = str_replace($baseServerPath,$baseUrl,$song["file"]);

                 echo("<div class='divTableRow' onclick='playSong(this);'>");
                 echo("<div class='divTableCell'>");

                 foreach($song as $field => $value) {
                     echo("<span class='$field' value='$value'>$field</span>: $value<br />");
                 }
                 echo('</div>');
                 echo('</div>');
            }
        }
        echo('</div>');
        echo('</div>');
    }
    catch(Exception $ex){
        echo("CANT GET MEDIA:".$ex->getMessage()."<br />trace:".$ex->getTraceAsString());
    }
    ?>
</body>

</html>

