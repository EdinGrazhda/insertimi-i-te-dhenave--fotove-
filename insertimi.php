<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title> Insertimi i produkteve</title>
    </head>
    <body>
        <!--enctype="multipart/form-data"-është një lloj kodimi që lejon që filet të dërgohen përmes një metode POST. Thjesht, pa këtë kodim file nuk mund të dërgohen përmes metodes POST. Nëse dëshironi të lejoni një përdorues të ngarkojë një file përmes një forme, duhet ta përdorni këtë enctype.-->
        <form method="post" action="insertimi.php" enctype="multipart/form-data">
            File Name: <input type="text" name="fileName"><br><br>
            File Upload:<input type="file" name="fileUpload"><br><br>
            File Description: <textarea name='content' cols='30' rows='15'></textarea><br><br>
            <input type="submit" name="upload" value="Insert">
            <input type="reset" name="cancel" value="Cancel">
        </form>
        
        <!-- <a href='insert.php'>Home</a> -->
    </body>
</html>


<?php
    $con=mysqli_connect('localhost','root','','login');
    mysqli_select_db($con,'login');

    if(isset($_POST['upload'])){
        $fileName=$_POST['fileName'];
        $fileDescription=$_POST['content'];
        $fileUpload=$_FILES['fileUpload']['name'];
        $fileUpload_tmp=$_FILES['fileUpload']['tmp_name'];

        if($fileName=='' or $fileUpload==''){
            echo "<script>alert('Any input is Empty');</script>";
        }
        else{
            $select="SELECT * FROM upload WHERE fileName='$fileName'OR fileUpload='$fileUpload'LIMIT 1;";
            $query=mysqli_query($con,$select);
            $exist=mysqli_fetch_assoc($query);

            if($exist){
                if($exist['fileName']===$fileName || $exist['fileUpload']===$fileUpload){
                    echo"<script>alert('This file already exists!');</script>";
                }
            }else{
                move_uploaded_file($fileUpload_tmp,"file/$fileUpload");

                $uploadFile="INSERT INTO upload(fileName,fileUpload,fileDescription)
                VALUES('$fileName','$fileUpload','$fileDescription');";
                
                if(mysqli_query($con,$uploadFile)){
                    echo"<script>alert('File is Upload');</script>";
                }else{
                    echo"<script>alert('Upload Failed');</script>";
                }
            }
        }
    }

?>