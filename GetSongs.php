<?php
require_once('getid3/getid3.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//see if the mediaFolder was specified
$mediaFolderGetParm=filter_input(INPUT_GET,('mediaFolder'));
if(isset($mediaFolderGetParm)&&!empty($mediaFolderGetParm)) {
   //verify it exists
    if(!file_exists($mediaFolderGetParm)){
        echo("specified media folder does not exist:".$mediaFolderGetParm);
        return;
    }
} else {
    $mediaFolderGetParm = "live";
}

// Initialize getID3 engine
$getID3 = new getID3;

//array that will be populated with soungs found in media folder
$songs = array();

//get a list of files in media folder
$files = scandir($mediaFolderGetParm);

//iterate through files and fill $songs array with mp3 data
foreach ($files as $value) {
    //find the mp3s
    $pos = strrpos($value, ".mp3",-1);
    if ($pos !== false) 
    {
        //found an mp3
        $filePath = $mediaFolderGetParm.'/'.$value;

        //get the date modified
        $fileModifiedDate = date("YmdHis",filemtime($filePath));

        GetId3DisplayId3Data($getID3,$filePath,$fileModifiedDate,$songs);

    }
}
//build a json string of $songs array data and return it
// Sort the data
$jsonResponse=json_encode($songs);
echo($jsonResponse);

function GetId3DisplayId3Data($getID3,$filePath,$fileDate,&$songs)
{
    // Analyze file and store returned data in $ThisFileInfo
    $ThisFileInfo = $getID3->analyze($filePath);

    //copy tags to the comments array
    getid3_lib::CopyTagsToComments($ThisFileInfo);

    //get all tag comments we care about
    if(isset($ThisFileInfo['comments_html']))
    {
        //get artist
        if(isset($ThisFileInfo['comments_html']['artist']))
        {
            $artist=$ThisFileInfo['comments_html']['artist'][0];
        }
        else
        {
            $artist='';
        }


        //get album
        if(isset($ThisFileInfo['comments_html']['album']))
        {
            $album=$ThisFileInfo['comments_html']['album'][0];
        }
        else
        {
            $album='';
        }

        //get title
        if(isset($ThisFileInfo['comments_html']['title']))
        {
            $title=$ThisFileInfo['comments_html']['title'][0];
        }
        else
        {
            $title='';
        }

        //get track
        if(isset($ThisFileInfo['comments_html']['track_number']))
        {
            //GET THE TRACK NUMBER, AND PAD IT WITH 0
            $track=str_pad($ThisFileInfo['comments_html']['track_number'][0],5,"0",STR_PAD_LEFT);

        }
        else
        {
            $track='';
        }

    }
    else 
    {
        $artist='';
        $album='';
        $title='';
        $track='';
    }

    //add song to array of all songs found
    $songs[]=array("file"=>$filePath,"artist"=>$artist,"album"=>$album,"title"=>$title,"track"=>$track,"modifiedDate"=>$fileDate);

}

