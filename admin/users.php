<?php include "header.php"; ?>
<?php
session_start();
if(!isset($_SESSION['login_status']) || $_SESSION['login_status'] != true) {
    header("Location: ./index.php");
}
require_once("../config/connect.php");
$selectSql = "SELECT  userName, userEmail, userRole, userStatus FROM users";
$result = mysqli_query($conn, $selectSql);
$userDate = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>User Email</th>
                        <th>User Role</th>
                        <th>user Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($userDate as $data) :  
                            $i = 1;
                         ?>
                        <tr>
                            <td class='id'><?php echo $i++   ?></td>
                            <td><?php echo $data['userName'];  ?></td>
                            <td><?php echo $data['userEmail'];  ?></td>
                            <td><?php echo $data['userRole'];  ?></td>
                            <td><?php echo $data['userStatus'];  ?></td>
                            <td class='edit'><a href='update-user.php'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-user.php'><i class='fa fa-trash-o'></i></a></td>
                        </tr>

                        <?php endforeach  ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>