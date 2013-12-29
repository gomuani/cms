<?php
class Resize{
	public function __construct($filename){
		if(file_exists($filename)):
			$this->setImage($filename);
		else:
			throw new Exception('Image ' . $filename . ' can not be found, try another image.');
		endif;
	}
	private function setImage($filename){
		$size = getimagesize($filename);
		$this->ext = $size['mime'];
		switch($this->ext):
			case 'image/jpg':
			case 'image/jpeg':
				$this->image = @imagecreatefromjpeg($filename);
				break;
			case 'image/gif':
				$this->image = @imagecreatefromgif($filename);
				break;
			case 'image/png':
				$this->image = @imagecreatefrompng($filename);
				break;
			default:
				throw new Exception('File is not an image, please use another file type');
		endswitch;
		$this->origWidth = imagesx($this->image);
		$this->origHeight = imagesy($this->image);
	}
	public function saveImage($savePath, $imageQuality = "100", $download = false){
		switch($this->ext):
			case 'image/jpg':
			case 'image/jpeg':
				if(imagetypes() & IMG_JPG):
					imagejpeg($this->newImage, $savePath, $imageQuality);
				endif;
				break;
			case 'image/gif':
				if(imagetypes() & IMG_GIF):
					imagegif($this->newImage, $savePath);
				endif;
				break;
			case 'image/png':
				$invertScaleQuality = 9 - round(($imageQuality / 100) * 9);
				if(imagetypes() & IMG_PNG):
					imagepng($this->newImage, $savePath, $invertScaleQuality);
				endif;
				break;
		endswitch;
		if($download):
			header('Content-Description: File Transfer');
			header("Content-Type: application/octet-stream");
			header("Content-disposition: attatchment; filename = " . $savePath . "");
			readfile($savePath);
		endif;
		imagedestroy($this->newImage);
	}
	public function resizeTo($width, $height, $resizeOption = "auto"){
		$this->getDimensions($width, $height, $resizeOption);
		$this->newImage = imagecreatetruecolor($this->resizeWidth, $this->resizeHeight);
		imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight, $this->origWidth, $this->origHeight);
		if($resizeOption == "crop"):
			$this->crop($width, $height);
		endif;
	}
	private function crop($width, $height){
		$cropStartX = ($this->resizeWidth / 2) - ($width / 2);
		$cropStartY = ($this->resizeHeight / 2) - ($height / 2);
		$newImage = $this->newImage;
		unset($this->newImage);
		$this->newImage = imagecreatetruecolor($width, $height);
		imagecopyresampled($this->newImage, $newImage, 0, 0, $cropStartX, $cropStartY, $width, $height, $width, $height);
	}
	private function getDimensions($width, $height, $resizeOption = "auto"){
		switch(strtolower($resizeOption)):
			case 'exact':
				$this->resizeWidth = $width;
				$this->resizeHeight = $height;
				break;
			case 'maxwidth':
				$this->resizeWidth = $width;
				$this->resizeHeight = $this->resizeHeightByWidth($width);
				break;
			case 'maxheight':
				$this->resizeWidth = $this->resizeWidthByHeight($height);
				$this->resizeHeight = $height;
				break;
			case 'crop':
				$heightRatio = $this->origHeight / $height;
				$widthRatio = $this->origWidth / $width;
				$resizeRatio = ($widthRatio > $heightRatio) ? $heightRatio : $widthRatio;
				$this->resizeWidth = $this->origHeight / $resizeRatio;
				$this->resizeHeight = $this->origWidth / $resizeRatio;
				break;
			case 'auto':
				if($this->origWidth > $this->origHeight):
					$this->resizeWidth = $width;
					$this->resizeHeight = $this->resizeHeightByWidth($width);
				elseif($this->origHeight > $this->origWidth):
					$this->resizeWidth = $this->resizeWidthByHeight($height);
					$this->resizeHeight = $height;
				else:
					if($width > $height):
						$this->resizeWidth = $width;
						$this->resizeHeight = $this->resizeHeightByWidth($width);
					elseif($height > $width):
						$this->resizeWidth = $this->resizeWidthByHeight($height);
						$this->resizeHeight = $height;
					else:
						$this->resizeWidth = $width;
						$this->resizeHeight = $height;
					endif;
				endif;
				break;
		endswitch;
	}
	private function resizeHeightByWidth($width){
		return floor(($this->origHeight / $this->origWidth) * $width);
	}
	private function resizeWidthByHeight($height){
		return floor(($this->origWidth / $this->origHeight) * $height);
	}

}
?>