<?php 
$page='set_smartpoints';
include('class/smartpoint.type.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';
$catid=@$_GET['catid'];
$row=$obj->get_row_by_col('earn_type','id',$catid);?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Earn type Form
        <small>Settings</small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="earn_type.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-angle-double-left"></i>Back to SmartPoints</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
      <!-- Main row -->
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Please enter earn type details</h3>
            </div>
            <!-- /.box-header -->
              <?php if(@$error){?>
                <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Error!</h4>
                <?php echo $error;?>
                </div>
              <?php }?>
              <?php if(@$success){?>
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $success;?>
                </div>
              <?php }?>
            <!-- form start -->
            <form role="form" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="type">Smart Point Type</label>
                  <input type="text" id='type' name='type' value="<?php echo $row[0]['type'];?>" class="form-control" placeholder="Point Type" required>
                </div>
                <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                  <label for="points">Points</label>
                  <input type="text" id='points' name='points' value="<?php echo $row[0]['points'];?>" class="form-control" placeholder="Points" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="per_value">Per <i class="icon fa fa-rupee"></i> spend <i class="icon fa fa-question-circle text-red" data-toggle="tooltip" title data-original-title="In case of purchase only"></i></label>
                  <input type="text" id='per_value' name='per_value' value="<?php echo $row[0]['per_value'];?>" class="form-control" placeholder="In case of purchase only" >
                </div>
              </div>
            </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id='status' name='status'>
                    <option <?php if($row[0]['status']==1) echo "selected";?> value="1">Enable</option>
                    <option <?php if($row[0]['status']==0) echo "selected";?> value="0">Disable</option>
                  
                  </select>
                </div>
              </div>
              <!-- /.box-body -->
              <input type="hidden" name="catid" value="<?php echo @$catid;?>">
              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
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

