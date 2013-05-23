<?
/**
* HIVE - Copyleft Open Source Mind, GP
* Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $
* @package Hive
*/

/**
 * Delete Items 
 */
function file_remove ($data) {
  unlink('files/' . $data['file']);
  $delete = $data['file'] . ' was deleted successfully!';
  return $delete;
}

?>
