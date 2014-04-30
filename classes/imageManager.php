<?php 
class imageManager
{
	/*
	 * createThumbnailJPEG: Crea un thumbnail para JPEG 
	 * Calidad en JPEG o JPG es de 0 a 100, siendo 100 la mejor calidad
	 */
	private $filename;
	private $filextension;
	private $filesize;
	 
	
	public function createThumbnailJPEG($path, $imagename, $thumbpath, $thumbWidth,  $quality)
	{
		 $img = imagecreatefromjpeg( "{$path}{$imagename}" );
		 $width = imagesx( $img );
      	 $height = imagesy( $img );
		 $new_width = $thumbWidth;
		 if($width <= $thumbWidth)
		 {
		 	$new_width = $width;
		 }
		 $new_height = floor( $height * ( $new_width / $width ) );
		 $srcx = 0;
		 $srcy = 0;
      	 
		 $tmp_img = imagecreatetruecolor( $new_width, $new_height );
		 imagecopyresampled( $tmp_img, $img, 0, 0, $srcx, $srcy, $new_width, $new_height, $width, $height);
		 imagejpeg( $tmp_img, "{$thumbpath}{$imagename}",100);
		 
		 $img = imagecreatefromjpeg($path . $imagename); 
		 imagejpeg($img, $path . $imagename, $quality); //75 quality setting 
		 imagedestroy($img);
	}
	/*
	 * cropping function
	 * path is where the file will be saved.
	 * image is the image.
	 * imagename is the name of the file.
	 * x,y,width and heigh is where will be cropped and the size.
	 */
	 public function cropImage($path, $image, $imagename, $x, $y, $width, $height)
	 {
	 	$ext = pathinfo($image['name'], PATHINFO_EXTENSION);
		switch($ext)
		{
			case 'png': 
				$copy = imagecreatefrompng($image['tmp_name']);
				$new = ImageCreateTrueColor($width, $height);
				imagecopyresampled($new, $copy, 0, 0,$x, $y ,$width, $height, $width, $height);
				header('Content-Type: image/png');
				imagepng($new, $path .  $imagename  . '.' . $ext, 0);
				imagedestroy($new);
				return TRUE;
				break;
			case ('jpeg' or 'jpg'): 
				$copy = imagecreatefromjpeg($image['tmp_name']);
				$new = ImageCreateTrueColor($width, $height);
				imagecopyresampled($new, $copy, 0, 0,$x, $y, $width, $height, $width, $height);
				header('Content-Type: image/jpeg');
				imagejpeg($new, $path . $imagename  . '.' . $ext, 100);
				imagedestroy($new);
				return TRUE;
				break;
			default: 
				return FALSE;
				break;
		}
	 }
	 
	/*
	 * createThumbnailPNG: Crea thumbnails para PNG 
     * Calidad en PNG es de 0 a 9, siendo 0 la mejor calidad
	 */
	public function createThumbnailPNG($path, $imagename, $thumbpath,$thumbWidth, $quality)
	{
		 $img = imagecreatefrompng( "{$path}{$imagename}" );
		 $width = imagesx( $img );
      	 $height = imagesy( $img );
		 $new_width = $thumbWidth;
		 if($width <= $thumbWidth)
		 {
		 	$new_width = $width;
		 }
		 $new_height = floor( $height * ( $new_width / $width ) );
		 $srcx = 0;
		 $srcy = 0;
		 $tmp_img = imagecreatetruecolor( $new_width, $new_height );
		 imagealphablending($tmp_img, false);
		 imagesavealpha($tmp_img, true);  

		 $trans_layer_overlay = imagecolorallocatealpha($tmp_img, 220, 220, 220, 127);
		 imagefill($tmp_img, 0, 0, $trans_layer_overlay);
		
		 imagecopyresampled( $tmp_img, $img, 0, 0, $srcx, $srcy, $new_width, $new_height, $width, $height);
		 #imagepng( $tmp_img, "{$thumbpath}{$imagename}", 0);
		 
		 imagepng($tmp_img, $thumbpath . $imagename, $quality); //75 quality setting 
		 imagedestroy($img);
	}
	
	public function createThumbnail($path, $imagename, $thumbpath,$thumbWidth, $jpgquality=100, $pngquality=0)
	{
		$ext = pathinfo("{$path}{$imagename}", PATHINFO_EXTENSION);
		if($ext == 'jpg' or $ext == 'jpeg')
		{
			$this->createThumbnailJPEG($path, $imagename, $thumbpath, $thumbWidth, $jpgquality);
		}
		else if ($ext == 'png')
		{
			$this->createThumbnailPNG($path, $imagename, $thumbpath, $thumbWidth, $pngquality);
		}
	}
	
	/*
	 * reArrayFiles: Reordena el $_FILES que vienen de input multiple
	 */
	public function reArrayFiles(&$file_post) 
	{
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);
	
	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }
	
	    return $file_ary;
	}	
	
	/*
	 * fileUpload: mueve el archivo a la carpeta especificada.
	 */
	public function fileUpload($file,$url,$orderid)
	{
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		if ($file["error"] > 0)
    		{
    			return 0;
    		}
  		else
    		{
                    if(move_uploaded_file($file["tmp_name"],$url . $orderid . '.' . $ext ))
                    {
                        return 1;
                    }
                    else
                    {
                        return 0;
                    }
		}
  	}
		
	
}


?>