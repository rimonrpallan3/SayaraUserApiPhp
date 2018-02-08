<?php 
$page='smartpoint';
include('class/smartpoint.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';
$catid=@$_GET['catid'];
$row=$obj->get_row_by_col('points_earned','id',$catid);
$allrow=$obj->get_row_by_col('earn_type','status','1');
$alluser=$obj->get_row_by_col('user','status','1')?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Points Earn Form
        <small>Control Panel</small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="smartpoint.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-angle-double-left"></i>Back to Points Earned</a></li>
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
              <h3 class="box-title">Please enter earning points details</h3>
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
                  <label for="user">User</label>
                  <select class="form-control select2" name="user" id="type" required>
                    <option value="">Select User</option>
                  <?php foreach($alluser as $key => $value) 
                    {?>
                      <option <?php if($row[0]['userid']==$value['id']) echo "selected";?> value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="type">Earn Type</label>
                  <select class="form-control select2" name="type" id="type" required>
                    <option value="">Select Earning Type</option>
                  <?php foreach($allrow as $key => $value) 
                    {?>
                      <option <?php if($row[0]['earn_type']==$value['id']) echo "selected";?> value="<?php echo $value['id'];?>"><?php echo $value['type'];?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="price" id='price' name='price' value="<?php echo $row[0]['price'];?>" class="form-control" placeholder="Price Expected" required>
                </div>
                <div class="form-group">
                  <label for="points">Points</label>
                  <input type="points" id='points' name='points' value="<?php echo $row[0]['points'];?>" class="form-control" placeholder="Points" required>
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea id='description' name='description' class="form-control" placeholder="Descrpition"><?php echo $row[0]['description'];?></textarea>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control select2" id='status' name='status'>
                    <option value="">select</option>
                    <option <?php if($row[0]['status']=='Pending') echo "selected";?> value="Pending">Pending</option>
                    <option <?php if($row[0]['status']=='Confirmed') echo "selected";?> value="Confirmed">Confirmed</option>
                    <option <?php if($row[0]['status']=='Verified') echo "selected";?> value="Verified">Verified</option>
                    <option <?php if($row[0]['status']=='Expired') echo "selected";?> value="Expired">Expired</option>
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
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
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
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
</body>
</html>