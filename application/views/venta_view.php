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
		      		<td>Nro. Pedido&nbsp;</td><td id="tdDetallePedido"><?php echo $detallePedido[0]->IdPedido;?>&nbsp;</td><td></td><td></td><td style="text-align: right;"><?php echo $detallePedido[0]->FechaPedido." ".$detallePedido[0]->HoraPedido;?>&nbsp;</td>
		      	</tr>
		      	<tr>
		      		<td>Cliente</td><td>1234123</td><td style="text-align: right;">Pepe</td><td></td><td></td>
		      	</tr>
		      	<tr>
		      		<td>Ruc</td><td>1234132</td><td style="text-align: right;">Empresa Pepe</td><td></td><td></td>
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
		      		<td></td><td>Total S/</td><td></td><td></td><td id="tdDetallePedido"><?php echo sprintf('%0.2f', $detallePedido[0]->MontoPedido);?>&nbsp;</td>
		      	</tr>
		      	<tr>
		      		<td></td><td>Total $</td><td></td><td></td><td id="tdDetallePedido"><?php echo sprintf('%0.2f', $detallePedido[0]->MontoPedido*$tc);?>&nbsp;</td>
		      	</tr>
		      </table>
		    </div>
		    <div class="col-sm-1" >
		      
		    </div>
		    <div class="col-sm-4" id="bordeDiv">
				<b>Pago</b><br>
				<p align="right"><?php echo "T.C.: ".$tc;?></p>
				<table style="border-collapse:separate; border-spacing:1em;">
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
	        				<select name="input_IdMoneda" class="form-control">
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
						</td>
					</tr>
					<tr>
						<td>
							<label class="control-label">Tarjeta</label>
						</td>
						<td>
						</td>
					</tr>
	                	
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