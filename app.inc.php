<?php

function getImages()
{
    $retArry = [];

    // Image extensions
    $image_extensions = array("png","jpg","jpeg","gif", "PNG", "JPG", "JPEG", "GIF");

    // Target directory
    $dir = 'images/';
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            $count = 1;

            // Read files
            while (($file = readdir($dh)) !== false) {
                if ($file != '' && $file != '.' && $file != '..') {
                    // Thumbnail image path
                    $thumbnail_path = "images/thumbnail/".$file;

                    // Image path
                    $image_path = "images/".$file;

                    $thumbnail_ext = pathinfo($thumbnail_path, PATHINFO_EXTENSION);
                    $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

                    // Check its not folder and it is image file
                    if (!is_dir($image_path) &&  in_array($thumbnail_ext, $image_extensions) &&  in_array($image_ext, $image_extensions)) {
                        array_push(
                            $retArry,
                            [
                              'path' => $image_path,
                              'thumbmail_path' => $thumbnail_path,
                            ]
                        );
                        $count++;
                    }
                }
            }
        }
        closedir($dh);
        return $retArry;
    }
    return null;
}

function reArrayFiles(&$file_post)
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
  
  // Compress image
  function compressImage($type, $source, $destination, $quality)
  {
      $info = getimagesize($source);
  
      if ($type == 'image/jpeg') {
          $image = imagecreatefromjpeg($source);
      } elseif ($type == 'image/gif') {
          $image = imagecreatefromgif($source);
      } elseif ($type == 'image/png') {
          $image = imagecreatefrompng($source);
      }
  
      imagejpeg($image, $destination, $quality);
  }

  function handleUploads($ar)
  {
      $file_ary = reArrayFiles($ar);
  
      // Valid extension
      $valid_ext = array('png','jpeg','jpg', 'PNG', 'JPEG', 'JPG');
  
      foreach ($file_ary as $file) {
  
      // File name
          $filename = $file['name'];
          $tmp_name = $file['tmp_name'];
          $file_type = $file['type'];
  
          // Location
          $location = "images/".$filename;
          $thumbnail_location = "images/thumbnail/".$filename;
  
          // file extension
          $file_extension = pathinfo($location, PATHINFO_EXTENSION);
          $file_extension = strtolower($file_extension);
  
          // Check extension
          if (in_array($file_extension, $valid_ext)) {
            
          // Upload file
              if (move_uploaded_file($tmp_name, $location)) {
  
          // Compress Image
                  compressImage($file_type, $location, $thumbnail_location, 60);
              }
          }
      }

      return true;
  }
