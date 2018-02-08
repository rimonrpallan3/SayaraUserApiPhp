<?php 
$page='category';
include('class/category.class.php');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';
$catid=@$_GET['catid'];
$categoryRow=$obj->get_row_by_col('category','id',$catid);
$allcategory=$obj->get_row_by_col('category','parent','0');
//$stores=$obj->get_rows('store');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
        <small>Form</small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="category.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-angle-double-left"></i>Back to Categories</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
      <!-- Main row -->
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Please enter Category details</h3>
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
                <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Category Name</label>
                  <input type="text" id='name' name='name' class="form-control" value="<?php echo $categoryRow[0]['name'];?>" placeholder="Category Name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="parent">Parent</label>
                  <select class="form-control select2 " name="parent">
                    <option value="0">No Parent Category</option>
                    <?php foreach($allcategory as $key => $value) 
                    {?>
                      <option <?php if($categoryRow[0]['parent']==$value['id']) echo "selected";?> value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                      <?php $category1=$obj->get_row_by_col('category','parent',$value['id']);
                      if($category1)
                      {
                        foreach($category1 as $key => $value1) 
                        {?>
                          <option <?php if($categoryRow[0]['parent']==$value1['id']) echo "selected";?> value="<?php echo $value1['id'];?>"><?php echo $value['name']."&nbsp > ".$value1['name'];?></option>
                          <?php $category2=$obj->get_row_by_col('category','parent',$value1['id']);
                          if($category2)
                          {
                            foreach($category2 as $key => $value2) 
                            {?>
                              <option <?php if($categoryRow[0]['parent']==$value2['id']) echo "selected";?> value="<?php echo $value2['id'];?>"><?php echo $value['name']."&nbsp > ".$value1['name']."&nbsp >> ".$value2['name'];?></option>
                              <?php $category3=$obj->get_row_by_col('category','parent',$value2['id']);
                              if($category3)
                              {
                                foreach($category3 as $key => $value3) 
                                {?>
                                  <option <?php if($categoryRow[0]['parent']==$value3['id']) echo "selected";?> value="<?php echo $value3['id'];?>"><?php echo $value['name']."&nbsp > ".$value1['name']."&nbsp >> ".$value2['name']."&nbsp >>> ".$value3['name'];?></option>
                                <?php 
                                }
                              }
                            }
                          }
                        }
                      }
                    }?>
                  </select>
                </div>
                </div>
              
              
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id='status' name='status'>
                    <option <?php if($categoryRow[0]['status']==1) echo "selected";?> value="1">Enable</option>
                    <option <?php if($categoryRow[0]['status']==0) echo "selected";?> value="0">Disable</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="file">Image</label>
                  <input type="file" id='file' name='file'>
                </div>
                </div>
              
                
                </div>
                
              <!-- /.box-body -->
              <input type="hidden" name="catid" value="<?php echo @$catid;?>">
              <input type="hidden" name="old_image" value="<?php echo @$categoryRow[0]['file'];?>">
              <div class="box-footer">
              <div class="col-md-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
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

