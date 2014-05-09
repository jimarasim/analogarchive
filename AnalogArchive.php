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
    
    public static function CatalogMedia()
    {
        // Initialize getID3 engine
        $getID3 = new getID3;
        
        
        //$mediaFolder = 'media';
        //$mediaFolder='/Users/jameskarasim/Documents/STATIC/Music/_OTHER - VINYL'; //requires chmod o+rx down whole path
        //get a list of files in media folder
        $files = scandir(self::$mediaFolder);
        
        //iterate through files
        foreach ($files as $key => $value) {
            //find the mp3s
            $pos = strrpos($value, ".mp3",-1);
            if ($pos === false) { // note: three equal signs
                // not found...
            }
            else 
            {
                //found an mp3
                $filePath = self::$mediaFolder.'/'.$value;
                //self::ZendDisplayId3Data($filePath);
                self::GetId3DisplayId3Data($getID3,$filePath);
            }
            
       }
    }
    
    /**
     * This function determines the version of id3, and continues processing if so
     * artist album title track_number comment
     * @param type $getID3
     * @param type $filePath
     */
    private static function GetId3DisplayId3Data($getID3,$filePath)
    {
        
        echo("FILE:".$filePath."<BR />");
        
        // Analyze file and store returned data in $ThisFileInfo
        $ThisFileInfo = $getID3->analyze($filePath);

        /*
         Optional: copies data from all subarrays of [tags] into [comments] so
         metadata is all available in one location for all tag formats
         metainformation is always available under [tags] even if this is not called
        */
        getid3_lib::CopyTagsToComments($ThisFileInfo);
        
        if(isset($ThisFileInfo['comments_html']))
        {
            foreach($ThisFileInfo['comments_html'] as $property => $value)
            {
                echo("PROPERTY:".$property." VALUE:".$value[0]."<BR />");
            }
        }
        else 
        {
            echo("INVALID ID3 INFO<BR />");
        }
        
        echo("<hr>");
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
