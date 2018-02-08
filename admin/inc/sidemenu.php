<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">CONTROL PANEL</li>
        <li class="<?php if(@$page=='dashboard') echo 'active';?> treeview">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>    
        </li>
        </li>
        <li class="<?php if(@$page=='user') echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="user.php"><i class="fa fa-list"></i> Users</a></li>
            <li><a href="userForm.php"><i class="fa fa-plus"></i> Add New</a></li>
          </ul>
        </li>
        <li class="<?php if(@$page=='driver') echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Driver Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="driver.php"><i class="fa fa-list"></i> Drivers</a></li>
            <li><a href="driverForm.php"><i class="fa fa-plus"></i> Add New</a></li>
          </ul>
        </li>
        <li class="<?php if(@$page=='admin') echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-user-secret"></i>
            <span>Admin User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="admin.php"><i class="fa fa-list"></i> Admin Users</a></li>
            <li><a href="adminForm.php"><i class="fa fa-plus"></i> Add New</a></li>
          </ul>
        </li>
        
        <li class="<?php if(@$page=='category') echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-car"></i>
            <span>Category Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="category.php"><i class="fa fa-list"></i> Categories</a></li>
            <li><a href="categoryForm.php"><i class="fa fa-plus"></i> Add New</a></li>
          </ul>
        </li>
         
      <!--  <li class="header">Settings</li>
        <li class="<?php if(@$page=='store') echo 'active';?>"><a href="store.php"><i class="fa fa-shopping-cart text-red"></i> <span>Stores</span></a></li>
        <li class="<?php if(@$page=='slideshow') echo 'active';?>"><a href="slideshow.php"><i class="fa  fa-picture-o text-yellow"></i> <span>Slideshow</span></a></li>
        <li class="<?php if(@$page=='set_smartpoints') echo 'active';?>"><a href="earn_type.php"><i class="fa fa-money text-aqua"></i> <span>Earn Type</span></a></li>
        <li class="<?php if(@$page=='redeemgift') echo 'active';?>"><a href="redeemgift.php"><i class="fa fa-gift text-green"></i> <span>Redeem Gifts</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>