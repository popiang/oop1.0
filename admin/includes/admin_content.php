<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>

            <?php  

            $user = User::findById(2);
            echo "<br>username: " . $user->username;
            echo "<br>first name: " . $user->first_name;
            echo "<br>last name: " . $user->last_name;

            echo "<br>";

            $users = User::findAllUsers();
            foreach ($users as $user) {
                echo "<br>username: " . $user->username;
            }
            
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