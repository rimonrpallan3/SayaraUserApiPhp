<?php 
$page='product';
include('class/product.class.php');
$id=@$_GET['id'];
$sql="SELECT * FROM product,product_category WHERE product.status=1 AND product.id='$id' AND product.id=product_category.productid ";
$row=$obj->get_row_by_query($sql);
$allcategory=$obj->get_row_by_col('category','parent','0');
include 'inc/header.php';?>
<?php include 'inc/sidemenu.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
        <small>Control panel</small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="product.php" class="btn btn-primary" style="color:#fff"><i class="fa fa-angle-double-left"></i>Back to Products</a></li>
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
              <h3 class="box-title">Please enter Product details</h3>
            </div>
            <!-- /.box-header -->
            <div class="col-md-12">
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
            </div>
            <!-- form start -->
            <form role="form" method="POST" enctype="multipart/form-data">
              <div class="box-body">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Product Name</label>
                  <input type="text" id='name' name='name' class="form-control" value="<?php echo $row[0]['name'];?>" placeholder="Product Name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="parent">Category</label>
                  <select class="form-control select2"  multiple name="category[]"  required>
                    <option value="">Select Category</option>
                    <?php foreach($allcategory as $key => $value) 
                    {?>
                      <option <?php if((@$row[0]['categoryid']==$value['id'])||(@$row[1]['categoryid']==$value['id'])||(@$row[2]['categoryid']==$value['id'])) echo "selected";?> value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                      <?php $category1=$obj->get_row_by_col('category','parent',$value['id']);
                      if($category1)
                      {
                        foreach($category1 as $key => $value1) 
                        {?>
                          <option <?php if((@$row[0]['categoryid']==$value1['id'])||(@$row[1]['categoryid']==$value1['id'])||(@$row[2]['categoryid']==$value1['id'])) echo "selected";?> value="<?php echo $value1['id'];?>"><?php echo $value['name']."&nbsp > ".$value1['name'];?></option>
                          <?php $category2=$obj->get_row_by_col('category','parent',$value1['id']);
                          if($category2)
                          {
                            foreach($category2 as $key => $value2) 
                            {?>
                              <option <?php if((@$row[0]['categoryid']==$value2['id'])||(@$row[1]['categoryid']==$value2['id'])||(@$row[2]['categoryid']==$value2['id'])) echo "selected";?> value="<?php echo $value2['id'];?>"><?php echo $value['name']."&nbsp > ".$value1['name']."&nbsp >> ".$value2['name'];?></option>
                              <?php $category3=$obj->get_row_by_col('category','parent',$value2['id']);
                              if($category3)
                              {
                                foreach($category3 as $key => $value3) 
                                {?>
                                  <option <?php if($row[0]['categoryid']==$value3['id']) echo "selected";?> value="<?php echo $value3['id'];?>"><?php echo $value['name']."&nbsp > ".$value1['name']."&nbsp >> ".$value2['name']."&nbsp >>> ".$value3['name'];?></option>
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
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description">Product Description</label>
                  <textarea id='description' name='description' class="form-control" rows="10" placeholder="Descrpition" required><?php echo $row[0]['description'];?></textarea>
                </div>
              </div>
              <div class="col-md-4">  
                <div class="form-group">
                  <label for="file1">Image1</label>
                  <input type="file" id='file1' name='file1'>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="file2">Image2</label>
                  <input type="file" id='file2' name='file2'>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="file3">Image3</label>
                  <input type="file" id='file3' name='file3'>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="file4">Image4</label>
                  <input type="file" id='file4' name='file4'>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="file5">Image5</label>
                  <input type="file" id='file5' name='file5'>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="file6">Image6</label>
                  <input type="file" id='file6' name='file6'>
                </div>
              </div> 
              <div class="col-md-4">
                <div class="form-group">
                  <label class="highlight">Show on Home Page</label>
                  <select class="form-control" name="highlight">
                    <option <?php if($row[0]['highlight']==0) echo "selected";?> value="0">No</option>
                    <option <?php if($row[0]['highlight']==1) echo "selected";?> value="1">Yes</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="highlight">Deal Type</label>
                  <select class="form-control" name="dealtype">
                    <option value="">Select</option>
                    <option <?php if($row[0]['dealtype']=='special') echo "selected";?> value="special">Special Offer</option>
                    <option <?php if($row[0]['dealtype']=='hotdeal') echo "selected";?> value="hotdeal">Hot Deal</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id='status' name='status'>
                    <option <?php if($row[0]['status']==1) echo "selected";?> value="1">Enable</option>
                    <option <?php if($row[0]['status']==0) echo "selected";?> value="0">Disable</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="meta_title">Meta Title</label>
                  <input type="text" id='meta_title' name='meta_title' class="form-control" value="<?php echo $row[0]['meta_title'];?>" placeholder="Meta Title">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="meta_description">Meta Description</label>
                  <textarea id='meta_description' name='meta_description' class="form-control" rows="5" placeholder="Meta Descrpition"><?php echo $row[0]['meta_description'];?></textarea>
                </div>
              </div>
              <?php foreach($stores as $key => $value) 
             { 
              $storeid=$value['id'];
              $productid=$row[0]['id'];
              $sql="SELECT * FROM product_store WHERE productid='".$productid."'AND storeid='".$storeid."'";
              $product_store=$obj->get_row_by_query($sql);?>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="code"><?php echo ucfirst($value['name']);?></label>
                  <input type="text" name="<?php echo 'productcode_'.$value['name'];?>" class="form-control" value="<?php echo @$product_store[0]['productcode'];?>" placeholder="Product Code">
                </div>
              </div> 
             <?php }?>
              </div>
              <!-- /.box-body -->
              <input type="hidden" name="catid" value="<?php echo @$id;?>">
              <input type="hidden" name="old_image" value="<?php echo @$row[0]['file'];?>">
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

