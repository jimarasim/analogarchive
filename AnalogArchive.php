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
    
    public static function CatalogMedia()
    {
        // Initialize getID3 engine
        $getID3 = new getID3;
        
        
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
       
       //print out songs
       foreach ($songs as $key => $value) {
           echo("<a href='".$key."' target='_blank'>".$key."</a><br />");
           echo("ARTIST:".$value["artist"]."<br />");
           echo("ALBUM:".$value["album"]."<br />");
           echo("TITLE:".$value["title"]."<br />");
           echo("TRACK:".$value["track"]."<br />");
           
       }
       
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

        /*
         Optional: copies data from all subarrays of [tags] into [comments] so
         metadata is all available in one location for all tag formats
         metainformation is always available under [tags] even if this is not called
        */
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
            if(isset($ThisFileInfo['comments_html']['track']))
            {
                $track=$ThisFileInfo['comments_html']['track'][0];
            }
            else
            {
                $track=self::$emptyVal;
            }
            
            //use this to display all tags gotten
//            foreach($ThisFileInfo['comments_html'] as $property => $value)
//            {
//                echo("PROPERTY:".$property." VALUE:".$value[0]."<BR />");
//            }
        }
        else 
        {
            $artist=self::$emptyVal;
            $album=self::$emptyVal;
            $title=self::$emptyVal;
            $track=self::$emptyVal;
            //echo("INVALID ID3 INFO<BR />");
        }
        
        //add song to array of all songs found
        $songs[$filePath]=array("artist"=>$artist,"album"=>$album,"title"=>$title,"track"=>$track);
        
        
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


    
    
}
