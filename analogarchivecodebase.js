/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//index.php/////////////////////////////////////////////////////////////////////////////
var allArtistsEnum='-ALL ARTISTS-';

//setup events after the page is loaded
document.addEventListener('DOMContentLoaded', function () {

    SetupEvents();
    SetupEvents2();

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
    
    //SORT BY MODIFIED DATE
    $('#modifiedDateSort').click(function(){
        
        //clear the table
        $('#songsTable').find("tr:gt(0)").remove(); //all but first row
        
        //sort the files by modified date
        var sorted = songsarray.sort(function(a, b){
            var a1= a.modifiedDate, b1= b.modifiedDate;
            if(a1=== b1) return 0;
            return a1< b1? 1: -1;
        });
       
        //update the table
        for (var i=0;i<sorted.length;i++)
        { 
            $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track,sorted[i].modifiedDate));
        }
    });

    //SORT BY FILE 
    $('#fileSort').click(function(){

        //clear the table
        $('#songsTable').find("tr:gt(0)").remove(); //all but first row

        //sort the files by file name
        var sorted = songsarray.sort(function(a, b){
            var a1= a.file, b1= b.file;
            if(a1=== b1) return 0;
            return a1> b1? 1: -1;
        });

        //update the table
        for (var i=0;i<sorted.length;i++)
        { 
            $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track,sorted[i].modifiedDate));
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
            $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track,sorted[i].modifiedDate));
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
            $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track,sorted[i].modifiedDate));
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
            $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track,sorted[i].modifiedDate));
        }
    });
    
    //select artist dropdown
    $("#artistFilter").change(function(){
        
        //get the chosen artist
        var filteredArtist = $("#artistFilter option:selected").attr('value');
        
        //clear the table
        $('#songsTable').find("tr:gt(0)").remove(); //all but first row

        //sort the SONGS by artist
        var sorted = songsarray.sort(function(a, b){
            var a1= a.artist+a.album+a.track+a.title+a.file, b1= b.artist+b.album+b.track+b.title+b.file;
            if(a1=== b1) return 0;
            return a1> b1? 1: -1;
        });

        //update the table with only the chosen artist
        for (var i=0;i<sorted.length;i++)
        { 
            //strip out the ampersand decode ampersand entity when comparing
            if(sorted[i].artist.replace(/&amp;/g, '&')===filteredArtist || filteredArtist===allArtistsEnum)
            {
                $("#songsTable").append(GetSongRow(sorted[i].file,sorted[i].artist,sorted[i].album,sorted[i].title,sorted[i].track,sorted[i].modifiedDate));
            }
        }
    });
}

//USED BY SORTING EVENTS TO GET A FORMATTED TABLE ROW FOR A SONG
function GetSongRow(file,artist,album,title,track,modifiedDate)
{
    ///build table row in a message string
    var row = "<tr>";
    row += "<td name='artist'><input type='checkbox' id='"+file+"' onclick='AddRemovePlaylistItem(this)'/>"+artist+"</td>";
    row += "<td name='album'>"+album+"</td>";
    row += "<td name='title'>"+title+"</td>";
    row += "<td name='track'>"+track+"</td>";
    row += "<td><a href='"+file+"' target='_blank'>"+file+"</a></td>";
    row += "<td name='modifiedDate'>"+modifiedDate+"</td>";

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
        if($('#analogplaylist > li[id="'+checkbox.id+'"]').length===0)
        {   
            var $fileTd = $("td > a[href='"+checkbox.id+"']").parent();
            var artist = $fileTd.prevAll("td[name='artist']").text();
            var album = $fileTd.prevAll("td[name='album']").text();
            var title = $fileTd.prevAll("td[name='title']").text();
            var track = $fileTd.prevAll("td[name='track']").text();
            $('#analogplaylist').append("<li id='"+checkbox.id+"' onclick='PlayTrack(this.id)'>"+artist+" | "+album+" | "+title+" | "+track+" | "+checkbox.id+"</li>");


            //start playing if this is the first item added
            if($('#analogplaylist > li').length===1)
            {
                PlayTrack(checkbox.id);
            }
        }


    }
    else
    {
        $('#analogplaylist > li[id="'+checkbox.id+'"]').remove();
        
    }
}

