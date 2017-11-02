<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$input_user = array( 		
        'name'  	=> 'user',
        'id'		=> 'user',
        'class' 	=> 'form-control'        
);
$input_password = array( 		
        'name'  	=> 'password',
        'id'		=> 'password',
        'class' 	=> 'form-control'        
);
?>
<html>
<head>
    <link rel="stylesheet" href="<?php echo base_url() ?>assests/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assests/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<center><h1>Sistema Villa Partners</h1></center>
<br/><br/><br/>
<!--<table align="center">
	<td>-->
		<table align="center" style="border-collapse: separate; border-spacing: 10px;">
			<tr>
				<td colspan="2" align="center"><img src="<?php echo base_url() ?>img/logoVilla.jpg" width="50%" height="50%"></td>
			</tr>
			<?php echo form_open('LoginVilla/acceder');?>
			<tr>
				<td><label><i class="fa fa-user fa-2x"></i></label></td>
				<td><?php echo form_input($input_user);?></td>			
			</tr>
			<tr>
				<td><label><i class="fa fa-key fa-2x"></i></label></td>
				<td><?php echo form_password($input_password);?></td>
			</tr>
			<tr>
				<td align="center" colspan="2"><button type="submit" class="btn btn-danger btn-sm">Acceder</button></td>
			</tr>
			<?php echo form_close();?>
		</table>
	
<?php echo $mensaje;?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() ?>/js/bootstrap.min.js"></script>
</body>
</html>