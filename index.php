<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$f3 = require('/app/fatfree/lib/base.php');
require('app.inc.php');

$f3->route('GET /',
    function($f3) {
        $images = getImages();        
        $f3->set('buddies', array('Tom','Dick','Harry'));
        $f3->set('images', $images);
        echo \Template::instance()->render('templates/home.htm');
    }
);

$f3->route('GET /upload', 
    function($f3) {
        echo \Template::instance()->render('templates/upload.htm');
    }
);

$f3->route('POST /upload',
    function($f3) {
        if(isset($_FILES['imagefiles']))
        {
          handleUploads($_FILES['imagefiles']);
          header("Location: /");  
        }
        header("Location: /");
    }
);

$f3->run();