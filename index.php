<?php
require 'config/config.php';

session_start();
if(empty($_SESSION['user_id'] || $_SESSION['logged_in'])){
  header("Location: login.php");
};

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
<div class = "wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->


  <!-- Content Wrapper. Contains page content -->
  <div class="contant-wrapper" style="margin-left:0 ; !important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        
        
            <h1 style="text-align:center">Blog site</h1>
          
      </div><!-- /.container-fluid -->
    </section>
    <?php 

    if(!empty($_GET['pageno'])){
      $pageno = $_GET['pageno'];
    }else{
      $pageno = 1;
    };
    $numOfrec = 3;
    $offset = ($pageno - 1) * $numOfrec;

  
    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
    $stmt->execute();
    $Rawresult = $stmt->fetchAll();
    
    $totalpages = ceil(count($Rawresult)/$numOfrec);

    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrec ");
   $stmt->execute();
    $result = $stmt->fetchAll();
    ?>

    <!-- Main content -->
 <section class="content">
  <div class="row">
    <?php 
    if($result){
     foreach ($result as $value) {
  


      ?>
    <div class="col-md-4">
      <div class="card card-widget">
        <div class="card-header">
          <div style="text-align:center  !important ;float :none;" class="card-title"></div>
          <h4><?php echo $value['title'] ?></h4>
        </div>
        <div class="card-body">
          <a href="blogDetail.php?id=<?php echo $value['id'] ; ?>"><img class="img-fluid pad" style="height: 200px; !important;" src="admin/image/<?php echo $value['image'] ?>" alt="Photo"></a>
        </div>
      </div>
    </div>
  
  <?php
  
 }}
  ?>
                <nav aria-label="Page navigation example" style="margin-left: 30px ;float: right !important;">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="<?php echo '?pageno=1' ?>">First</a></li>

    <li class="page-item<?php if($pageno<=0){echo 'error';} ?>"><a class="page-link
    
    
    " href="<?php if($pageno > 1){echo'?pageno='.$pageno-1 ;}else{echo '#';}?>">previous</a></li>

    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno ?></a></li>

    <li class="page-item<?php if($pageno >= $totalpages){echo 'disabled';}?>"><a class="page-link" href="<?php if($pageno <  $totalpages  ){echo'?pageno='.$pageno+1 ;}else{echo '#';}?>">Next</a></li>

    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpages?>">Last</a></li>
  </ul>
</nav>
  </div>
 
</section>

    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer style="margin-left: 0 ; !important ;"class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
    <a href="logout.php" class='btn btn-default'>Logout</a>
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
