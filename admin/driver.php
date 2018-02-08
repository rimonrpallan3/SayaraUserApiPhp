<?php 
$page='driver';
include('class/driver.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver
        <small>List</small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="driverForm.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-plus"></i> New Driver</a></li>
      </ol>
    </section>
<br/>
    <!-- Main content -->
    <section class="content">
     
      <!-- Main row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
       
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>CPR</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($driver){
                foreach($driver as $key => $value) { ?>
                <tr class="record">
                  <td>
                    <i class="fa fa-circle <?php if($value['driver_online']==1) echo 'text-success';?>"> </i>
                    <img src="<?php if($value['driver_photo']) echo BASE_URL.'/uploads/driver/'.$value['driver_photo']; else echo 'dist/img/avatar5.png'; ?>" style="width:25px;height:25px" />
                  <a href="driverView.php?catid=<?php echo $value['driver_id'];?>"><?php echo $value['driver_first_name'].' '.$value['driver_last_name'];?></a></td>
                  <td><?php echo $value['driver_email'];?></td>
                  <td><?php echo $value['driver_phone'];?></td>
                  <td><?php echo $value['driver_cpr'];?></td>
                  <td><?php if($value['driver_status']==1) echo 'Enabled'; else echo 'Disabled';?></td>
                  <td><a href="driverForm.php?catid=<?php echo $value['driver_id'];?>" class="" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-blue"></i></a> 
                    <a href="#" id="<?php echo $value['driver_id'];?>" class="delbutton" data-toggle="tooltip" title="Remove"><i class="fa fa-trash text-red"></i></a></td>
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
    var info = 'driver_id=' + del_id;
    if(confirm("Are you really want to delete Driver? "))
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

