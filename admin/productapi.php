<?php 
$page='apiproduct';
include('class/product.api.class.php');
if(isset($_POST['submit'])){
  if($_POST['storeid']==1)
    include 'class/api.flipkart.php';
  if($_POST['storeid']==2)
    include 'class/api.amazon.php';
}
$products_api=$obj->get_rows('product_api');
include 'inc/header.php';?>
<style>
input[type="checkbox"]{
  width: 20px; /*Desired width*/
  height: 20px; /*Desired height*/
  cursor: pointer;
}

</style>
<?php include 'inc/sidemenu.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li>

        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
      <!-- Main row -->
      <div class="row">
        <div class="col-md-6">
          <form method="POST">
            <div class="box-body">
              <div class="col-md-6">
              <div class="form-group">
                <select class="form-control" name="storeid">
                  <option value="">Select Store</option>
                  <?php if($stores){
                  foreach($stores as $key => $value) { ?>
                    <option <?php if(@$_POST['storeid']==$value['id']) echo "selected";?> value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                  <?php }
                  }?>
                </select>  
              </div>
              </div>
              <div class="col-md-6">
              	<div class="form-group">
                	<button type="submit" name="submit" class="btn btn-primary">Update Products</button> 
              	</div>
              </div>
             </div>
          </form>
        </div>
        <form method="POST">
        <div class="col-md-6">
            <div class="box-body">
              <div class="col-md-3">
              	<div class="form-group">
              	    <label> <input type="checkbox" name="chk[]" id="checkAll" /> Select all</label>
              	</div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <select class="form-control" name="checkoption">
                  <option value="">Select action</option>
                  <option value="enable">Enable</option>
                  <option value="disable">Disable</option>
                  <option value="delete">Delete</option>
                </select>  
              </div>
              </div>
              <div class="col-md-3">
              	<div class="form-group">
                	<button type="submit" name="optsubmit" class="btn btn-primary">Submit</button> 
              	</div>
              </div>
             </div>
          
        </div>
        
        <div class="col-xs-12">
          <?php if(@$count>0){?>
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fa fa-check"></i> Success! <span> <?php echo $count; if(@$_POST['checkoption']=="delete") echo ' Products Deleted'; else echo ' Products updated';?></span></h5>
                </div>
              <?php }?>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Products</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Image</th>
                  <th>Store</th>
                  <th>Product Name</th>
                  <th>MRP</th>
                  <th>OfferPrice</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($products_api){
                  foreach($products_api as $key => $value) {  
                    $product1=$obj->get_row_by_col('product','id',$value['productid']);
                    $store1=$obj->get_row_by_col('store','id',$value['storeid']);?>
                <tr>
                  <td><img src="<?php echo BASE_URL.'/images/product/'.$product1[0]['file'].'_1.jpg'; ?>" style="width:25px;height:25px" /></td>
                  <td><img src="<?php echo BASE_URL.'/images/store/'.$store1[0]['file']; ?>" style="width:35px;height:25px" /></td>
                  <td><a href="<?php echo $value['url'];?>"><?php echo $value['name'];?></a></td>
                  <td><?php echo $value['mrp'];?></td>
                  <td><?php echo $value['offerprice'];?></td>
                  <td><?php if($value['status']==1) echo '<span class="badge bg-green">Enabled</span>'; else echo '<span class="badge bg-yellow">Disabled</span>';?> </td>
                  <td><input type="checkbox" name="checkarr[]" id="chk" value="<?php echo $value['id'];?>" />
                   <a href="#" id="<?php echo $value['id'];?>" class="delbutton" data-toggle="tooltip" title="Remove"><i class="fa fa-trash fa-2x text-red"></i></a></td>
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
        </form>
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
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script type="text/javascript">
$(function() {

  $(".delbutton").click(function(){
    var element = $(this);
    var del_id = element.attr("id");
    var info = 'productapi_id=' + del_id;
    if(confirm("Are you really want to delete Product? "))
    {
      $.ajax({
        type: "POST",
        url: "inc/delete.php",
        data: info,
        success: function(response){
          alert('Product deleted');
          window.location.href = "productapi.php";
        }
      });
      $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast").animate({ opacity: "hide" }, "slow");
    }
    return false;
  });
});
</script>
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

$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

 </script> 
</body>
</html>

