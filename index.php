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
    </head>
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
        <script>

            //setup events after the page is loaded
            document.addEventListener('DOMContentLoaded', function () {

                SetupEvents();

            });
    
    
            //setup events, like for links that sort the table
            function SetupEvents()
            {
                //create events to empty table and sort it 
                $('#fileSort').click(function(){
                    
                    //clear the table
                    $('#songsTable').empty();

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.file, b1= b.file;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
                    $("#songsTable").append("<tr><td>FILE</td><td>ARTIST</td><td>ALBUM</td><td>TITLE</td><td>TRACK</td></tr>");
                    for (var i=0;i<sorted.length;i++)
                    { 
                        $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track));
                    }
                    
                });
                
                $('#artistSort').click(function(){
                    
                    //clear the table
                    $('#songsTable').empty();

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.artist, b1= b.artist;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
                    $("#songsTable").append("<tr><td>FILE</td><td>ARTIST</td><td>ALBUM</td><td>TITLE</td><td>TRACK</td></tr>");
                    for (var i=0;i<sorted.length;i++)
                    { 
                        $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track));
                    }
                    
                });
                
                $('#albumSort').click(function(){

                    //clear the table
                    $('#songsTable').empty();

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.album, b1= b.album;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
                    $("#songsTable").append("<tr><td>FILE</td><td>ARTIST</td><td>ALBUM</td><td>TITLE</td><td>TRACK</td></tr>");
                    for (var i=0;i<sorted.length;i++)
                    { 
                        $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track));
                    }

                });


                $('#titleSort').click(function(){

                    //clear the table
                    $('#songsTable').empty();

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.title, b1= b.title;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
                    $("#songsTable").append("<tr><td>FILE</td><td>ARTIST</td><td>ALBUM</td><td>TITLE</td><td>TRACK</td></tr>");
                    for (var i=0;i<sorted.length;i++)
                    { 
                        $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track));
                    }
                });
            }

            function GetSongRow(file,artist,album,title,track)
            {
                ///build table row in a message string
                var row = "<tr>";
                row += "<td><a href='"+file+"' target='_blank'>"+file+"</a></td>";
                row += "<td>"+artist+"</td>";
                row += "<td>"+album+"</td>";
                row += "<td>"+title+"</td>";
                row += "<td>"+track+"</td>";
                row += "</tr>";
                
                return row;
            }
</script>
    </body>
</html>

