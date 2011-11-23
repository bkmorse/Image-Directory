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
	'pi_version'		=> '2.0.0',
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
		$this->EE->load->helper('file');
		$this->EE->load->helper('path');
		$this->EE->load->helper('url');
		
		$directory = (trim($this->EE->TMPL->fetch_param('directory')) !== false) ? $this->EE->TMPL->fetch_param('directory') : "";
		$date_format = ($this->EE->TMPL->fetch_param('date_format') !== false) ? $this->EE->TMPL->fetch_param('date_format') : "F j, Y H:i a";
		$img_ext = ($this->EE->TMPL->fetch_param('img_ext') !== false) ? $this->EE->TMPL->fetch_param('img_ext') : "jpg";

    $tagdata = '';
    $var = '';
    $return_data = '';
		$img_types = array(
			'gif'		=>	'image/gif',
			'jpeg'	=>	'image/jpeg',
			'jpg'		=>	'image/jpeg',
			'png'		=>	'image/png'
		);

    $directory_exists = set_realpath($directory, TRUE);

    if($directory_exists) {

    	$variables = array();
  	
  		//get all files within directory
      $file_names = get_dir_file_info($directory);
      $total_rows = 0;
      $row_count = 0;

			
      // get total # of files that contain $img_ext
			foreach($file_names as $r):
      	if(get_mime_by_extension($r['name']) == $img_types[$img_ext]):
      		$total_rows++;
      	endif;
      endforeach;

      foreach($file_names as $r):
      
      	if(get_mime_by_extension($r['name']) == $img_types[$img_ext]):
	        $variables[] = array(
	  			  'filename' 			=>  $r['name'],
	  			  'filesize' 	  	=>  $r['size'],
	  			  'modified_on' 	=>  date($date_format, $r['date']),
	  			  'image_count'   =>  $row_count,
	  			  'total_images'  =>  $total_rows-1,
	  			  'image_url'			=>	'/'.$r['relative_path'].$r['name']
	  			);
	  			
	  			$row_count++;
	  			
	  			$this->return_data = $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $variables);
				endif;

      endforeach;
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

{exp:image_directory directory="path/to/folder/" img_ext="jpg" date_format=""}
  {if image_count == 0}<ul>{/if}
	  <li><img src="{image_url}">{filename}, size: {filesize}, modified on {modified_on}</img></li>
  {if image_count == total_images}</ul>{/if}
{/exp:image_directory}

parameters:

directory (required) - path starts at web root of your website, so it begins at the same level that your system folder does,
also do not start the path with a '/' at the beginning, only at the end '/', as seen above in the directory parameter

img_ext (required) - extensions supports gif, jpg, jpeg, png

date_format (optional) = php date format, this is to format the {modified_on} variable

variables:

image_url - relative path to where file resides
filename - filename.ext, example: image.jpg
filesize - size in bytes
modified_on - modified date of file, default date: November 11, 2011 11:00 am
image_count - current count of row
total_images - total number of images

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