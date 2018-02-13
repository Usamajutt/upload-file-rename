<?php
require "uploads/config/config.php"; // connection database
?>

<!DOCTYPE html>
<html>
<head>
	<title>image upload</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <div class="container">
    <div class="jumbotron text-center">
    <h1 class="text-dark">Bootstrap image Upload</h1>
    <div class="container">
      <div class="container">
      <div class="row">
     <div class="container">
     <form class="form" id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
      <p class="text-primary">Select your image</p>
     <input type="file" class="form-control" name="uploadfile"><br>
     <input type="submit" class="btn btn-primary" name="submit" >
       </form>
       <br>
       <div class="text-primary">
       <?php
       if($_SERVER['REQUEST_METHOD']==="POST")
       {
        $name = $_FILES['uploadfile']['name'];
        $name =preg_replace('/\s+/','_', $name);
        $tmp_name = $_FILES['uploadfile']['tmp_name'];
        $size = $_FILES['uploadfile']['size'];
        $type = $_FILES['uploadfile']['type'];
        
	  	 $name_ext=pathinfo($name,PATHINFO_EXTENSION);
        $name_file =pathinfo($name,PATHINFO_FILENAME);

	  	 $name = $name_file."_".date("Y-m-j-H-i-s").rand(1,10000).".".$name_ext;
        
	  	 $location = "uploads/".$name;

        		if(!empty($name))
		{
           if($size <= 1000000)
          {
             if($name_ext == 'jpg' || $name_ext=='png' || $name_ext=='jpeg' || $name_ext=='MP4' || $name_ext=='MKV' )
             {
      		$folder = move_uploaded_file($tmp_name,$location);
      		

	       if($folder)
		{
			
			$msg = $name." successfuly uploaded in folder";

			$query = "INSERT INTO uploads_images(image_name) VALUES('$location')";
			$run_query = mysqli_query($con,$query);
			if($run_query)
			{
				echo  $msg." and also uploaded into the database<br>";
        ?> 

        <script>
        alert("image successfully uploaded <?php echo "<img src=".$location. " height=150px width=150px>";  ?>");
        window.location.href="image.php";
        </script>
        <?php
        echo "<img src=".$location." height=150px width=150px>";
			}
			else
			{
				echo mysqli_error($con);
			}
		}
         else
	     {
      	echo "please try again";
            }             
             }
             else
             {
               echo "jpg,png and jpeg files are inserted others files are not accepted";
             }
           }
           else
           {
           	echo "image size is so large please insert image less then 1MB";
         }
		}
		else

		{
			echo "please insert an image";

		}
}

       ?>
      </div>
      </div>
       
      </div>

    </div>


   </div>
       </div>
    </div>

</body>
</html>
