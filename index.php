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
                
                //SORT BY FILE 
                $('#fileSort').click(function(){
                    
                    //clear the table
                    //$('#songsTable').empty(); //all rows
                    $('#songsTable').find("tr:gt(0)").remove(); //all but first row

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.file, b1= b.file;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
                    for (var i=0;i<sorted.length;i++)
                    { 
                        $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track));
                    }
                    
                });
                
                //SORT BY ARTIST (then album, then track, then title, then file)
                $('#artistSort').click(function(){
                    
                    //$('#songsTable').empty();
                    $('#songsTable').find("tr:gt(0)").remove(); //all but first row

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.artist+a.album+a.track+a.title+a.file, b1= b.artist+b.album+b.track+b.title+b.file;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
                    for (var i=0;i<sorted.length;i++)
                    { 
                        $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track));
                    }
                    
                });
                
                //SORT BY ALBUM (then track, then title, then artist, then file)
                $('#albumSort').click(function(){

                    //$('#songsTable').empty();
                    $('#songsTable').find("tr:gt(0)").remove(); //all but first row

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.album+a.track+a.title+a.artist+a.file, b1= b.album+b.track+b.title+b.artist+b.file;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
                    for (var i=0;i<sorted.length;i++)
                    { 
                        $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track));
                    }

                });

                //SORT BY TITLE (then artist, then album, then track, then file)
                $('#titleSort').click(function(){

                    //$('#songsTable').empty();
                    $('#songsTable').find("tr:gt(0)").remove(); //all but first row

                    //sort the friends by name
                    var sorted = songsarray.sort(function(a, b){
                        var a1= a.title+a.artist+a.album+a.track+a.file, b1= b.title+b.artist+b.album+b.track+b.file;
                        if(a1=== b1) return 0;
                        return a1> b1? 1: -1;
                    });

                    //update the table
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

