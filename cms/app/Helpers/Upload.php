<?php 
namespace Helpers;


//Version 1.0
//Last edited by Oluwafemi Korede


class upload
{
	public static $name;
	public static $width;
	public static $filename;
	public static $images;
	public static $success;
	public static $_ext;
	public static $filesize;
	public static $multiple_file;

	//Set a default random name for the file 
	function __construct()
	{
		$this->name = uniqid();
	}

	//Manually set a name for the file
	public static function setName($name)
	{
		self::$name = $name;
	}
	
	//determine file extension
	public static function getExt($file)
	{
		self::$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
	}


	//return file name and path
	public static function getFileName($path_append = '')
	{
		if(isset($path_append) && !empty($path_append)){
			return $path_append.'/'.self::$filename;
		} else {
			return self::$filename;
		}
	}

	//return filename with extension
	public static function getName()
	{
		return self::$filename;
	}


	//Function to upload a file
	public static function upload_file($file,$path){
			  $filename = $file['name'];
              $source = $file['tmp_name'];
			  $ext = pathinfo($filename,PATHINFO_EXTENSION);
			  $size = $file['size'] / 1000000;
			  self::$filesize = number_format((float)$size, 2, '.', '');
			  self::$filesize .= 'MB';

			  if (self::$name)
			  {
				  $target = $path.self::$name.".".$ext;
				  self::$filename = self::$name.".".$ext;  
			  } 
			  else 
			  {
			  	$target = $path.$filename; 
			  }
              move_uploaded_file($source, $target);
		}
	//Function to upload an image
	//$modwidths is an array of the widths of the different images to be generated eg array(50,300) generates 2 images scaled to widths 50 and 300
	//All images are converted to jpg even if the user uploads png gif or jpg
	//The names of all images converted are stored in the $this->images array of the class
	function upload_image($image,$path,$modwidths,$unlink){
			  $imagename = $image['name'];
			  $ext = pathinfo($imagename,PATHINFO_EXTENSION);
              $source = $image['tmp_name'];
              $target = $path.$imagename;
			  $this->filename = $this->name.".jpg";
              move_uploaded_file($source, $target);
 			  $imagepath = $imagename;
 			  $file = $path."/".$imagepath; //This is the original file
 				
              list($width, $height) = getimagesize($file) ; 
			  //create images for each modwidth specified
			  foreach($modwidths as $modwidth)
			  {
				  $newid = uniqid();
				  $save = $path."/".$newid.".jpg"; //This is the new file you saving
				  $this->images[] = $newid.".jpg"; //This saves the image name in the images array of the class
				  $diff = $width / $modwidth;	//Calculate image scale based on the modwidth
	 
				  $modheight = $height / $diff;  //calculate modheight based on the scale
				  
				  $tn = imagecreatetruecolor($modwidth, $modheight) ; 
				  //Generate the image from the source
				  if ($ext == "jpg" or $ext == "jpeg")
				  $image = imagecreatefromjpeg($file);
				  elseif ($ext == "gif")
				  $image = imagecreatefromgif($file);
				  elseif ($ext == "png")
				  $image = imagecreatefrompng($file);
				  else
				  $image = false; 
				  
				  if ($image)
				  {
					  imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
					  imagejpeg($tn, $save, 100) ; 
					  $this->success = true; //set the success variable of the class as true
				  }
				  else
				  {
					   $this->success = false; //set the success variable of the class as false
				  }
			  }
 			//Delete source file if the unlink variable is set to 1
 			 if ($unlink == 1)
			  unlink($target);
		}

		function reArrayFiles($file_post) 
		{

			$this->multiple_file = array();
			$file_count = count($file_post['name']);
			$file_keys = array_keys($file_post);

			for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
			$this->multiple_file[$i][$key] = $file_post[$key][$i];
			}
			}

			//return $file_ary;
			$this->multiple_file;
		}

public static function resizeUpload($file, $location, $set_width){

	 define ("MAX_SIZE","400");

	 $image = $file['name'];
	 $filename = $file['name'];
     $source = $file['tmp_name'];
	 $extension = strtolower(pathinfo($image,PATHINFO_EXTENSION));

	
	  if (isset($image)) 
	  {
	  	$recognized_extension = array("jpg", "jpeg", "png", "gif");
			if (in_array($extension, $recognized_extension)) {

					// $size=filesize($source);
					// if ($size > MAX_SIZE*1024)
					// {
					//  return "You have exceeded the size limit";
					//  break;
					// }
 
					if (self::$name)
						  {
							  $target = $location.self::$name.".".$extension;
							  self::$filename = self::$name.".".$extension;  
						  } 
						  else  { $target = $path.$filename; }
			              move_uploaded_file($source, $target);

				 			switch ($extension) {
				 				case 'jpg':
				 				case 'jpeg':
									$src = imagecreatefromjpeg($target);
				 					break;

								case 'png':
									$src = imagecreatefrompng($target);
				 					break;	 	

				 				case 'gif':
									$src = imagecreatefromgif($target);
									break;

				 				default:
				 					break;
				 			}
						 
							list($width,$height)=getimagesize($target);
					
							$newwidth= $set_width;
							$newheight=($height/$width)*$newwidth;
							$tmp=imagecreatetruecolor($newwidth,$newheight);
					
							imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
							
							$upload_file = $location."thumb_".self::$name.".".$extension;
							
							imagejpeg($tmp,$upload_file,100);


							// $old_width= $width;
							// $old_height=($height/$width)*$old_width;
							// $tmp=imagecreatetruecolor($old_width,$old_height);
					
							// imagecopyresampled($tmp,$src,0,0,0,0,$old_width,$old_height, $width,$height);
							
							// $upload_file2 = $location."".self::$name.".".$extension;
							
							// imagejpeg($tmp,$upload_file2,100);



							
							imagedestroy($src);
							imagedestroy($tmp);
			} else
	 			{

			 		echo 'Unknown Image extension';
					$errors=1;
				} // end else extension
		} // end if image

	if(!$errors) 
	  return "Image Uploaded Successfully!";
}


public static function resizeUrl($target, $location, $set_width){
	 
	    $extension = 'jpg';

	 	list($width,$height)=getimagesize($target);
					
		$newwidth= $set_width;
		$newheight=($height/$width)*$newwidth;
		$src = imagecreatefromjpeg($target);

		self::$filename = self::$name.".".$extension;  


		$tmp=imagecreatetruecolor($newwidth,$newheight);

		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
		
		$upload_file = $location.self::$filename;
		
		imagejpeg($tmp,$upload_file,100);


	if(!$errors) 
	  return "Image Uploaded Successfully!";
}



}
?>