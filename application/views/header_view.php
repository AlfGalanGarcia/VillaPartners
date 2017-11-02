<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Villa Partners</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />  
    <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/datatables/css/buttons.dataTables.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url() ?>assests/font-awesome-4.7.0/css/font-awesome.min.css"> 
    
    <style type="text/css">
    .no-sort::after { display: none!important; }
    .no-sort { pointer-events: none!important; cursor: default!important; }
    .navbar-inverse {
      padding-top: 0;
  padding-bottom: 0;
  height: 50px;
  line-height: 50px
}
  table
  {
    font-size: 12px;
  }

th.next
{
  font-family: 'FontAwesome';
  content: "\f152";
}

table.planesPago
{
  vertical-align: middle;
}

  </style>

    </head> 
<script src="<?php echo base_url('assests/jquery/jquery-3.1.0.min.js')?>"></script>
<script src="<?php echo base_url('assests/jquery/jquery-1.12.3.min.js')?>"></script>
<script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assests/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assests/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assests/datatables/js/dataTables.buttons.min.js')?>"></script>
<script src="<?php echo base_url('assests/datatables/js/buttons.colVis.min.js')?>"></script> 
<script src="<?php echo base_url('assests/datatables/js/jszip.min.js')?>"></script>
<script src="<?php echo base_url('assests/datatables/js/vfs_fonts.js')?>"></script>
<script src="<?php echo base_url('assests/datatables/js/buttons.html5.min.js')?>"></script>
<script src="<?php echo base_url('assests/datatables/js/dataTables.fixedColumns.min.js')?>"></script>
<script src="<?php echo base_url('assests/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>