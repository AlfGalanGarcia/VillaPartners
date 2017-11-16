<style type="text/css">
	#bordeDiv {
	    border-radius: 10px;
	    border: 2px solid #000000;  	    
	}
	#tdDetallePedido
	{
		border: 1px solid #000000; 
		text-align: right;
	}

	@media print {
    /* on modal open bootstrap adds class "modal-open" to body, so you can handle that case and hide body */
    body.modal-open {
        visibility: hidden;
    }

    body.modal-open .modal .modal-header,
    body.modal-open .modal .modal-body {
        visibility: visible; /* make visible modal body and header */
    }
	}
</style>

<script type="text/javascript">
	
	function precuenta(id)
    {
    	var estado = <?php echo(json_encode($detallePedido[0]->IdEstadoPedido));?>;
    	if (estado == 11 || estado == 12) 
    	{
			$('#moda_precuenta').modal('show');
    	}
    	else
    	{       
	        $.ajax({
	        url : "<?php echo site_url('index.php/CobrarCuenta/precuenta')?>/"+id,
	        type: "POST",
	        dataType: "JSON",
	        success: function(data)
	        {
	        	$('#moda_precuenta').modal('show');
	            //location.reload();
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error');
	        }
	        });
    	}     	

    }

    function salir()
    {
    	window.location.href = "<?php echo site_url('CobrarCuenta/index')?>";
    }

    function salir_modal()
    {
    	location.reload();
    }


	function pagar()
    {     
		if (confirm('Se va a grabar el pago, ¿está seguro?')) 
        {  
	        $.ajax({
	        url : "<?php echo site_url('index.php/CobrarCuenta/pagar')?>/",
	        type: "POST",
	        data: $('#formulario_pedido').serialize(), 
	        dataType: "JSON",
	        success: function(data)
	        {        	
	        	alert('No olvide revisar el vuelto');
	            location.reload();
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error');
	        }
	        });
        }
    }
</script>

