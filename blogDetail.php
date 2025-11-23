<?php 
require 'config/config.php';
session_start();
if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in'])){
  header("location: login.php");

}


$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result =  $stmt->fetchAll();

$blogid = $_GET['id'];
$cmstmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogid");
$cmstmt->execute();
$cmresult =  $cmstmt->fetchAll();

$auresult = [];
if($cmresult){
  foreach($cmresult as $key => $value){
 
$author_id = $cmresult[$key]['author_id'];
$austmt = $pdo->prepare("SELECT * FROM users WHERE id=$author_id");
$austmt->execute();
$auresult[]=  $austmt->fetchAll(); 
}
}
if($_POST){
  $comment = $_POST['comment'];

  $stmt = $pdo->prepare("INSERT INTO comments (content, author_id, post_id)
                         VALUES (:content, :author_id, :post_id)");

  $result = $stmt->execute([
      ':content' => $comment,
      ':author_id' => $_SESSION['user_id'],
      ':post_id' => $blogid
  ]);

  if($result){
      header("Location: blogDetail.php?id=".$_GET['id']);
      exit;
  }
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0; !important ;">
    <!-- Content Header (Page header) -->
 
        

 

    <!-- Main content -->
  <section  class="content">
      <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <section class="content-header">
         <div style='text-align:center ;!important ; float:none ;' class="card-title"></div>
           
  
            <h1 style="text-align:center">Blog site</h1>
              <h4 style="text-align:center ; !important ;"><?php echo $result[0]['title']?></h4>
  
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/image/<?php echo $result[0]['image']?>" style="width:100% ; margin: auto 14px;"; alt="Photo">

                <br>
                <p><?php echo $result[0]['content']; ?></p>
 <br><br>
 <h2>Comment</h2>
 <hr>
                <span class="float-right text-muted">127 likes - 3 comments</span>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <div class="card-comment">
                  <!-- User image -->
                  <?php 
                  if($cmresult){
                  ?>
                  
                  <div class="comment-text">
                    <?php 
                    if($cmresult){
                      foreach ($cmresult as $key => $value) {
                        ?>
                        <span class="username">
                      <?php  
                      echo $auresult[$key][0]['name'] ;
                      ?>
                      <span class="text-muted float-right"><?php date("d-m-y",strtotime($value['created_at'])) ?></span>
                    </span><!-- /.username -->
                    <?php
                    echo $value['content'] ?> <hr>
                   <?php
                      }
                    }
                    ?>
                  </div>
                  <?php
                  }
                  ?>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
                
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          
            <!-- /.card -->
          </div>
</div>
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0 ; !important;" >
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
