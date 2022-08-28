<?php require '../config/init.php';
    require 'inc/checklogin.php';
 ?>
<?php require 'inc/header.php'; 

    //debug($_SESSION);
?>
<link rel="stylesheet" href="<?php echo ADMIN_CSS_URL.'jquery.dataTables.min.css' ?>">
    <div id="wrapper">

        <?php require 'inc/navbar.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    	<?php flash(); ?>
                    	<h1 class="page-header">Gallery List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>S.N</th>
                                <th>Title</th>
                                <th>Cover</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $gallery = new Gallery();
                                    $all_gallery = $gallery->getAll();
                                    if($all_gallery){
                                        foreach($all_gallery as $key=>$gal_info){
                                    ?>
                                        <tr>
                                            <td><?php echo $key+1 ?></td>
                                            <td><?php echo $gal_info->title; ?></td>
                                            <td>
                                                <?php 
                                                    if($gal_info->cover_pic == null || !file_exists(UPLOAD_PATH.'gallery/'.$gal_info->cover_pic)){
                                                        echo "No Image found";
                                                    } else {
                                                ?>
                                                <img src="<?php echo UPLOAD_URL.'gallery/'.$gal_info->cover_pic ?>" style="max-width: 100px" alt="" class="img img-responsive ">
                                            <?php } ?>
                                            </td>
                                            <td><?php echo $gal_info->status; ?></td>
                                            <td>
                                                <a href="gallery-add.php?id=<?php echo $gal_info->id; ?>" class="btn-link">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                 / Delete
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require 'inc/footer.php'; ?>
<script type="text/javascript" src="<?php echo ADMIN_JS_URL.'jquery.dataTables.min.js';?>"></script>
<script>
    $(document).ready( function () {
        $('table').DataTable();
    } );
</script>