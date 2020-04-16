<?php

function reArrayFiles(&$file_post) {

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
  function compressImage($type, $source, $destination, $quality) {
  
    $info = getimagesize($source);
  
    if ($type == 'image/jpeg') 
      $image = imagecreatefromjpeg($source);
  
    elseif ($type == 'image/gif') 
      $image = imagecreatefromgif($source);
  
    elseif ($type == 'image/png') 
      $image = imagecreatefrompng($source);
  
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
      if(in_array($file_extension, $valid_ext)){ 
  
        // Upload file
        if(move_uploaded_file($tmp_name, $location)){
  
          // Compress Image
          compressImage($file_type, $location,$thumbnail_location, 60);
  
        }
      }
    }

    return true;
  }

  function processUploads() {
    // PHP Server Code to process submitted form
    $numUploadedfiles = count($_FILES['imagefiles']);
    for($i = 0; $i < $numUploadedfiles; $i++)
    {
        echo "<br>filename " . $i . " is: " . $_FILES['imagefiles'][$i];
        // or do whatever
    }
    exit;
  }
  