/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//setup events after the page is loaded
document.addEventListener('DOMContentLoaded', function () {

    SetupEvents();

});


//setup events, like for links that sort the table
function SetupEvents()
{
    //AUDIO PLAYER SONG ENDED
    $('#analogplayer').bind("ended", function(){
        var currentFile = $(this).children(":first").attr('src');
        PlayNextTrack(currentFile);
    });

    //PLAYLIST CLEAR
    $('#clear').click(function(){
        //clear the playlist
        $('#analogplaylist').empty();

        //uncheck all the songs
        $("input[type='checkbox']").attr('checked',false);
    });

    //SORT EVENTS

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

//USED BY SORTING EVENTS TO GET A FORMATTED TABLE ROW FOR A SONG
function GetSongRow(file,artist,album,title,track)
{
    ///build table row in a message string
    var row = "<tr>";
    row += "<td name='artist'><input type='checkbox' id='"+file+"' onclick='AddRemovePlaylistItem(this)'/>"+artist+"</td>";
    row += "<td name='album'>"+album+"</td>";
    row += "<td name='title'>"+title+"</td>";
    row += "<td name='track'>"+track+"</td>";
    row += "<td><a href='"+file+"' target='_blank'>"+file+"</a></td>";

    row += "</tr>";

    return row;
}

//USED TO ADD/REMOVE PLAYLIST ITEMS WHEN CHECKED
function AddRemovePlaylistItem(checkbox)
{
    //if the checkbox was checked, add it to the play list; otherwise, remove it from the playlist
    if(checkbox.checked)
    {

        //don't add if already added
        if($('#analogplaylist > li:contains("'+checkbox.id+'")').length===0)
        {   
            $('#analogplaylist').append("<li onclick='PlayTrack(this.innerHTML)'>"+checkbox.id+"</li>");


            //start playing if this is the first item added
            if($('#analogplaylist > li').length===1)
            {
                PlayTrack(checkbox.id);
            }
        }


    }
    else
    {
        $('#analogplaylist > li:contains("'+checkbox.id+'")').remove();
    }
}

//USED TO PLAY NEXT TRACK IN THE PLAYLIST
function PlayNextTrack(currentFile)
{

    //get the next track, if there isn't one, use the first one
    if($('#playlistdiv li:contains("'+currentFile+'")').next().text().length!==0)
    {
        PlayTrack($('#playlistdiv li:contains("'+currentFile+'")').next().text());
    }
    else
    {
        PlayTrack($('#playlistdiv li').first().text());
    }


}

//USED TO PLAY THE TRACK CLICKED
function PlayTrack(trackstring)
{


    //update player
    $('#analogplayer > source').attr('src',trackstring);
    document.getElementById("analogplayer").load();
    document.getElementById("analogplayer").play();

    //update "Playing" value
    var $fileTd = $("td > a:contains('"+trackstring+"')").parent();
    var artist = $fileTd.prevAll("td[name='artist']").text();
    var album = $fileTd.prevAll("td[name='album']").text();
    var title = $fileTd.prevAll("td[name='title']").text();
    var track = $fileTd.prevAll("td[name='track']").text();
    $("#artist").text(artist);
    $("#album").text(album);
    $("#title").text(title);
    $("#track").text(track);
    $("#file").text(trackstring);
    $("#file").attr("href",trackstring);

    //get the album artwork
    $.ajax({
        url: "FindArtwork.php?filePath="+trackstring,
        cache: false,
        type: "GET"
      })
        .success(
            function( data ) {
              if(data=="")
              {
                  //set default image if nothing returned
                  $('#albumart').attr('src','favicon.ico');
              }
              else
              {
                  //set returned album art
                  $('#albumart').attr('src',data);
                  $('body').css('background-image','url('+data+')');
              }
            }
        );
//                    
//                $.get("FindArtwork.php?artist="+encodeURIComponent(artist)+"&album="+encodeURIComponent(album),function( data ) {
//                    $('#albumart').attr('alt',data);
//                  });

}