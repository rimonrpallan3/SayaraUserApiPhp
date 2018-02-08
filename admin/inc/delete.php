<?php
require_once '../class/config.php';
require_once '../class/db.php';
$obj = new Db();
if(isset($_POST['driver_id']))
{
  $id=$_POST['driver_id'];
  $dir = DOCUMENT_ROOT."/uploads/driver/";
  $row=$obj->get_row_by_col('driver','driver_id',$id);
  $file=@$row[0]['driver_photo'];
  $resd=$obj->delete_row_by_col('driver','driver_id',$id);
  @unlink($dir.$file); 
  if($resd){
    echo "true";
    exit;
  } 
  else{
    echo "false"; 
    exit;
  }
}
if(isset($_POST['adminuser_id']))
{
  $id=$_POST['adminuser_id'];
  $dir = DOCUMENT_ROOT."/uploads/admin/";
  $row=$obj->get_row_by_col('admin','id',$id);
  $file=@$row[0]['file'];
  $resa=$obj->delete_row_by_col('admin','id',$id);
  @unlink($dir.$file); 
  if($resa){
    echo "true";
    exit;
  } 
  else{
    echo "false"; 
    exit;
  }
    
}

if($_POST['document_id'])
{
	$id=$_POST['document_id'];
 	$dir = DOCUMENT_ROOT."/uploads/documents/";
 	$row=$obj->get_row_by_col('driver_documents','document_id',$id);
  $file=$row[0]['document_name'];
  $res=$obj->delete_row_by_col('driver_documents','document_id',$id);
  unlink($dir.$file); 
  if($res){
    echo "true";
    exit;
  } 
  else{
    echo "false"; 
    exit;
  }
}
if($_POST['category_id'])
{
	$id=$_POST['category_id'];
 	$dir = DOCUMENT_ROOT."/images/category/";
 	$row=$obj->get_row_by_col('category','id',$id);
  	$file=$row[0]['file'];
  	$res=$obj->delete_row_by_col('category','id',$id);
    unlink($dir.$file); 
}
if($_POST['product_id'])
{
  $id=$_POST['product_id'];
  $dir = DOCUMENT_ROOT."/images/product/";
  $row=$obj->get_row_by_col('product','id',$id);
    $file=$row[0]['file'];
    $res=$obj->delete_row_by_col('product','id',$id);
    unlink($dir.$file); 
}
if($_POST['productapi_id'])
{
  $id=$_POST['productapi_id'];
  //$dir = DOCUMENT_ROOT."/images/product/";
  //$row=$obj->get_row_by_col('product','id',$id);
   // $file=$row[0]['file'];
    $res=$obj->delete_row_by_col('product_api','id',$id);
    //unlink($dir.$file); 
}

if($_POST['user_id'])
{
  $id=$_POST['user_id'];
  $dir = DOCUMENT_ROOT."/images/user/";
  $row=$obj->get_row_by_col('user','id',$id);
  $file=$row[0]['file'];
  $res=$obj->delete_row_by_col('user','id',$id);
  unlink($dir.$file); 
  $res=$obj->delete_row_by_col('points_earned','userid',$id);
}

if($_POST['slideshow_id'])
{
  $id=$_POST['slideshow_id'];
  $dir = DOCUMENT_ROOT."/images/slideshow/";
  $row=$obj->get_row_by_col('slideshow','id',$id);
    $file=$row[0]['file'];
    $res=$obj->delete_row_by_col('slideshow','id',$id);
    unlink($dir.$file); 
}
if($_POST['redeemgift_id'])
{
  $id=$_POST['redeemgift_id'];
  $dir = DOCUMENT_ROOT."/images/redeemgift/";
  $row=$obj->get_row_by_col('redeem_gift','id',$id);
    $file=$row[0]['file'];
    $res=$obj->delete_row_by_col('redeem_gift','id',$id);
    unlink($dir.$file); 
}
if($_POST['smartpointtype_id'])
{
  $id=$_POST['smartpointtype_id'];
  $res=$obj->delete_row_by_col('earn_type','id',$id);
}
if($_POST['smartpoint_id'])
{
  $id=$_POST['smartpoint_id'];
  $res=$obj->delete_row_by_col('points_earned','id',$id);
}
if($_POST['redeempoint_id'])
{
  $id=$_POST['redeempoint_id'];
  $res=$obj->delete_row_by_col('points_redeemed','id',$id);
}?>