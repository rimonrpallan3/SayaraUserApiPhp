<?php 
$page='category';
include('class/category.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
        <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="category.php">Category</a></li>
        <?php $parent_category=$obj->get_row_by_col('category','id',@$_GET['category_id']);
        $parent_category1=$obj->get_row_by_col('category','id',@$parent_category[0]['parent']);
        if($parent_category1){?> 
          <li> <a href="category.php?category_id=<?php echo $parent_category1[0]['id'];?>"><?php echo $parent_category1[0]['name'];?> </a> </li><?php }?>
        <?php if($parent_category){?> 
          <li> <a href="category.php?category_id=<?php echo $parent_category[0]['id'];?>"><?php echo $parent_category[0]['name'];?> </a> </li><?php }?>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
      <!-- Main row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Categories</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th></th>
                  <th>Category Name</th>
                  <th>Parent</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($category){
                  foreach($category as $key => $value) { 
                  $sub_category=$obj->get_rows_by_count('category','parent',$value['id']);
                  $parent_category=$obj->get_row_by_col('category','id',@$_GET['category_id']);
                 ?>
                <tr>
                  <td><img src="<?php echo BASE_URL.'/uploads/category/'.$value['file'] ?>" style="width:30px;height:30px" /></td>
                  <td><a href="<?php if($sub_category){ echo 'category.php?category_id='.$value['id']; }else { echo '#'; }?>" class="" title="View Subcategories"><?php if($sub_category) echo "<i class='fa fa-fw fa-angle-double-right'></i>";  echo $value['name'];?></a></td>
                  <td><?php if($parent_category[0]['id']){?><a href="<?php echo 'category.php?category_id='.$parent_category[0]['parent']; ?>" class="" ><?php echo "<i class='fa fa-fw fa-angle-double-left'></i>";?> <?php echo $parent_category[0]['name'];?></a><?php }?></td>
                  <td><?php if($value['status']==1) echo 'Enabled'; else echo 'Disabled';?></td>
                  <td><a href="categoryForm.php?catid=<?php echo $value['id'];?>" class="" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-blue"></i></a> 
                     <?php if($sub_category){?><a href="category.php?category_id=<?php echo $value['id'];?>" class="" data-toggle="tooltip" title="View subcategories"><i class="fa fa-eye text-green"></i></a> <?php }?>
                   <a href="#" id="<?php echo $value['id'];?>" class="delbutton" data-toggle="tooltip" title="Remove"><i class="fa fa-trash text-red"></i></a></td>
                </tr>
                <?php }
              }?>
                
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://itvoyager.com">Voyager IT Solutions</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script type="text/javascript">
$(function() {
  $(".delbutton").click(function(){
    var element = $(this);
    var del_id = element.attr("id");
    var info = 'category_id=' + del_id;
    if(confirm("Are you really want to delete Category? "))
    {
      $.ajax({
        type: "POST",
        url: "inc/delete.php",
        data: info,
        success: function(response){
          alert('Category deleted');
          window.location.href = "category.php";
        }
      });
      $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast").animate({ opacity: "hide" }, "slow");
    }
    return false;
  });
});
</script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>

