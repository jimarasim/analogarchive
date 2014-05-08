<?php

//https://code.google.com/p/php-reader/downloads/list php mp3 reader
require_once 'Zend/Media/Id3v2.php';

/**
 * Description of codebase
 *
 * @author jameskarasim
 */
class AnalogArchive {

    public static function CatalogMedia()
    {
        $mediaFolder = 'media';
        //$mediaFolder='/Users/jameskarasim/Documents/STATIC/Music/_OTHER - VINYL'; //requires chmod o+rx down whole path
        //get a list of files in media folder
        $files = scandir($mediaFolder);
        
        //iterate through files
        foreach ($files as $key => $value) {
            echo("key:".$key."value:".$value."<br />");
            
            //find the mp3s
            $pos = strrpos($value, ".mp3",-1);
            if ($pos === false) { // note: three equal signs
                // not found...
            }
            else 
            {
                //found an mp3
                $filePath = $mediaFolder.'/'.$value;
                echo($filePath."<br />");
                
                $id3 = new Zend_Media_Id3v2($filePath);
                $TALB = $id3->getFramesByIdentifier("TALB"); // for song title; or TALB for album title; ..
                $TIT2 = $id3->getFramesByIdentifier("TIT2"); 
                $TPE1 = $id3->getFramesByIdentifier("TPE1"); 
                
                
                echo($TALB[0]->getText()."<br />".$TIT2[0]->getText()."<br />".$TPE1[0]->getText()."<br />");
                
               
                
            }
            
        }
    }
    
    
}
