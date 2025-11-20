<?php 


session_start();
require "../config/config.php";

if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in'])){
    header("location:login.php");

}
if($_POST){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
   
    if($_FILES){
  $file = 'image/'.$_FILES['image']['name'];
$imagetype = pathinfo($file,PATHINFO_EXTENSION);
  
   
 if($imagetype !='png' && $imagetype != 'jpeg' && $imagetype != 'jpg' ){
    echo"<script>alert('image must be png or jpg or jpeg')</script>";

  }else{
  
    
    $image = $_FILES['image']['name'];
    
    move_uploaded_file($_FILES['image']['tmp_name'],$file);

   $stmt = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id ='$id'");
   $result = $stmt->execute();
    if($result){
        echo "<script>alert('Post updated successfully');window.location.href=`index.php`</script>";
    } 
}

    }

    }
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
    $stmt->execute();
    $result = $stmt->fetchAll();
   


?>

<?php include("header.php") ?>

 <div class="content">
  <div class="container-fluid">
    <div class="row-md-12">
      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
           <form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
    <label for="">Title</label>
    <input type="text" class='form-control' name="title" value ="<?php echo $result[0]['title']; ?>" required>
</div>
<div class="form-group">
    <label for="">Content</label><br>
    <textarea cols='80' name='content' rows='8' ><?php echo $result[0]['content']; ?></textarea>
</div>
<div class="form-group">
    <label for="">Image</label><br>
    <img src="image/<?php echo $result[0]['image']; ?>" width="150" height="150" alt="" srcset="">
    <br><input type="file" name='image' value=''>
</div>
 <div class="form-group">
  <input type="submit" name='' value = "ADD" class='btn btn-success'>
  <a href="index.php" class='btn btn-warning'>Back</a>
 </div>
           </form>
             </div>
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    </div>
  </div>
 </div>
    
<?php  include("footer.html")?>