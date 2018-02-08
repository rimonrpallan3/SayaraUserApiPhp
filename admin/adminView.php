<?php 
$page='user';
include('class/admin.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';
$catid=@$_GET['catid'];
$row=$obj->get_row_by_col('admin','id',$catid);
//$row_car=$obj->get_row_by_col('category','id',$row[0]['driver_car_type']);?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Admin<small>Details</small></h1>
        <ol class="breadcrumb">
            <li><a href="admin.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-angle-double-left"></i>Back to Admin Users</a></li>
        </ol>
    </section>
<br/>
    <!-- Main content -->
    <section class="content">

        <!-- Main row -->
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <img src="<?php if($row[0]['file']) echo BASE_URL.'/uploads/admin/'.$row[0]['file']; else echo 'dist/img/avatar5.png'; ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Admin Name: </label>
                                        <?php echo $row[0]['name'];?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email: </label>
                                        <?php echo $row[0]['email'];?>
                                    </div>
                                </div>
                                

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">Username: </label>
                                        <?php echo $row[0]['username'];?>
                                    </div>
                                </div>
                               


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Approval Status: </label>
                                        <?php if($row[0]['status']==1) echo "Enabled"; else echo "Disabled";?> 
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Joined: </label>
                                        <?php echo $row[0]['created_at'];?>
                                    </div>
                                </div>
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Last Updated: </label>
                                        <?php echo $row[0]['updated_at'];?>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                        </div>

                        <div class="box-footer">
                            <a href="adminForm.php?catid=<?php echo $row[0]['id'];?>" class="btn btn-primary" style="color:#fff"><i class="fa fa-pencil"></i> Edit</a>
                        </div>

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

