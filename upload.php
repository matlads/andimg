<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if(isset($_POST['upload'])){

  $file_ary = reArrayFiles($_FILES['imagefiles']);
  
  // Valid extension
  $valid_ext = array('png','jpeg','jpg');

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
    if(in_array($file_extension,$valid_ext)){ 

      // Upload file
      if(move_uploaded_file($tmp_name, $location)){

        // Compress Image
        compressImage($file_type, $location,$thumbnail_location, 60);

      }

    }
  }
  header("Location: index.php");
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

?><!doctype html>
<html>
<head>
  <title>AndImg - Upload</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body class="container">

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">AndImg</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="upload.php">Upload <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div>
    <h2>Upload Images</h2>
    <!-- Upload form -->
    <form method='post' action='' enctype='multipart/form-data'>
      <div class="form-group">
        <label for="exampleFormControlInput1">Select Photo (one or multiple):</label>
        <input type='file' name='imagefiles[]' class="form-control-file" multiple id="field1">
      </div>
      <button type='submit' value='Upload' name='upload' class="btn btn-primary">Upload</button>
    </form>
  </div>

</body>
</html>
