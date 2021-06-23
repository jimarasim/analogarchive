<?php
include 'AnalogArchive.php'; 
/* 
 * This is the server side script for an ajax call that tries to get an album's art cover
 * 
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: image/jpeg');

try
{
    $filePathParm=filter_input(INPUT_GET,('filePath'));
    if(isset($filePathParm)&&!empty($filePathParm))
    {
        echo(AnalogArchive::GetMp3Artwork($filePathParm));
    }
    else
    {
        echo("filePath NOT SPECIFIED");
    }
    
    
}
catch(Exception $ex)
{
    echo("CANT GET ARTWORK:".$ex->getMessage()."<br />trace:".$ex->getTraceAsString());
}


/*THE FOLLOWING IS AN ATTEMPT TO CURL IMAGES FROM BING, HAS PROBLEMS WITH DOMDocument::loadHTML($result); LOADING
 * THE RETURNED CURL STRING.  ABANDONED EFFORTS HERE, AND TRYING TO GET MP3 ARTWORK FROM MP3 FILE
function CurlForFirstImageUrl($urlsearch)
{
    
    try
    {
        //initialize curl session
        $curl = curl_init();

        //specify url for curl session
        curl_setopt($curl, CURLOPT_URL,$urlsearch); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //so it won't echo the result

        //execute the curl session and get resultant web page		
        $result = curl_exec($curl);

        //close the curl session
        curl_close($curl);

        //$resultWithEscapedQuotes=str_replace ( '"' , '\"' , $result);
        
        //create a DOM document (replace " with \" in result
        $searchResultsPage = DOMDocument::loadHTML($result);

        //get bing div that contains all the images returned in an image search
        //$imagesDiv = $searchResultsPage->getElementById('dg_c');

        //get all images in that div
        //$imageElements = $imagesDiv->getElementsByTagName('img');

    //    if($imageElements->$length>0)
    //    {
    //        //get the first images
    //        $firstImageElement = $imageElements->item(0);
    //    }

        //$('#b_context img')
    }
    catch(Exception $ex)
    {
        $searchResultsPage="EXCEPTION:".$ex->getMessage();
    }
    
    //get a url to the first image
    return $searchResultsPage;
    
}

//search string for the search engine
$searchString = "";

//see if the artist was specified, and use it in the search string if so
$artistParm=filter_input(INPUT_POST,('artisttosearch'));
if(isset($artistParm)&&!empty($artistParm))
{
    $searchString.=$artistParm;
}

//see if the album was specified, and use it in the search string if so
$albumParm=filter_input(INPUT_POST,('albumtosearch'));
if(isset($albumParm)&&!empty($albumParm))
{
    $searchString.=" ".$albumParm;
}

//get image url

$imageUrl = CurlForFirstImageUrl("http://www.bing.com/images/search?q=".urlencode($searchString));


echo $imageUrl;
 * THE ABOVE IS AN ATTEMPT TO CURL IMAGES FROM BING, HAS PROBLEMS WITH DOMDocument::loadHTML($result); LOADING
 * THE RETURNED CURL STRING.  ABANDONED EFFORTS HERE, AND TRYING TO GET MP3 ARTWORK FROM MP3 FILE
 */