<body>
	<?php 
	if (!empty($detallePedido)) {
			
		$tc = $tc[0]->valorTC;
		if ($detallePedido[0]->IdEmpleadoSesion == $this->session->userdata('id') || $detallePedido[0]->IdEstadoPedido != 10)
		{
		?>
			

		<H2><center>Cuenta Mesa #<?php echo $detallePedido[0]->IdMesa;?></H2><center><H4><?php echo "<p align='righ'><span style='background-color:".$detallePedido[0]->colorEtiqueta.";' class='label label-warning'>".$detallePedido[0]->Descripcion."</span></p>";?></center></H4>
		<div class="container">
		  <div class="row">
		  	<?php
		  	if ($detallePedido[0]->IdEstadoPedido == 11 || $detallePedido[0]->IdEstadoPedido == 12)
		  	{
		  		echo "<div class='col-sm-12' id='bordeDiv'>";	
		  	}
		  	else
		  	{
		  		echo "<div class='col-sm-7' id='bordeDiv'>";		
		  	}
		  	?>
		    
		      <b>Detalle de pedido</b>
		      <table style="border-collapse:separate; border-spacing:1em;" width="100%">
		      	<tr>
		      		<td>Nro. Pedido&nbsp;</td><td id="tdDetallePedido" class="form-control"><?php echo $detallePedido[0]->IdPedido;?>&nbsp;</td><td></td><td></td><td style="text-align: right;"><?php echo $detallePedido[0]->FechaPedido." ".$detallePedido[0]->HoraPedido;?>&nbsp;</td>
		      	</tr>
		      	<tr><form action="#" id="formulario_pedido" class="form-horizontal">
		      		<input value="<?php echo $detallePedido[0]->IdPedido;?>" name="input_IdPedido" type="hidden">
		      		<input value="<?php echo $detallePedido[0]->IdEmpleado;?>" name="input_IdEmpleado" type="hidden">
		      		<input value="<?php echo $detallePedido[0]->FechaPedido;?>" name="input_FechaPedido" type="hidden">
		      		<input value="<?php echo $detallePedido[0]->HoraPedido;?>" name="input_HoraPedido" type="hidden">
		      		
		      		<td><label class="control-label">Cliente</label></td><td><input name="input_NroCliente" class="form-control" type="text" placeholder="Nº de cliente"></td><td style="text-align: right;"><input name="input_NombreCliente" class="form-control" type="text" placeholder="Nombre de cliente"></td><td></td><td></td>
		      	</tr>
		      	<tr>
		      		<td><label class="control-label">RUC</label></td><td><input name="input_RucEmpresa" class="form-control" type="text" placeholder="Nº de RUC"></td><td style="text-align: right;"><input name="input_NombreEmpresa" class="form-control" type="text" placeholder="Nombre de empresa"></td><td></td><td></td>
		      	</tr>
		      	<tr>
		      		<td colspan="5" id="tdDetallePedido">
		      			<table class="table table-striped table-bordered">
				            <thead>
				                <tr>			                    
				                    <th>Descripción</th>
				                    <th>Cantidad</th>                      
				                    <th>Precio unitario</th> 
									<th>IGV</th> 			                                          
				                    <th>Importe</th>     			                    
				                </tr>
				            </thead>
				            <tbody>
				                <?php 
				                $importe = 0.00;
				                foreach($detallePedido as $items){?>
				                <tr>                        
	                				<td style="text-align: left;"><?php echo $items->DescripcionProducto;?></td>
	                				<td style="text-align: left;"><?php echo $items->Cantidad;?></td>
	                				<td style="text-align: left;"><?php echo sprintf('%0.2f', $items->PrecioUnitarioProducto-($items->PrecioUnitarioProducto*0.18));?></td>
	                				<td style="text-align: left;"><?php echo sprintf('%0.2f', $items->PrecioUnitarioProducto*0.18);?></td>
	                				<td style="text-align: left;"><?php echo sprintf('%0.2f', ($items->Cantidad)*$items->PrecioUnitarioProducto);?></td>
		                		</tr>
		                     <?php
		                     	$importe += (($items->Cantidad)*$items->PrecioUnitarioProducto);
		                 		}?>			
				            </tbody>
		      			</table>
		      		</td>
		      	</tr>
		      	<tr>
		      		<td>
						<?php
						if ($detallePedido[0]->IdEstadoPedido == 11 || $detallePedido[0]->IdEstadoPedido == 12)
						{		    	
						?>
		      			<span class="btn btn-warning btn-md" onclick="precuenta(<?php echo $items->IdPedido;?>)" title="Precuenta" id="botonPrecuenta">TICKET</span>
		      			<?php						
						}	
						else
						{
						?>
						<span class="btn btn-success btn-md" onclick="precuenta(<?php echo $items->IdPedido;?>)" title="Precuenta" id="botonPrecuenta">PRECUENTA</span>
						<?php
						}
						?>

		      		</td><td></td><td></td><td nowrap>Total S/</td><td id="tdDetallePedido" class="form-control"><?php echo sprintf('%0.2f', $importe);?>&nbsp;</td>
		      	</tr>
		      	<tr>
		      		<td></td><td></td><td></td><td nowrap>Total $</td><td id="tdDetallePedido" class="form-control"><?php echo sprintf('%0.2f', $importe/$tc);?>&nbsp;</td>
		      	</tr>
		      </table>
		    </div>
		    <div class="col-sm-1" >
		      
		    </div>

		    <?php
		    	if ($detallePedido[0]->IdEstadoPedido < 11)
		    	{		    	
		    ?>
		    <div class="col-sm-4" id="bordeDiv">
				<b>Pago</b><br>				
				<table style="border-collapse:separate; border-spacing:1em;">
					<tr>
						<td colspan="2"><?php echo "T.C.: ".$tc;?></td>
					</tr>
					<tr>
						<td>
		            		<label class="control-label">Comprobante</label>
	        			</td>
	        			<td>
	        				<select name="input_IdTipoDoc" class="form-control">	        					
		                    <?php 
		                    $comprobante = array_slice($tipoDoc,0,2);
		                    foreach ($comprobante as $item) {
		                        echo "<option value='".$item->IdTipoDoc."'>".$item->DescripcionTipoDoc."</option>";
		                    }
		                    ?>
		                	</select>        				
	        			</td>
	        		</tr>
					<tr>
						<td>
							<label class="control-label">Moneda</label>
						</td>
						<td>
	        				<select name="input_IdMoneda" class="form-control" id='moneda'>
		                    <?php 	                    
		                    foreach ($moneda as $item) {
		                        echo "<option value='".$item->IdMoneda."'>".$item->DescripcionMoneda."</option>";
		                    }
		                    ?>
		                	</select>   
						</td>
					</tr>
					<tr>
						<td>
							<label class="control-label">Efectivo</label>
						</td>
						<td>
							<input name="input_MontoEfectivo" class="form-control" type="text" id="efectivo">
						</td>
					</tr>
					<tr>
						<td>
							<label class="control-label">Tarjeta</label>
						</td>
						<td>
							<input name="input_MontoTarjeta" class="form-control" type="text" id="tarjeta">
						</td>
					</tr>
					<tr>
						<td>
							<label class="control-label">Vuelto S/</label>
						</td>
						<td>
							<input type="text" id="vuelto" class="form-control" readonly></span>
							<input type="hidden" id="tipoMoneda" class="form-control"></span>
						</td>
					</tr>
					<tr style="text-align: center;">
						<td colspan="2">
						<button class="btn btn-primary btn-md" onclick="pagar()" title="Pagar" id="botonPagar" disabled="true">PAGAR</button>						
                    	</td>
                    </tr>
	               	</form>
	            </table>
	        	</div>		    
		  </div>
		  	<?php
		  	}
		  	?>
		</div><br>
		<p align="center"><span class="btn btn-danger btn-md" onclick="salir()" title="Eliminar">SALIR</span></p>
		<?php
		}
		else
		{
			echo "<font color='red'><b>No se puede mostrar el pedido. Atendido por el usuario: ".$detallePedido[0]->aliasSesion."</font></b>";
		}
	}
	else
	{
		echo "No se puede acceder a esta página";
	}
	?>
