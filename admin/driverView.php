<?php 
$page='driver';
include('class/driver.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';
$catid=@$_GET['catid'];
$row=$obj->get_row_by_col('driver','driver_id',$catid);
$row_car=$obj->get_row_by_col('category','id',$row[0]['driver_car_type']);
$row_document=$obj->get_row_by_col('driver_documents','driver_id',$catid);?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Driver
            <small>Details</small> 
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
              <li class="pull-right"><a href="driverForm.php?catid=<?php echo $row[0]['driver_id'];?>" title="edit" class="text-muted"><i class="fa fa-pencil"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Driver details:</b>
                <!-- general form elements -->
                <div class="box box-primary">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <img src="<?php if($row[0]['driver_photo']) echo BASE_URL.'/uploads/driver/'.$row[0]['driver_photo']; else echo 'dist/img/avatar5.png'; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Driver Name: </label>
                                        <?php echo $row[0]['driver_first_name'];?> <?php echo $row[0]['driver_last_name'];?>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email: </label>
                                        <?php echo $row[0]['driver_email'];?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone: </label>
                                        <?php echo $row[0]['driver_phone'];?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City: </label>
                                        <?php echo $row[0]['driver_city'];?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country: </label>
                                        <?php echo $row[0]['driver_country'];?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpr">CPR: </label>
                                        <?php echo $row[0]['driver_cpr'];?>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username: </label>
                                        <?php echo $row[0]['username'];?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Approval Status: </label>
                                        <?php if($row[0]['driver_status']==1) echo "Enabled"; else echo "Disabled";?> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Online Status Change: </label>
                                        <?php if($row[0]['driver_online_change']==1) echo "Enabled"; else echo "Disabled";?> 
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

                </div>
                <!-- /.box -->
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
               <b>Cab details:</b>
               <!-- general form elements -->
                <div class="box box-primary">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <img src="<?php if($row[0]['driver_car_photo']) echo BASE_URL.'/uploads/cars/'.$row[0]['driver_car_photo']; else echo 'dist/img/caravatar.png'; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Car Type: </label>
                                        <?php echo $row_car[0]['name'];?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                </div>
                <!-- /.box -->
            </div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
               <b>Documents:</b>
               <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <?php if($row_document){
                                foreach($row_document as $key => $value) { ?>
                                <div class="col-md-6 record">
                                    <div class="form-group">
                                        <?php echo $value['document_type'];?>  <a href="#" id="<?php echo $value['document_id'];?>" class="delbutton" data-toggle="tooltip" title="Remove"><i class="fa fa-trash text-red"></i></a><br/>
                                       <img src="<?php  echo BASE_URL.'/uploads/documents/'.$value['document_name']; ?>" style="width:300px;height:250px;">
                                    </div>
                                </div>
                            <?php }
                            }?>
                        </div>   
                    </div>
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
<script type="text/javascript">
$(function() {
  $(".delbutton").click(function(){
    var element = $(this);
    var del_id = element.attr("id");
    var info = 'document_id=' + del_id;
    if(confirm("Are you really want to this document? "))
    {
      $.ajax({
        type: "POST",
        url: "inc/delete.php",
        data: info,
        success: function(response){
          if(response=='true'){
            element.parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast").animate({ opacity: "hide" }, "slow");
          }
          else{
            alert("Unable to remove driver!");
          }
        }
      });
     
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
</script>
</body>
</html>

