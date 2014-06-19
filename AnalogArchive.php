<?php


// include getID3() library (can be in a different directory if full path is specified)
//http://getid3.sourceforge.net/
require_once('getid3/getid3.php');

//turn on all error reporting
error_reporting(E_ALL); 

/**
 * Description of codebase
 *
 * @author jameskarasim
 */
class AnalogArchive {

    private static $mediaFolder = 'images';
    private static $emptyVal = '';
    private static $startTime;
    
    public static function CatalogMedia()
    {
        // Initialize getID3 engine
        $getID3 = new getID3;
        
        //see if the mediaFolder was specified
        $mediaFolderGetParm=filter_input(INPUT_GET,('mediaFolder'));
        if(isset($mediaFolderGetParm)&&!empty($mediaFolderGetParm))
        {
            //verify it exists
            if(file_exists($mediaFolderGetParm))
            {
                self::$mediaFolder = $mediaFolderGetParm;
            }
            else
            {
                echo("specified media folder does not exist:".$mediaFolderGetParm." scanning default:".self::$mediaFolder);
            }
        }
        
        
        //$mediaFolder = 'media';
        //$mediaFolder='/Users/jameskarasim/Documents/STATIC/Music/_OTHER - VINYL'; //requires chmod o+rx down whole path
        //get a list of files in media folder
        $files = scandir(self::$mediaFolder);
        
        
        $songs = array();
        
        //iterate through files
        foreach ($files as $value) {
            //find the mp3s
            $pos = strrpos($value, ".mp3",-1);
            if ($pos !== false) 
            {
                //found an mp3
                $filePath = self::$mediaFolder.'/'.$value;
                //self::ZendDisplayId3Data($filePath);
                self::GetId3DisplayId3Data($getID3,$filePath,$songs);
            }
            
       }
       
       
       //sort songs by artist a.artist+a.album+a.track+a.title+a.file
       //http://www.php.net//manual/en/function.array-multisort.php
       // Obtain a list of columns
       //"file"=>$filePath,"artist"=>$artist,"album"=>$album,"title"=>$title,"track"=>$track
        foreach ($songs as $key => $row) {
            $file[$key]  = $row['file'];
            //$artist[$key] = $row['artist'];
            //use regular expression to take the The from the beginning of the string
            $artist[$key] = preg_replace('/^The /', '', $row['artist']);
            $album[$key]  = $row['album'];
            $title[$key] = $row['title'];
            $track[$key] = $row['track'];
        }

        // Sort the data 
        array_multisort($artist, SORT_ASC, $album, SORT_ASC, $track, SORT_ASC, $title, SORT_ASC, $file, SORT_ASC, $songs);
       
       
       //print out songs
       echo("<table id='songsTable'>");
       echo("<tr><td><a href='#' id='artistSort'>Artist</a></td><td><a href='#' id='albumSort'>Album</a></td><td><a href='#' id='titleSort'>Title</a></td><td>Track</td><td><a href='#' id='fileSort'>File</a></td></tr>");
       foreach ($songs as $value) {
           echo("<tr>");
           echo("<td name='artist'><input type='checkbox' id='".$value["file"]."' onclick='AddRemovePlaylistItem(this)' />".$value["artist"]."</td>");
           echo("<td name='album'>".$value["album"]."</td>");
           echo("<td name='title'>".$value["title"]."</td>");
           echo("<td name='track'>".$value["track"]."</td>");
           echo("<td><a href='".$value["file"]."' target='_blank'>".$value["file"]."</a></td>");
           
           echo("</tr>");
           
       }
       echo("</table>");
       
       //serialize the data on the client
       echo("<script>var songsarray = ".json_encode($songs).";</script>");
    }
    
    /**
     * This function determines the version of id3, and continues processing if so
     * artist album title track_number comment
     * @param type $getID3 - id3 engine
     * @param type $filePath - path to the file
     * @param type &$songs - songs array to populate
     */
    private static function GetId3DisplayId3Data($getID3,$filePath,&$songs)
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
                $artist=self::$emptyVal;
            }
            
            
            //get album
            if(isset($ThisFileInfo['comments_html']['album']))
            {
                $album=$ThisFileInfo['comments_html']['album'][0];
            }
            else
            {
                $album=self::$emptyVal;
            }
            
            //get title
            if(isset($ThisFileInfo['comments_html']['title']))
            {
                $title=$ThisFileInfo['comments_html']['title'][0];
            }
            else
            {
                $title=self::$emptyVal;
            }
            
            //get track
            if(isset($ThisFileInfo['comments_html']['track_number']))
            {
                //GET THE TRACK NUMBER, AND PAD IT WITH 0
                $track=str_pad($ThisFileInfo['comments_html']['track_number'][0],5,"0",STR_PAD_LEFT);
                
            }
            else
            {
                $track=self::$emptyVal;
            }
            
        }
        else 
        {
            $artist=self::$emptyVal;
            $album=self::$emptyVal;
            $title=self::$emptyVal;
            $track=self::$emptyVal;
        }
        
        //add song to array of all songs found
        $songs[]=array("file"=>$filePath,"artist"=>$artist,"album"=>$album,"title"=>$title,"track"=>$track);
        
    }
    
    /**
    * this function gets the current url
    */
   public static function GetHostUrl()
   {
       $HTTPS = filter_input(INPUT_SERVER, 'HTTPS');
       $HTTP_HOST = filter_input(INPUT_SERVER, 'HTTP_HOST');
       $REQUEST_URI = filter_input(INPUT_SERVER, 'REQUEST_URI');

       $protocol = (!empty($HTTPS) && $HTTPS == 'on') ?'htts://':'http://';

       $currentUrl = $protocol.$HTTP_HOST.$REQUEST_URI;

       return $currentUrl;
   }


   /**
    * This function gets the artwork for an mp3
    * @param type $filePath
    */
   public static function GetMp3Artwork($mp3FilePath)
   {
        // Initialize getID3 engine
        $getID3 = new getID3;

        // Analyze file and store returned data in $ThisFileInfo
        $ThisFileInfo = $getID3->analyze($mp3FilePath);
        
        //initialize image data with an empty string, that will be returned in case there is no image
        $imageData = "";
        $mimeType = "";

        //check if artwork is there
        if(isset($ThisFileInfo['id3v2']['APIC']))
        {
            $mimeType=$ThisFileInfo['id3v2']['APIC'][0]['mime'];
            $imageData = $ThisFileInfo['id3v2']['APIC'][0]['data'];

        }
        //check here if not found there
        elseif(isset($ThisFileInfo['comments']['picture']))
        {
            $mimeType = $ThisFileInfo['comments']['picture'][0]['image_mime'];
            $imageData = $ThisFileInfo['comments']['picture'][0]['data'];

        }
        
        //return a src string for an img tag to display the image
        if(!empty($mimeType)&&!empty($imageData))
        {
            return "data:".$mimeType.";base64,".base64_encode($imageData);
        }
        else 
        {
            return "";
        }
   }
    
    
}
