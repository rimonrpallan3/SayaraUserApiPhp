<?php 
$page='set_smartpoints';
include('class/smartpoint.type.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Points Earn Type
        <small>Settings</small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="earn_typeForm.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-plus"></i> New Type</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
      <!-- Main row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Earn Types</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Type</th>
                  <th>Points</th>
                  <th>Per money spend</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($smartpoint){
                foreach($smartpoint as $key => $value) { ?>
                <tr>
                  <td><?php echo $value['type'];?></td>
                  <td><?php echo $value['points'];?></td>
                  <td><?php echo $value['per_value'];?></td>
                  <td><?php if($value['status']==1) echo 'Enabled'; else echo 'Disabled';?></td>
                  <td><a href="earn_typeForm.php?catid=<?php echo $value['id'];?>" class="" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-blue"></i></a> 
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
    var info = 'smartpointtype_id=' + del_id;
    if(confirm("Are you really want to delete SmartPoint? "))
    {
      $.ajax({
        type: "POST",
        url: "inc/delete.php",
        data: info,
        success: function(response){
          alert('Smartpoint deleted');
          window.location.href = "smartpointtype.php";
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

