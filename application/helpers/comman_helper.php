<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('change_date_format'))
{
   function change_date_format($date='',$format='')
   {
	   	 if(!empty($date) && !empty($format))
	  	  {
	    	return date($format, strtotime($date));
	      }
	      else
	      {
	      	return 'Both date and its format required';
	      }
   }
}
//comman save file and image thumbnail
if (!function_exists('save_file'))
{
  function save_file($filearr='',$directory='',$thumbdirectory='',$valid_extensions='',$suffix='',$refId='',$thumbnail='',$thumb_w='',$thumb_h='')
    {
    	$thumbarr   = array();

	  if(!empty($filearr) && !empty($directory) && !empty($valid_extensions))
	  {
		$temporary 		 = explode(".", $filearr['name']);
		$file_extension  = end($temporary);
		if(in_array($file_extension, $valid_extensions))
		  {
			$file1Name 	= $suffix.date('dmyHis',time()).''.$refId;
			$fileName 	= $file1Name.'.'.$file_extension;
			$sourcePath = $filearr['tmp_name'];
	        $targetPath = $directory.$fileName;
	        
	        if($thumbnail==TRUE)
	          {
	          	$thumbval = thumbnail_image($filearr,$thumbdirectory,$file1Name,$thumb_w,$thumb_h);
	          	if($thumbval!="Invalid Image type.")
	          	{
	          		$thumbarr   = array('thumb_name'=>$thumbval);	
	          	}
	          	else
	          	{
	          		$thumbarr   = array('thumb_name'=>'');
	          	}
	          	
	          }
	         else
	         {
	         	$thumbarr   = array('thumb_name'=>'');
	         }
	        if(move_uploaded_file($sourcePath,$targetPath))
	        {
	          $retarr = array('respose'=>'2','filename'=>$fileName,'extension'=>$file_extension)+ $thumbarr;
	          return $retarr;
	        }
	        else
	        {
	          $retarr = array('respose'=>'1','message'=>'File is unable to save in given directory.');
	          return $retarr;
	        }
		  }
		 else
		  {
		  	$retarr = array('respose'=>'0','message'=>'File Extension is not matched.');
	        return $retarr;
		  }
		 }
		else
		{
			$retarr = array('respose'=>'3','message'=>'File array, Directory path and array of extensions required.',);
		}
    }
}
if (!function_exists('thumbnail_image'))
{
  function thumbnail_image($filearr='',$thumb_file_path='',$fileNewName='',$thumb_w='',$thumb_h='')
	{
		$file = $filearr['tmp_name']; 
        $sourceProperties = getimagesize($file);
        $fileNewName = $fileNewName;
        $tfolderPath = $thumb_file_path;
        $ext = pathinfo($filearr['name'], PATHINFO_EXTENSION);
        $imageType = $sourceProperties[2];

        switch ($imageType)
        {

            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1],$thumb_w,$thumb_h);
                imagepng($targetLayer,$tfolderPath. $fileNewName. "_thumb.". $ext);
                return $fileNewName. "_thumb.". $ext;
                break;

            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1],$thumb_w,$thumb_h);
                imagegif($targetLayer,$tfolderPath. $fileNewName. "_thumb.". $ext);
                return $fileNewName. "_thumb.". $ext;
                break;

            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1],$thumb_w,$thumb_h);
                imagejpeg($targetLayer,$tfolderPath. $fileNewName. "_thumb.". $ext);
                return $fileNewName. "_thumb.". $ext;
                break;

            default:
                return "Invalid Image type.";
                exit;
                break;
        }
	}
}
if (!function_exists('imageResize'))
{
	function imageResize($imageResourceId,$width,$height,$thumb_w='',$thumb_h='') {

	    $targetWidth =$thumb_w;
	    $targetHeight =$thumb_h;

	    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
	    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);

	    return $targetLayer;
	}
}
//ends