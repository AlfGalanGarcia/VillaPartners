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
</style>


<body>
	<?php 
	if (!empty($detallePedido)) {
			
		$tc = $tc[0]->valorTC;
		if ($detallePedido[0]->IdEmpleadoSesion == $this->session->userdata('id'))
		{
		?>
			

		<H2><center>Cuenta Mesa #<?php echo $detallePedido[0]->IdMesa;?></center></H2>
		<div class="container">
		  <div class="row">
		    <div class="col-sm-7" id="bordeDiv">
		      <b>Detalle de pedido</b>
		      <table style="border-collapse:separate; border-spacing:1em;" width="100%">
		      	<tr>
		      		<td>Nro. Pedido&nbsp;</td><td id="tdDetallePedido" class="form-control"><?php echo $detallePedido[0]->IdPedido;?>&nbsp;</td><td></td><td></td><td style="text-align: right;"><?php echo $detallePedido[0]->FechaPedido." ".$detallePedido[0]->HoraPedido;?>&nbsp;</td>
		      	</tr>
		      	<tr><form action="#" id="formulario_valeProvisional" class="form-horizontal">
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
				                    <th>Importe</th>     			                    
				                </tr>
				            </thead>
				            <tbody>
				                <?php foreach($detallePedido as $items){?>
				                <tr>                        
	                				<td style="text-align: left;"><?php echo $items->DescripcionProducto;?></td>
	                				<td style="text-align: left;"><?php echo $items->Cantidad;?></td>
	                				<td style="text-align: left;"><?php echo $items->PrecioUnitario;?></td>
	                				<td style="text-align: left;"><?php echo $items->Importe;?></td>
		                		</tr>
		                     <?php }?>			
				            </tbody>
		      			</table>
		      		</td>
		      	</tr>
		      	<tr>
		      		<td></td><td></td><td></td><td nowrap>Total S/</td><td id="tdDetallePedido" class="form-control"><?php echo sprintf('%0.2f', $detallePedido[0]->MontoPedido);?>&nbsp;</td>
		      	</tr>
		      	<tr>
		      		<td></td><td></td><td></td><td nowrap>Total $</td><td id="tdDetallePedido" class="form-control"><?php echo sprintf('%0.2f', $detallePedido[0]->MontoPedido/$tc);?>&nbsp;</td>
		      	</tr>
		      </table>
		    </div>
		    <div class="col-sm-1" >
		      
		    </div>
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
						<button class="btn btn-primary btn-md" onclick="precuenta(<?php echo $items->IdPedido;?>)" title="Precuenta" id="botonPagar" disabled="true">PAGAR</button>
						
                        <button class="btn btn-danger btn-md" onclick="eliminar_planPago(<?php echo $items->IdPedido;?>)" title="Eliminar">CANCELAR</button>
                    	</td>
                    </tr>
	               	</form>
	            </table>
		    </div>
		  </div>
		</div>

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
    var totalPedido = <?php echo(json_encode($detallePedido[0]->MontoPedido));?>; 
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