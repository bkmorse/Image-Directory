<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine Image Directory Plugin
 *
 * @package		Image Directory Plugin
 * @subpackage		Plugins
 * @category		Plugins
 * @author		Brad Morse
 * @link			http://www.bkmorse.com
 */

$plugin_info = array(
	'pi_name'			=> 'Image Directory',
	'pi_version'		=> '1.0.0',
	'pi_author'		=> 'Brad Morse',
	'pi_author_url'	=> 'http://bkmorse.com',
	'pi_description'	=> 'Displays all images from within a folder/directory on your server',
	'pi_usage'		=> Image_directory::usage()
);


class Image_directory {

	var $return_data;

	/**
	*  Constructor
	*/
	function Image_directory()
	{
		// make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
		$img_ext = ($this->EE->TMPL->fetch_param('img_ext') !== false) ? $this->EE->TMPL->fetch_param('img_ext') : "jpg";
		$directory = ($this->EE->TMPL->fetch_param('directory') !== false) ? $this->EE->TMPL->fetch_param('directory') : "";
		$height = ($this->EE->TMPL->fetch_param('height') !== false) ? $this->EE->TMPL->fetch_param('height') : "";
		$width = ($this->EE->TMPL->fetch_param('width') !== false) ? $this->EE->TMPL->fetch_param('width') : "";
		$alt = ($this->EE->TMPL->fetch_param('alt') !== false) ? $this->EE->TMPL->fetch_param('alt') : "";
		$class = ($this->EE->TMPL->fetch_param('alt') !== false) ? $this->EE->TMPL->fetch_param('alt') : "";
		$wrap = ($this->EE->TMPL->fetch_param('wrap') !== false) ? $this->EE->TMPL->fetch_param('wrap') : "";
    
    $return_data = '';

    if($img_ext && $directory) {
  		//get all image files with a .jpg extension.
      $images = glob($directory . "*.".$img_ext."");
    
      //print each file name
      foreach($images as $image):
       if($wrap != '') {
       $return_data .= '<'.$wrap.'><img src="'.$image.'" height="'.$height.'" width="'.$width.'" alt="'.$alt.'" class="'.$class.'"></'.$wrap.'>';
       } else {
         $return_data .= '<img src="'.$image.'" height="'.$height.'" width="'.$width.'" alt="'.$alt.'" class="'.$class.'">';
       }
      endforeach;

  		$this->return_data = $return_data;
    }
	}
	/* END */
	
	
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>
Use as follows:

{exp:image_directory directory="/path/to/folder" img_ext="jpg" height="" width="" alt="" class="" wrap=""}

directory (required) - absolute or relative path to folder of images you want to display

img_ext (required) - gif|jpg|jpeg|png

height, width, alt, class (optional)

wrap (optional) - put within paragraph, div or span tags, see below

wrap="p" would put it within <p></p>
wrap="div" would put it within <div></div>
wrap="span" would put it within <span></span>

* if you get an error or nothing displays, be sure to check the path you passed to the directory parameter

<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
/* END */


}
// END CLASS

/* End of file pi.pdf_icon.php */
/* Location: ./system/expressionengine/third_party/image_directory/pi.image_directory.php */
?>