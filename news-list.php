<?php require '../config/init.php';
    require 'inc/checklogin.php';
    $news = new News();
    // $category=new Category();
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
                    	<h1 class="page-header">News List</h1>
                    	<?php flash()  ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                	<div class="col-lg-12">
                		<table class="table table-bordered table-hover">
                			<thead>
                				<th>S.N.</th>
                                <!-- <th>Cagetory</th> -->
                				<th>Title</th>
                				<th>Status</th>
                				<th>Added Date</th>
                				<th>Action</th>
                			</thead>
                			<tbody>
                				<?php 
                					$all_news = $news->getAllNews();
                                    // $all_categories=$category->getAllCategories();
                                    // $category_id=$rows->category_id;
                					if($all_news){
                						foreach($all_news as $key=>$rows){
                					?>
                						<tr>
                							<td><?php echo ($key+1); ?></td>
                							<td><?php echo $rows->title; ?></td>
                							<td><?php echo $rows->status; ?></td>
                							<td><?php echo date('Y-m-d', strtotime($rows->added_date)); ?></td>
                							<td>
                								<a href="news-add.php?id=<?php echo $rows->id; ?>" class="">
                									<i class="fas fa-pencil-alt"></i>
                								</a>
                								 / 
                								 <a href="process/news.php?id=<?php echo $rows->id ?>&amp;act=del" class="" onclick="return confirm('Are you sure you want to delete this news?');">
                								 	<i class="fas fa-trash"></i>
                								 </a>
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