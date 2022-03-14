<?php 
// Start session 
session_start(); 
 
// Get data from session 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
 
// Get status from session 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $status = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
} 
 
// Include and initialize DB class 
require_once 'DB.class.php'; 
$db = new DB(); 
 
// Fetch the users data 
$users = $db->getRows('users', array('order_by'=>'id DESC')); 
 
// Retrieve status message from session 
if(!empty($_SESSION['statusMsg'])){ 
    echo '<p>'.$_SESSION['statusMsg'].'</p>'; 
    unset($_SESSION['statusMsg']); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="row">
    <div class="col-md-12 head">
        <h5>Users</h5>
        <!-- Add link -->
        <div class="float-right">
            <a href="add.php" class="btn btn-success"><i class="plus"></i> New User</a>
        </div>
    </div>
    
    <!-- Status message -->
    <?php if(!empty($statusMsg)){ ?>
        <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
    <?php } ?>

    <!-- List the users -->
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th width="5%">#</th>
                <th width="20%">Name</th>
                <th width="25%">Email</th>
                <th width="18%">Phone</th>
                <th width="18%">Created</th>
                <th width="14%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($users)){ $i=0; foreach($users as $row){ $i++; ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['created']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">edit</a>
                    <a href="action.php?action_type=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete data?');">delete</a>
                </td>
            </tr>
            <?php } }else{ ?>
            <tr><td colspan="5">No user(s) found...</td></tr>
            <?php }  ?>
        </tbody>
    </table>
</div>