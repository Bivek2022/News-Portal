<?php require '../config/init.php';
    require 'inc/checklogin.php';
 ?>
<?php require 'inc/header.php'; 

    //debug($_SESSION);
?>
    <div id="wrapper">

        <?php require 'inc/navbar.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Video Add</h1>
                        <?php flash(); ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <form action="process/video.php" method="post" enctype="multipart/form-data" class="form form-horizontal">
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Video title:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" id="title" required class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3">Summary:</label>
                                <div class="col-sm-9">
                                    <textarea name="summary" id="summary" rows="6" required class="form-control" style="resize: none;"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Video URL (YouTube):</label>
                                <div class="col-sm-9">
                                    <input type="text" name="url" id="url" required class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Video Thumbnail:</label>
                                <div class="col-sm-9">
                                    <input type="file" name="thumbnail" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Status:</label>
                                <div class="col-sm-9">
                                    <select name="status" required id="status" class="form-control">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3"></label>
                                <div class="col-sm-9">
                                    <button class="btn btn-danger" type="reset">Reset</button>
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require 'inc/footer.php'; ?>