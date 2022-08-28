<?php require '../config/init.php';
    require 'inc/checklogin.php';
    $act = "add";
    $gallery = new Gallery();
    $gallery_images = new GalleryImages();

    if(isset($_GET, $_GET['id']) && !empty($_GET['id'])){
        $act = "update";
        $gallery_id = (int)$_GET['id'];
        if($gallery_id <= 0){
            redirect('gallery-list.php', 'error', 'Invalid number format');
        }

        $gallery_info = $gallery->getGalleryById($gallery_id);
    
        if(!$gallery_info){
            redirect('gallery-list.php', 'error', 'Gallery not found or has been already deleted.');
        }

        $other_images = $gallery_images->getImagesBygalleryId($gallery_id);
        // del = $gallery 
        // success => foreach($other_images){
        //  unlink(file path);
        // }
        //debug($gallery_info);
    }
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
                    	<?php flash(); ?>
                        <h1 class="page-header">Gallery <?php echo ucfirst($act); ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                	<div class="col-lg-12">

                		<form action="process/gallery.php" method="post" enctype="multipart/form-data" class="">

                			<div class="form-group row">
                			
                            	<label for="title" class="col-sm-3 col-form-label">Gallery title:</label>
                				<div class="col-sm-8">
                					<input type="text" id="title" name="title" required class="form-control" value="<?php echo @$gallery_info[0]->title; ?>">
                				</div>
                			</div>
                            <div class="form-group row">
                            
                                <label for="summary" class="col-sm-3 col-form-label">Gallery summary:</label>
                                <div class="col-sm-8">
                                    <textarea name="summary" id="summary" rows="5" style="resize: none;" class="form-control"><?php echo @$gallery_info[0]->summary; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                            
                                <label for="status" class="col-sm-3 col-form-label">Status:</label>
                                <div class="col-sm-8">
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" <?php echo (isset($gallery_info[0]->status) && $gallery_info[0]->status == 'Active') ? 'selected' : '' ; ?>>Active</option>
                                        <option value="Inactive"  <?php echo (isset($gallery_info[0]->status) && $gallery_info[0]->status == 'Inactive') ? 'selected' : '' ; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                            
                                <label for="status" class="col-sm-3 col-form-label">Cover Image:</label>
                                <div class="col-sm-4">
                                    <input type="file" name="cover_image" <?php echo ($act == 'add') ? 'required' : '' ?> accept="image/*">
                                </div>
                                <?php 
                                    if(isset($gallery_info[0]->cover_pic) && !empty($gallery_info[0]->cover_pic)){
                                ?>
                                    <div class="col-sm-4">
                                        <img src="<?php echo UPLOAD_URL.'gallery/'.$gallery_info[0]->cover_pic; ?>" alt="" class="img img-thumbnail img-responsive">
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="form-group row">
                            
                                <label for="status" class="col-sm-3 col-form-label">Other Image:</label>
                                <div class="col-sm-8">
                                    <input type="file" name="other_images[]" multiple accept="image/*">
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <?php 
                                            if(isset($other_images) && !empty($other_images)){
                                                    foreach($other_images as $key=> $images){
                                                ?>
                                                <div class="col-sm-3">
                                                    <img src="<?php echo UPLOAD_URL.'gallery/'.$images->image_name; ?>" alt="" class="img img-responsive img-thumbnail">
                                                    <br>
                                                    <a href="process/gallery.php?gallery_id=<?php echo $gallery_info[0]->id; ?>&amp;img_id=<?php echo $images->id; ?>" onclick="return confirm('Are you sure you want to delete this image?');" class="btn-link">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                                <?php
                                                if($key>0 && (($key+1)%4) == 0){
                                                    echo "<div style='clear:both;'></div>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="gallery_id" value="<?php echo @$gallery_info[0]->id; ?>">
                                    <button class="btn btn-danger" type="reset">
                                        Reset
                                    </button>
                                    <button class="btn btn-success" type="submit">
                                        Submit
                                    </button>
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