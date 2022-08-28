<?php require '../config/init.php';
    require 'inc/checklogin.php';

    /*Add*/
    $act = "add";
    $category =  new Category();

    if(isset($_GET['id']) && $_GET['id']!=null){
        /*Update*/
        $act = "Update";

        $id = (int)$_GET['id'];
        if($id <= 0){
            redirect('category-list.php', 'error', 'Invalid category id.');
        }

        $category_detail = $category->getCategoryById($id);
        if(!$category_detail){
            redirect('category-list.php', 'error', 'Category not found or has been deleted.');
        }

        // debug($category_detail);
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
                        <h1 class="page-header">Category <?php echo ucfirst($act); ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12">
                        <form action="process/category.php" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        	<div class="form-group row">
                        		<label for="" class="col-sm-3">Title: </label>
                        		<div class="col-sm-9">
                        			<input type="text" name="title" required id="title" class="form-control" value="<?php echo @$category_detail[0]->title; ?>">
                        		</div>
                        	</div>
                        	<div class="form-group row">
                        		<label for="" class="col-sm-3">Summary: </label>
                        		<div class="col-sm-9">
                        			<textarea name="summary" id="summary" rows="5" style="resize: none;" class="form-control"><?php echo @$category_detail[0]->summary; ?></textarea>
                        		</div>
                        	</div>
                        	<div class="form-group row">
                        		<label for="" class="col-sm-3">Status: </label>
                        		<div class="col-sm-9">
                        			<select name="status" required id="status" class="form-control">

                        				<option value="Active" <?php echo (isset($category_detail) && $category_detail[0]->status == 'Active') ? 'selected' : '' ?>>Active</option>
                        				<option value="Inactive" <?php echo (isset($category_detail) && $category_detail[0]->status == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                        			</select>
                        		</div>
                        	</div>
                        	<div class="form-group row">
                        		<label for="" class="col-sm-3">Image: </label>
                        		<div class="col-sm-4">
                        			<input type="file" name="image" accept="image/*">
                        		</div>
                                <?php 
                                    if(isset($category_detail) && $category_detail[0]->image != null && file_exists(UPLOAD_PATH.'category/'.$category_detail[0]->image)){
                                ?>
                                    <div class="col-sm-4">
                                        <img src="<?php echo UPLOAD_URL.'category/'.$category_detail[0]->image ?>" class="img img-thumbnail img-responsive" alt="">
                                    </div>
                                <?php
                                    }
                                ?>
                        	</div>

                        	<div class="form-group row">
                        		<label for="" class="col-sm-3"></label>
                        		<div class="col-sm-9">
                                    <input type="hidden" name="cat_id" value="<?php echo @$category_detail[0]->id; ?>">
                        			<a href="category-list.php" class="btn btn-danger">
                        				<i class="fa fa-trash"></i> Cancel
                        			</a>
                        			<button class="btn btn-success" type="submit">
                        				<i class="fa fa-paper-plane"></i> Submit
                        			</button>
                        		</div>
                        	</div>
                        </form>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require 'inc/footer.php'; ?>