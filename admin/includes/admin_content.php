<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>

            <?php  

            // $user = new User();
            // $user->username = "john";
            // $user->password = "abc123!@#";
            // $user->first_name = "John";
            // $user->last_name = "Petrucci";

            // $result = $user->create();
            
            // if ($result) {
            //     echo "<br>User inserted successfully";
            // } else {
            //     echo "<br>User insert failed!!";
            // }

            $user = User::findById(6);
            $user->last_name = "Richard";
            $user->update();

            ?>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->