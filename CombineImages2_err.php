<?php

$anh = glob('anh/*');
$ci = new CombineImage($anh, "output.jpg", 900);
$ci->combine();
$ci->show();
/**
 *  Splicing multiple images into one picture 
 *
 *  Parameter description ： The original image is an array of file paths , If the destination image is left blank , The results are not saved 
 *
 *  Example ：
 * <code>
 * $ci = new CombineImage(array("./uploads/1.jpg", "./uploads/2.png"), "./uploads/3.png");
 * $ci->combine();
 * $ci->show();
 * </code>
 *
 * @author yangjianhui
 * @version 2020/6/13
 */
class CombineImage
{
    /**
     *  Original map address array 
     */
    private $srcImages;
    /**
     *  Zoom each image to this width 
     */
    private $width;
    /**
     *  Each image zooms to this height 
     */
    private $height;
    /**
     *  Target image address 
     */
    private $destImage;

    /**
     *  Temporary canvas 
     */
    private $canvas;

    /**
     * CombineImage constructor.
     *
     * @param array $srcImages  Need image path array 
     * @param string $desImage  Output target image address 
     * @param int $width  The width of the output picture 
     * @param int $height  Image height after output 
     */
    public function __construct(array $srcImages, $desImage = '', $width = 750, $height = 12144)
    {
        $this->srcImages = $srcImages;
        $this->destImage = $desImage;
        $this->width     = $width;
        $this->height    = $height;
        $this->canvas    = NULL;
    }

    public function __destruct()
    {
        if ($this->canvas != NULL) {
            imagedestroy($this->canvas);
        }
    }

    /**
     *  Merge pictures 
     */
    public function combine()
    {
        if (empty($this->srcImages) || $this->width == 0 || $this->height == 0) {
            return;
        }

       
       /* Get all picture heights */
        $heightAll = 0;
        for ($i = 0; $i < count($this->srcImages); $i++) {
            $srcImage = $this->srcImages[$i];
            list($srcWidth, $srcHeight, $fileType) = getimagesize($srcImage);
            if ($fileType == 2) {
                $srcImage = imagecreatefromjpeg($srcImage);
            } else if ($fileType == 3) {
                $srcImage = imagecreatefrompng($srcImage);
            } else {
                continue;
            }
            $heightAll+=$srcHeight;
        }     
        
        
        $this->height = $heightAll;
        $this->createCanvas();
    
        for ($i = 0; $i < count($this->srcImages); $i++) {
            $srcImage = $this->srcImages[$i];
            // Get the basic information of the original image ( Remember not to https)
            list($srcWidth, $srcHeight, $fileType) = getimagesize($srcImage);
            if ($fileType == 2) {
                //  The original picture is  jpg  type 
                $srcImage = imagecreatefromjpeg($srcImage);
            } else if ($fileType == 3) {
                //  The original picture is  png  type 
                $srcImage = imagecreatefrompng($srcImage);
            } else {
                //  Unrecognized type 
                continue;
            }

            //  Calculate where the current original image should be on the canvas 
            $destX     = 0;
            if ($i == 0) {
                $desyY     = 0;
            } else {
                $desyY += $srcHeight;
            }
            
            imagecopyresampled($this->canvas, $srcImage, $destX, $desyY,
                0, 0, $srcWidth, $srcHeight, $srcWidth, $srcHeight);
            // echo $desyY.'--';
        }
        
        // die;
        //  If there is a designated destination address , Then output to file 
        if (!empty($this->destImage)) {
            $this->output();
        }
    }

    /**
     *  Output the results to the browser 
     */
    public function show()
    {
        if ($this->canvas == NULL) {
            return;
        }
        header("Content-type: image/jpeg");
        imagejpeg($this->canvas);
    }

    /**
     *  Private functions , Create a canvas 
     */
    private function createCanvas()
    {
        $this->canvas = imagecreatetruecolor($this->width, $this->height);
        //  Make the canvas transparent 
        $white = imagecolorallocate($this->canvas, 255, 255, 255);
        imagefill($this->canvas, 0, 0, $white);
        imagecolortransparent($this->canvas, $white);
    }

    /**
     *  Private functions , Save the results to a file 
     */
    private function output()
    {
        //  Get the suffix of the target file 
        $fileType = substr(strrchr($this->destImage, '.'), 1);
        if ($fileType == 'jpg' || $fileType == 'jpeg') {
            imagejpeg($this->canvas, $this->destImage);
        } else {
            //  Default output  png  picture 
            imagepng($this->canvas, $this->destImage);
        }

    }
}

?>