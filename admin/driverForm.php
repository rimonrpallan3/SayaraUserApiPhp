<?php 
$page='driver';
include('class/driver.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';
$catid=@$_GET['catid'];
$row=$obj->get_row_by_col('driver','driver_id',$catid);?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Driver
            <small>Form</small> 
        </h1>
        <ol class="breadcrumb">
            <li><a href="driver.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-angle-double-left"></i>Back to Drivers</a></li>
        </ol>
    </section>
<br/>
    <!-- Main content -->
    <section class="content">

        <!-- Main row -->
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Basic Info</a></li>
             <?php if($catid){?> 
                <li><a href="#tab_2" data-toggle="tab">Cab Info</a></li>
                <li><a href="#tab_3" data-toggle="tab">Documents</a></li>
              <?php }?>
              <li class="pull-right"><a href="driverView.php?catid=<?php echo $row[0]['driver_id'];?>" title="view" class="text-muted"><i class="fa fa-eye"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Please enter Driver details:</b>

                <!-- general form elements -->
                <div class="box box-default">
 
                    <!-- /.box-header -->
                    <?php if(@$error){?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-warning"></i> Error! <?php echo $error;?>
                    </div>
                    <?php }?>
                    <?php if(@$success){?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> Success!<?php echo $success;?>
                    </div>
                    <?php }?>
                    <!-- form start -->
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id='first_name' name='first_name' value="<?php echo $row[0]['driver_first_name'];?>" class="form-control" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" id='last_name' name='last_name' value="<?php echo $row[0]['driver_last_name'];?>" class="form-control" placeholder="Full Name" required>
                                    </div>
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id='email' name='email' value="<?php echo $row[0]['driver_email'];?>" class="form-control" placeholder="Email ID" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" id='phone' name='phone' value="<?php echo $row[0]['driver_phone'];?>" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" id='city' name='city' value="<?php echo $row[0]['driver_city'];?>" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" id='country' name='country' value="<?php echo $row[0]['driver_country'];?>" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpr">CPR</label>
                                        <input type="text" id='cpr' name='cpr' value="<?php echo $row[0]['driver_cpr'];?>" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Driver Image</label>
                                        <input type="file" id='file' name='file'>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" id='username' name='username' value="<?php echo $row[0]['username'];?>" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" id='password' name='password' value="" class="form-control" placeholder="New Password" <?php if(@!$_GET['catid']){?> required <?php }?> >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label for="status">Approval Status</label>
                                <select class="form-control" id='status' name='status'>
                                    <option <?php if($row[0]['driver_status']==1) echo "selected";?> value="1">Enabled</option>
                                    <option <?php if($row[0]['driver_status']==0) echo "selected";?> value="0">Disabled</option>

                                </select>
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label for="status">Online Status Change</label>
                                <select class="form-control" id='online_status_change' name='online_status_change'>
                                    <option <?php if($row[0]['driver_online_change']==1) echo "selected";?> value="1">Enabled</option>
                                    <option <?php if($row[0]['driver_online_change']==0) echo "selected";?> value="0">Disabled</option>

                                </select>
                            </div>
                                </div>
                            </div>
                        
                           
                        </div>
                        <!-- /.box-body -->
                        <input type="hidden" name="catid" value="<?php echo @$catid;?>">
                        <input type="hidden" name="old_image" value="<?php echo @$row[0]['driver_photo'];?>">
                        <div class="box-footer">
                            <button type="submit" name="submitBasicInfo" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               <b>Please enter cab details:</b>

                <!-- general form elements -->
                <div class="box box-default">
                    <!-- form start -->
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpr">Car Type</label>
                                        <select class="form-control" id='car_type' name='car_type' required>
                                            <option value="">select</option>
                                            <?php foreach($category as $key => $value) { ?>
                                            <option <?php if($row[0]['driver_car_type']==$value['id']) echo "selected";?> value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                                        <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Car Image</label>
                                        <input type="file" id='car_photo' name='car_photo'>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <!-- /.box-body -->
                        <input type="hidden" name="catid" value="<?php echo @$catid;?>">
                        <input type="hidden" name='cpr' value="<?php echo $row[0]['driver_cpr'];?>">
                         <input type="hidden" name="old_car_image" value="<?php echo @$row[0]['diver_car_photo'];?>">
                        <div class="box-footer">
                            <button type="submit" name="submitCabInfo" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <b>Upload documents:</b>

                <!-- general form elements -->
                <div class="box box-default">
                    <!-- form start -->
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpr">Document Type</label>
                                        <select class="form-control" name='document_type' required>
                                            <option value="">select</option>
                                            <option value="License">License</option>
                                            <option value="Registration Certificate">Registration Certificate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Document Copy</label>
                                        <input type="file" name='document_name' required>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <!-- /.box-body -->
                        <input type="hidden" name="driver_id" value="<?php echo @$catid;?>">
                        <input type="hidden" name='cpr' value="<?php echo $row[0]['driver_cpr'];?>">
                        <div class="box-footer">
                            <button type="submit" name="submitDocumentInfo" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->

                

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