//USED TO PLAY NEXT TRACK IN THE PLAYLIST
function PlayNextTrack(currentFile)
{
    //don't do anything if there are no tracks
    if($('#playlistdiv li').length===0)
    {
        return;
    }

    //get the next track, if there isn't one, use the first one
    if($('#playlistdiv li[id="'+currentFile+'"]').next().text().length!==0)
    {
        PlayTrack($('#playlistdiv li[id="'+currentFile+'"]').next().attr('id'));
    }
    else if($('#playlistdiv li[id="'+currentFile+'"]').first().text().length!==0)
    {
        PlayTrack($('#playlistdiv li').first().attr('id'));
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
    var $fileTd = $("td > a[href='"+trackstring+"']").parent();
    var artist = $fileTd.prevAll("td[name='artist']").text();
    var album = $fileTd.prevAll("td[name='album']").text();
    var title = $fileTd.prevAll("td[name='title']").text();
    var track = $fileTd.prevAll("td[name='track']").text();
    $("#artist").text(artist);
    $("#album").text(album);
    $("#title").text(title);
    $("#track").text(track);
    //$("#file").text(trackstring);
    $("#file").attr("href",trackstring);
    $("#file").attr("download",artist+"-"+album+"-"+title);

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
              }
            }
        );
}

//index.html/////////////////////////////////////////////////////////////////////////////
var digitalSongs = new Array();
var analogSongs = new Array();
var liveSongs = new Array();
var songsArray = new Array();

function SetupEvents2() {
        //AUDIO PLAYER SONG ENDED
    $('#analogplayer2').bind("ended", function(){
        var currentIndex = document.getElementById("songs").selectedIndex;
        var nextIndex = ((++currentIndex) === (document.getElementById("songs").length))?0:currentIndex;
        document.getElementById("songs").selectedIndex = nextIndex;
        
        playSong(document.getElementById("songs").value);
    });
}

function getSongs(mediaFolder) {
    
    removeSongs();
    songsArray = [];
    
    switch(mediaFolder) {
        case 'digital':
            songsArray = digitalSongs;
            break;
        case 'analog':
            songsArray = analogSongs;
            break;
        case 'live':
            songsArray = liveSongs;
            break;
        default:
            break;
    }
    
    if(songsArray.length > 0) {
        populateSongsDropdown (songsArray);
        saveSongs(mediaFolder);
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
              if(isJson(this.responseText)) {
                  songsArray = JSON.parse(this.responseText);
                  populateSongsDropdown(songsArray);
                  saveSongs(mediaFolder);
                  
              } else {
                document.getElementById("songs").innerHTML = this.responseText;
            }
          }
        };
        xmlhttp.open("GET", "GetSongs.php?mediaFolder="+mediaFolder, true);
        xmlhttp.send();
    }

}

function saveSongs(mediaFolder) {
    switch(mediaFolder) {
        case 'digital':
            digitalSongs = songsArray;
            break;
        case 'analog':
            analogSongs = songsArray;
            break;
        case 'live':
            liveSongs = songsArray;
            break;
        default:
            break;
    }
}


function removeSongs() {
    var myNode = document.getElementById("songs");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }
}

function populateSongsDropdown(songs) {
    for(let i=0;i<songs.length;i++) {
        let song = document.createElement("option");
        song.value = songs[i].file;
        song.innerHTML = songs[i].artist + " " + songs[i].album +  " " + songs[i].title;
        document.getElementById("songs").appendChild(song);
    }
    
    //sort songs
    $(function() {
        // choose target dropdown
        var select = $('#songs');
        select.html(select.find('option').sort(function(x, y) {
          // to change to descending order switch "<" for ">"
          return $(x).text() > $(y).text() ? 1 : -1;
        }));

        // select default item after sorting (first item)
        $('#songs').get(0).selectedIndex = 0;
        playSong(document.getElementById('songs').value);
      });
    
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function playSong(song) {
    document.getElementById("analogplayer2").src = song;
    //document.getElementById("analogplayer2").load();
    document.getElementById("analogplayer2").play();
}

