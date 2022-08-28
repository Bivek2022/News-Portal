<?php 
    require '../config/init.php';
    require 'inc/checklogin.php';
    
    /*Add*/
    $act = "add";
    $news =  new News();
    $category=new Category();

    if(isset($_GET['id']) && $_GET['id']!=null){
        /*Update*/
        $act = "Update";

        $id = (int)$_GET['id'];
        if($id <= 0){
            redirect('news-list.php', 'error', 'Invalid news id.');
        }

        $news_detail = $news->getNewsById($id);
        if(!$news_detail){
            redirect('news-list.php', 'error', 'News not found or has been deleted.');
        }

        // debug($news_detail, true);
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
                        <h1 class="page-header">News <?php echo ucfirst($act); ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12">
                        <form action="process/news.php" method="post" class="form form-horizontal" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Title </label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" required id="title" class="form-control" value="<?php echo @$news_detail[0]->title; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Summary </label>
                                <div class="col-sm-9">
                                    <textarea name="summary" id="summary" rows="5" style="resize: none;" class="form-control"><?php echo @$news_detail[0]->summary; ?></textarea>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="" class="col-sm-3">Description </label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" rows="5" style="resize: none;" class="form-control"><?php echo @$news_detail[0]->description; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Category </label>
                                <div class="col-sm-9">
                                   <select name="category_id" id="category_id" required class="form-control">
                                    
                                       <option value=""> --Select One Category-- </option>
                                       <?php 
                                            $all_category=$category->getAllCategories();
                                           if($all_category){
                                            foreach ($all_category as $cat_data) {
                                                ?>
                                                <option value="<?php echo $cat_data->id; ?>"><?php echo $cat_data->title; ?></option>}
                                            <?php
                                            }
                                           }
                                        ?>
                                   </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3">News Date </label>
                                <div class="col-sm-9">
                                    <input type="date" name="news_date" id="news_date" class="form-control" value="<?php echo date(
                                    'Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">News Location</label>
                                <div class="col-sm-9">
                                    <input type="text" name="location" id="location" class="form-control">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="" class="col-sm-3">News Source</label>
                                <div class="col-sm-9">
                                    <input type="text" name="source" id="source" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Reporter </label>
                                <div class="col-sm-9">
                                   <select name="reporter" id="reporter" class='form-control'>
                                       <option value="0">Newsportal Reporter</option>
                                       <?php 
                                            $reporter=new User();
                                            $all_reporter=$reporter->getAllReporter();
                                            if($all_category){
                                                foreach ($all_reporter as $reporter_data) {
                                                    ?>
                                                    <option value="<?php echo $reporter_data->id; ?>"><?php echo $reporter_data->full_name; ?></option>
                                                    <?php 
                                                }
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-3'>Is Sticky?</label>
                                <div class="col-9">
                                    <input type="radio" name="is_sticky" value="Yes">Yes
                                    <input type="radio" name="is_sticky" value="No">No
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="" class='col-3'>Is Featured?</label>
                                <div class="col-9">
                                    <input type="radio" name="is_featured" value="Yes">Yes
                                    <input type="radio" name="is_featured" value="No">No
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3">Image </label>
                                <div class="col-sm-4">
                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Status </label>
                                <div class="col-9">
                                    <select name="status" class="form-control">
                                        <option value="Publish">Publish</option>
                                        <option value="Unpublish">Unpublish</option>
                                    </select>
                                </div>
                            </div>
                                <?php 
                                    if(isset($news_detail) && $news_detail[0]->image != null && file_exists(UPLOAD_PATH.'news/'.$news_detail[0]->image)){
                                ?>
                                    <div class="col-sm-4">
                                        <img src="<?php echo UPLOAD_URL.'news/'.$news_detail[0]->image ?>" class="img img-thumbnail img-responsive" alt="">
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3"></label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="news_id" value="<?php echo @$news_detail[0]->id; ?>">
                                    <a href="news-list.php" class="btn btn-danger">
                                        <i class="fa fa-trash"></i> Reset
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
<?php require 'inc/footer.php'; ?>
<script src="<?php echo ADMIN_VENDOR_URL?>tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
      selector: '#description',
      theme: 'modern',
      plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
      toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
      image_advtab: true,
      templates: [
        { title: 'Test template 1', content: 'Test 1' },
        { title: 'Test template 2', content: 'Test 2' }
      ],
      content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'
      ]
     });

</script>
