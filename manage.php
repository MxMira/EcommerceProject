<?php
$pageName = 'manage';
require 'header.php'
?>
**********************************************************************************************************************************************************
MAIN CONTENT
***********************************************************************************************************************************************************
<!--main content start-->
<?php
$fname = "";
$lname = "";
$mobile = "";
$email = "";
?>
<section id="main-content">
    <section class="wrapper">
        <div class="row show-grid">

            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="fa fa-hashtag"></i> ID</th>
                    <th><i class="fa fa-user"></i> Name</th>
                    <th><i class="fa fa-envelope"></i> Email</th>
                    <th><i class=" fa fa-phone"></i> Mobile</th>
                    <th><i class=" fa fa-star"></i> Role</th>
                    <th><i class=" fa fa-gear"></i> Status</th>
                    <th><i class=" fa fa-clock-o"></i> Created at</th>
                    <th><i class=" fa fa-user-plus"></i> Created by</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                require 'require/dbconn.php';

                $stmt = $conn->query("select * from users");
                $array = $stmt->fetchAll();
                if ($array) {
                    foreach ($array as $arr) {
                        $user->id = $arr['ID'];
                        $user->full_name = $arr['full_name'];
                        $user->email = $arr['email'];
                        $user->created_at = $arr['created_at'];
                        $user->created_by = $arr['created_by'];
                        $user->role = $arr['role'];
                        $user->status = $arr['status'];
                        $user->mobile = $arr['mobile'];
                        ?>

                        <tr>
                            <td><?php echo $user->id ?></td>
                            <td><?php echo $user->full_name ?></td>
                            <td><?php echo $user->email ?></td>
                            <td><?php echo $user->mobile ?></td>
                            <td><?php echo $user->role ?></td>
                            <td><span class="label <?php if($user->status == 'active') echo 'label-success'; if($user->status == 'pending') echo 'label-info'; if($user->status == 'deactive') echo 'label-danger';?> label-mini"><?php echo $user->status ?></span></td>
                            <td><?php echo $user->created_at ?></td>
                            <td><?php echo $user->created_by ?></td>
                            <td>
                                <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="row show-grid">
            <form name="signupform" id="signupform" method="post" action="adduser.php" class="form-signin"
                  data-parsley-validate>
                <?php
                if (!empty($_GET['msg'])) {
                    if ($_GET['msg'] == 'mailexist') {
                        ?>
                        <div class="alert alert-danger">This Email already exists..</div>
                        <?php
                    }
                } elseif (!empty($_GET['user'])) {
                    ?>
                    <div class="alert alert-success">User <?php echo $_GET['user']; ?> added successfully</div>
                    <?php
                }
                ?>
                <div class="col-md-3">
                    <h1 class="h4 mb-3 font-weight-normal">Add User</h1>
                </div>
                <div class="col-md-3">
                    <label for="inputFirstName" class="sr-only">First name</label>
                    <input required type="text" id="inputFirstName" name="inputFirstName" value="<?php echo $fname ?>"
                           class="form-control" placeholder="First name"
                           autofocus>
    <span class="req">
        <?php
        if (!empty($_GET["fname"])) {
            if ($_GET["fname"] == "empty") {
                echo "First Name is Required Field";
            }
        }
        ?>
    </span>
                </div>
                <div class="col-md-3">
                    <label for="inputLastName" class="sr-only">Last name</label>
                    <input required type="text" id="inputLastName" name="inputLastName" value="<?php echo $lname ?>"
                           class="form-control"
                           placeholder="Last name">
    <span class="req">
         <?php
         if (!empty($_GET["lname"])) {
             if ($_GET["lname"] == "empty") {
                 echo "Last Name is Required Field";
             }
         }
         ?>
    </span>
                </div>
                <div class="col-md-3">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input required type="email" id="inputEmail" name="inputEmail" value="<?php echo $email ?>"
                           class="form-control"
                           placeholder="Email address">
    <span class="req">
        <?php
        if (!empty($_GET["email"])) {
            if ($_GET["email"] == "empty") echo "Email is Required Field";
            else if ($_GET["email"] == "not_valid") echo "Email is Not valid Format";
        }
        ?>
    </span>
                </div>
                <div class="col-md-3">
                    <label for="inputMobile" class="sr-only">Mobile</label>
                    <input required maxlength="11" data-parsley-type="digits" type="text" id="inputMobile" name="inputMobile" value="<?php echo $mobile ?>"
                           class="form-control"
                           placeholder="Mobile number">
    <span class="req">
        <?php
        if (!empty($_GET["mobile"])) {
            if ($_GET["mobile"] == "empty") {
                echo "Mobile is Required Field";
            }
        }
        ?>
    </span>
                </div>
                <div class="col-md-3">
                    <label for="inputrole" class="sr-only">Role</label>
                    <select id="inputrole" name="inputrole" class="form-control">
                        <option>Admin</option>
                        <option selected>Client</option>
                        <option>Seller</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="inputstatus" class="sr-only">Status</label>
                    <select id="inputstatus" name="inputstatus" class="form-control">
                        <option>Active</option>
                        <option>Deactive</option>
                        <option selected>Pending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn  btn-success btn-block" type="submit">ADD</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->

<!--main content end-->
<?php require 'footer.php' ?>
