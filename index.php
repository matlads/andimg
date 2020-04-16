<!doctype html>
<html>
 <head>
   <!-- CSS -->
   <title>AndImg - Home</title>
   <link rel="stylesheet" text="text/css" href="bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" text="text/css" href='photobox/photobox.css'>
   <link rel="stylesheet" text="text/css" href='css/style.css'>

   <!-- Script -->
   <script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
   <script type="text/javascript" src="photobox/jquery.photobox.js"></script>
 </head>
 <body class="container">

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="navbar-brand" href="">ᗩᑎᗪ IᗰG</div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="upload.php">Upload</a>
        </li>
      </ul>
    </div>
  </nav>

<div class='container'>
  <div class="gallery">
    <div class="row text-center text-lg-left">

<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Image extensions
$image_extensions = array("png","jpg","jpeg","gif", "PNG", "JPG", "JPEG", "GIF");

// Target directory
$dir = 'images/';
if (is_dir($dir)){

  if ($dh = opendir($dir)){
    $count = 1;

    // Read files
    while (($file = readdir($dh)) !== false){

      if($file != '' && $file != '.' && $file != '..'){

        // Thumbnail image path 
        $thumbnail_path = "images/thumbnail/".$file;

        // Image path
        $image_path = "images/".$file;

        $thumbnail_ext = pathinfo($thumbnail_path, PATHINFO_EXTENSION);
        $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

        // Check its not folder and it is image file
        if(!is_dir($image_path) && 
          in_array($thumbnail_ext,$image_extensions) && 
          in_array($image_ext,$image_extensions)){
?>
                <!-- Image -->
                <div class="col-lg-3 col-md-4 col-6">
                  <a href="<?= $image_path; ?>" class="d-block mb-4 h-100">
                    <img class="img-fluid img-thumbnail" src="<?= $thumbnail_path ?>" alt="">
                  </a>
                </div>                
<?php 
          }
          $count++;
        }
      }

    }
    closedir($dh);
  }
?>
      </div>
    </div>
  </div>
<script type='text/javascript'>
$(document).ready(function(){
  $('.gallery').photobox('a',{ time:0 });
});
</script>

  </body>
</html>