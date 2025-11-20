
<?php 




if(empty($_GET['pageno'])){
  $pageno = 1 ;
}else{
  $pageno = $_GET['pageno'];
};
$numOfrec = 1 ;
$offset = ($pageno -1)* $numOfrec;

if(empty($_POST['search'])){
$stmt = $pdo->prepare("SELECT * FROM posts order by id desc");
$stmt ->execute();
$rawresult = $stmt->fetchAll();

$totalPage = ceil(count($rawresult)/$numOfrec);
$stmt=$pdo->prepare("SELECT  * FROM posts order by id desc Limit $offset,$numOfrec");
$stmt->execute();
$result = $stmt->execute();
}else{

  $searchKey = $_POST['search'];

  $stmt = $pdo->prepare("SELECT * FROM posts  where title like '%$searchKey%'order by id desc");
$stmt ->execute();
$rawresult = $stmt->fetchAll();

$totalPage = ceil(count($rawresult)/$numOfrec);
$stmt=$pdo->prepare("SELECT  * FROM posts where title like '%$searchKey%' order by id desc Limit $offset,$numOfrec");
$stmt->execute();
$result = $stmt->execute();
}


<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="<?php echo '?pageno=1'?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">First</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="<?php if($pageno > 1){echo '?pageno=' $pageno-1 ; }else{echo '#';} ?>">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#"><?php echo $value ['pageno']?></a></li>
    <li class="page-item"><a class="page-link" href="<?php if($pageno != $totalPage){echo '?pageno=' $pageno+1 ; }else{echo '#';} ?>">">Next</a></li>
    <li class="page-item">
      <a class="page-link" href=" '?pageno=<?php $totalPage ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Last</span>
      </a>
    </li>
  </ul>
</nav>