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
                        <h1 class="page-header">Video Listing</h1>
                        <?php flash(); ?>
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
                                <th>Video</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $video =  new Video();
                                    $all_videos = $video->getVideos();
                                    if($all_videos){
                                        foreach($all_videos as $key => $video_indv){
                                    ?>                            
                                        <tr>
                                            <td><?php  echo ($key+1); ?></td>
                                            <td><?php echo $video_indv->title ?></td>
                                            <td>
                                                <iframe 
                                                    width="200" 
                                                    height="150" 
                                                    src="https://www.youtube.com/embed/<?php echo $video_indv->video_id ?>"
                                                    frameborder="0" 
                                                    ></iframe></td>
                                            <td><?php echo $video_indv->status ?></td>
                                            <td>Edit/Delete</td>
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