</body>

<div class="modal fade" id="moda_precuenta" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
                <div class="col-md-6 pull-left">
                	<?php
						if ($detallePedido[0]->IdEstadoPedido == 11 || $detallePedido[0]->IdEstadoPedido == 12)
						{		    	
						?>
                    	<h3 class="modal-title">TICKET</h3>                
                    	<?php
                    	}
                    	else
                		{ 
                    	?>
						<h3 class="modal-title">PRECUENTA</h3>                
                    	<?php
                		}
                		?>

                </div>
            </div>      
            <div class="modal-body" style="height: 500px;"> 
            <center>
            	VILLA CHICKEN CERCADO DE LIMA<br>
				VILLA CHICKEN SAC<br>
				Jr. Ica Nro. 153 (También 157 y 165)<br>				
				Lima - Lima - Lima<br>
				RUC: 20511235066			
			<p align="right">FECHA-HORA: <?php echo $detallePedido[0]->FechaPedido." ".$detallePedido[0]->HoraPedido;?></p>
			<p align="left">CAJERO: <?php echo $this->session->userdata('empleado');?><br>MESA: <?php echo $detallePedido[0]->IdMesa;?> MOZO: <?php echo $detallePedido[0]->nombres;?></p>
			<p align="right">N.PEDIDO: <?php echo $detallePedido[0]->IdPedido;?><br>N: IMPRESIÓN: #<?php echo $detallePedido[0]->IdPedido*3;?><br>TC: <?php echo $tc;?></p>
			</center>
			
			               
               <table class="table table-striped table-bordered">
				            <thead>
				                <tr>			                    
           							<th>Descripción</th>
				                    <th>Cantidad</th>                      
				                    <th>Precio unitario</th> 
									<th>IGV</th> 			                                          
				                    <th>Importe</th>        			                    
				                </tr>
				            </thead>
				            <tbody>
				                <?php foreach($detallePedido as $items){?>
				                <tr>                        
	                				<td style="text-align: left;"><?php echo $items->DescripcionProducto;?></td>
	                				<td style="text-align: left;"><?php echo $items->Cantidad;?></td>
	                				<td style="text-align: left;"><?php echo $items->PrecioUnitarioProducto-($items->PrecioUnitarioProducto*0.18);?></td>
	                				<td style="text-align: left;"><?php echo $items->PrecioUnitarioProducto*0.18;?></td>
	                				<td style="text-align: left;"><?php echo ($items->Cantidad)*$items->PrecioUnitarioProducto;?></td>
		                		</tr>
		                     <?php }?>	
		                     	<tr> 
		                     		<td colspan="5" style="text-align: right;">Total S/ <?php echo $importe;?></td>
		                     	</tr>
		                     	<tr> 
		                     		<td colspan="5" style="text-align: right;">Total $ <?php echo sprintf('%0.2f', $importe/$tc);?></td>
		                     	</tr>		
				            </tbody>
		      			</table>
            </div>
            <div class="modal-footer"> 
            
    			<button type="button" class="btn btn-primary" onclick="js:window.print()"><i class="fa fa-print fa-2x" aria-hidden="true"></i></button>               
                <button type="button" class="btn btn-danger" onclick="salir_modal()" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	$("#moneda").change(function()
	{
	    $("#tipoMoneda").val($(this).val());
  		$("#tipoMoneda").keyup();
	})

	$('input').keyup(function(){ 
    var efectivo  = Number($('#efectivo').val());
    var tarjeta = Number($('#tarjeta').val());
    var moneda = Number($('#tipoMoneda').val());
    var tc = <?php echo(json_encode($tc));?>;   
    var totalPedido = <?php echo(json_encode($importe));?>; 
    var cero = 0;  

    if (efectivo < 0 || tarjeta < 0) 
    {
    	alert("No se permiten montos negativos");
    }
    else
    {
    	if (moneda == 2)
	    {
	    	efectivo *= tc;
	    }
	    if (efectivo > 0 && tarjeta == '')
	    {
	    	if ((efectivo - totalPedido) >= 0)
	    	{
	    		document.getElementById('vuelto').value = efectivo - totalPedido;		
	    	}
	    	
	    }
	    else if (efectivo == '' && tarjeta > 0)
	    {
	    	document.getElementById('vuelto') = cero;		
	    }
	    else
	    {
	    	if (((efectivo + tarjeta) - totalPedido) >= 0)
	    	{
	    		document.getElementById('vuelto').value = (efectivo + tarjeta) - totalPedido;		
	    	}
	    }
    }
    
	   	if((efectivo+tarjeta) > totalPedido)
	    {
	    	document.getElementById("botonPagar").disabled = false;
	    }
		else
		{
		    document.getElementById("botonPagar").disabled = true;
		}
	});



</script>