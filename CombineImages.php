<?php

$anh = glob("anh/*");
$ci = new BoardCreator("jpg", $anh);
$ci->GenerateBoard();

class BoardCreator
{

    private $_img_type;
    private $_img_urls = array();

    public function __construct($img_export_type, array $img_urls)
    {
        $this->_img_type = $img_export_type; // File format for exported image
        $this->_img_urls = $img_urls; // Array of image URLs
        
    }

    public function GenerateBoard()
    {

        /*
         * Arrays to hydrate with loaded image properties & resources
        */
        $images = array(); // Image resources
        $width = array(); // Image widths
        $height = array(); // Image heights
        $total_height = 0; // Total height required for the board
        /*
         * Load in each image, and store its width & height
        */
        for ($i = 0;$i < count($this->_img_urls);$i++)
        {

            switch (exif_imagetype($this->_img_urls[$i]))
            {
                case IMAGETYPE_JPEG:
                    $images[$i] = imagecreatefromjpeg($this->_img_urls[$i]);
                break;

                case IMAGETYPE_PNG:
                    $images[$i] = imagecreatefrompng($this->_img_urls[$i]);
                break;

                case IMAGETYPE_GIF:
                    $images[$i] = imagecreatefromgif($this->_img_urls[$i]);
                break;

                    // default w/ error required
                    
            }

            // Store the image's dimensions
            list($width[$i], $height[$i]) = getimagesize($this->_img_urls[$i]);

            // Add this image's height to the required canvas height
            $total_height = $total_height + $height[$i];
        }

        /*
         * Create a new "canvas" image with specified dimensions
        */

        $canvas_image = imagecreatetruecolor($width[0], $total_height);

        /*
         * Copy each image into the "canvas" image generated above
        */

        $current_x = 0;
        $current_y = 0;

        for ($i = 0;$i < count($images);$i++)
        {
            imagecopy($canvas_image, // destination image
            $images[$i], // source image
            0, // x co-ordinate of destination
            $current_y, // y co-ordinate of destination
            0, // x co-ordinate of source
            0, // y co-ordinate of source
            $width[$i], // source img width
            $height[$i] // source img height
            );

            $current_y = $current_y + $height[$i];
        }

        /*
         * Save the resulting image in the format specified at initiation
        */

        switch ($this->_img_type)
        {
            case "jpg":
                $images[$i] = imagejpeg($canvas_image, "tester.jpg");
            break;

            case "png":
                $images[$i] = imagepng($canvas_image, "tester.png");
            break;

            case "gif":
                $images[$i] = imagegif($canvas_image, "tester.gif");
            break;

            default:
                // Create an error to handle here
                die("Error in BoardCreator.php (Method GenerateBoard() )");
            break;
        }

        /*
         * Release the created image from memory
        */
        imagedestroy($canvas_image);

        /*
         * Loop through and release each loaded image
        */
        for ($i = 0;$i < count($this->_img_urls);$i++)
        {
            imagedestroy($images[$i]);
        }
    }
}

