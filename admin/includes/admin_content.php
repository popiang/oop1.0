<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>

            <?php  

            // $user = User::findById(10);
            // $user->last_name = "Jamaluddin";
            // $user->delete();

            // $user = new User();
            // $user->username = "buckethead";
            // $user->password = "abc123!@#";
            // $user->first_name = "Bucket";
            // $user->last_name = "Head";

            // $user->save();

            // $photo = new Photo();
            // $photo->title = "my third pic";
            // $photo->description = "my third pic";

            $photo = Photo::findById(3);
            $photo->title = "my third new pic";

            $photo->save();
        
            $photos = Photo::findAll();

            foreach ($photos as $photo) {
                echo "<br>" . $photo->title;
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