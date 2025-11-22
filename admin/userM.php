<?php
require "../config/config.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Blog Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 1.8rem;
            color: #343a40;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: #4a6fa5;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #3a5a8a;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-warning {
            background-color: #ffc107;
            color: #343a40;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #343a40;
        }
        
        .card-body {
            padding: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #343a40;
        }
        
        tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .status-inactive {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4a6fa5;
            box-shadow: 0 0 0 2px rgba(74, 111, 165, 0.2);
        }
        
        .search-box {
            width: 250px;
        }
        .but{
            position: absolute ;
            top: 90%;
            right :10%;
            color:white;
            background: blue;
            outline:none ;
            text-decoration:none;
             padding:20px;
            text-align:center;
            border-radius:12px;
            
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-actions {
                margin-top: 10px;
                width: 100%;
            }
            
            .search-box {
                width: 100%;
            }
            
            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <?php

 

    if(empty($_POST['search'])){
        $stmt= $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();
    }else{
 $search = $_POST['search'];
  $stmt= $pdo->prepare("SELECT * FROM users WHERE name like '%$search%' ORDER BY id DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    
    }
    ?>
    
        
        <!-- User Table -->
        <div class="card">  <!-- Header -->
            <div class="header">
                <h1>User Management</h1>
                <div class="header-actions">
                    <a href="adduser.php" class="btn btn-primary">Add New User</a>
                </div>
            </div>
            <form action="" method="post">
            <div class="card-header">
                <h2 class="card-title">All Users</h2>
                <div class="header-actions">
                    <input name="search" type="text" placeholder="Search users..." class="form-control search-box">
                </div>
            </div></form>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                           
                            <tr>
                                <th>User_ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>created_at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 
                            if($result){
                            
                            foreach ($result as $value) {
                           
                            ?>
                            <tr>
                                <td><?php echo $value['id']?></td>
                                <td><?php echo $value['name'] ?></td>
                                <td><?php echo $value['email'] ?></td>
                                <td><?php if($value['role']== 1){ echo 'admin';}else{echo "users";} ?></td>
                                <td><span class="status status-active"><?php echo date("d-m-y",strtotime($value['created_at']))?></span></td>
                                <td class="actions">
                                    <a href="edituser.php?id=<?php echo $value['id']; ?>" class="btn btn-sm btn-warning" >Edit</a>
                                    <a href="deleteuser.php?id=<?php echo $value['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                           <?php
                            }};
                           
                           ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <a type="button"  class='but' href="index.php">GO BACK</a>
        </div>
        
        <!-- Add/Edit User Form -->
       
    </div>
    
</body>
</html>