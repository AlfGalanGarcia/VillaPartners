<style type="text/css">
	button
	{
		padding: 0;
		border: none;
		background: none;
	}

	#bordeDiv {
    border-radius: 10px;
    border: 2px solid #000000;  
    margin-left: 20px;
	}
</style>

<script type="text/javascript">

   function cerrar_caja(id)
    {    	
    	if (totalCierreCajaSoles == 0 && totalCierreCajaDolares == 0)
    	{
			if (confirm('¿Está seguro? Se va a cerrar la caja')) 
	        {
	            $.ajax({
	            url : "<?php echo site_url('index.php/AbrirCaja/cerrar_caja')?>/"+id,
	            type: "POST",
	            dataType: "JSON",
	            success: function(data)
	            {
	                location.reload();
	            },
	            error: function (jqXHR, textStatus, errorThrown)
	            {
	                alert('Error cerrando la caja');
	            }
	            });
	        }    		
    	}
    	else
    	{
    		 alert('No se puede cerrar la caja con una diferencia distinta a 0.00');
    	}
    }

    function reiniciar_conteo()
    {
        location.reload();
    }

</script>

<body>
<div class="container">	
	<div class="row">
	  	<div class="col-sm-5" id="bordeDiv">
	  		<CENTER><B>SOLES</B></CENTER>
	  		<button onclick="incrementaValorSoles(0.10); contadorMas('m01soles')"><img src="<?php echo base_url() ?>img/dinero/moneda01soles.png"></button>
	  		<button onclick="incrementaValorSoles(0.20); contadorMas('m02soles')"><img src="<?php echo base_url() ?>img/dinero/moneda02soles.png"></button>
	  		<button onclick="incrementaValorSoles(0.50); contadorMas('m05soles')"><img src="<?php echo base_url() ?>img/dinero/moneda05soles.png"></button>
	  		<button onclick="incrementaValorSoles(1.00); contadorMas('m1soles')"><img src="<?php echo base_url() ?>img/dinero/moneda1soles.png"></button>
	  		<button onclick="incrementaValorSoles(2.00); contadorMas('m2soles')"><img src="<?php echo base_url() ?>img/dinero/moneda2soles.png"></button>
	  		<button onclick="incrementaValorSoles(5.00); contadorMas('m5soles')"><img src="<?php echo base_url() ?>img/dinero/moneda5soles.png"></button>
	  		<br>
	  		<button onclick="incrementaValorSoles(10); contadorMas('b10soles')"><img src="<?php echo base_url() ?>img/dinero/billete10soles.png"></button>
	  		<button onclick="incrementaValorSoles(20); contadorMas('b20soles')"><img src="<?php echo base_url() ?>img/dinero/billete20soles.png"></button>
	  		<button onclick="incrementaValorSoles(50); contadorMas('b50soles')"><img src="<?php echo base_url() ?>img/dinero/billete50soles.png"></button>
	  		<button onclick="incrementaValorSoles(100); contadorMas('b100soles')"><img src="<?php echo base_url() ?>img/dinero/billete100soles.png"></button>
	  		<button onclick="incrementaValorSoles(200); contadorMas('b200soles')"><img src="<?php echo base_url() ?>img/dinero/billete200soles.png"></button>
	  		<br><br>
	  		<CENTER><B>DÓLARES</B></CENTER>
	  		<button onclick="incrementaValorDolares(1.00); contadorMas('b1dolares')"><img src="<?php echo base_url() ?>img/dinero/billete1dolares.png"></button>
	  		<button onclick="incrementaValorDolares(2.00); contadorMas('b2dolares')"><img src="<?php echo base_url() ?>img/dinero/billete2dolares.png"></button>
	  		<button onclick="incrementaValorDolares(5.00); contadorMas('b5dolares')"><img src="<?php echo base_url() ?>img/dinero/billete5dolares.png"></button>
	  		<button onclick="incrementaValorDolares(10); contadorMas('b10dolares')"><img src="<?php echo base_url() ?>img/dinero/billete10dolares.png"></button>
	  		<button onclick="incrementaValorDolares(20); contadorMas('b20dolares')"><img src="<?php echo base_url() ?>img/dinero/billete20dolares.png"></button>
	  		<button onclick="incrementaValorDolares(50); contadorMas('b50dolares')"><img src="<?php echo base_url() ?>img/dinero/billete50dolares.png"></button>
	  		<button onclick="incrementaValorDolares(100); contadorMas('b100dolares')"><img src="<?php echo base_url() ?>img/dinero/billete100dolares.png"></button>


	  	</div>
	  	<div class="col-sm-6">
	  		<h4><b>Estado de caja: <?php echo "<span style='background-color:".$caja[0]->colorEtiqueta.";' class='label label-warning'>".$caja[0]->Descripcion."</span>";?></b></h4>
	  			<br>
	  			<div class="col-sm-9" id="bordeDiv">
	  				<b>Conteo </b><button onclick="reiniciar_conteo()" title="Reiniciar conteo"><i class="fa fa-refresh" aria-hidden="true"></i></button><br><br>
	  				<table width="100%">
	  					<tr>
	  						<td valign="top"><!--Soles-->
				  				<table>
				  					<tr><td colspan="4" align="center"><b>Soles</b></td></tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(0.10); contadorMenos('m01soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">0.1</td><td width="30px;">x</td><td width="30px;" id="m01soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(0.20); contadorMenos('m02soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">0.2</td>
				  						<td width="30px;">x</td><td width="30px;" id="m02soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(0.50); contadorMenos('m05soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">0.5</td><td width="30px;">x</td><td width="30px;" id="m05soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(1.00); contadorMenos('m1soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">1.00</td><td width="30px;">x</td><td width="30px;" id="m1soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(2.00); contadorMenos('m2soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">2.00</td><td width="30px;">x</td><td width="30px;" id="m2soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(5.00); contadorMenos('m5soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">5.00</td><td width="30px;">x</td><td width="30px;" id="m5soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(10); contadorMenos('b10soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">10.00</td><td width="30px;">x</td><td width="30px;" id="b10soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(20); contadorMenos('b20soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">20.00</td><td width="30px;">x</td><td width="30px;" id="b20soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(50); contadorMenos('b50soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">50.00</td><td width="30px;">x</td><td width="30px;" id="b50soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(100); contadorMenos('b100soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">100.00</td><td width="30px;">x</td><td width="30px;" id="b100soles">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorSoles(200); contadorMenos('b200soles')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">200.00</td><td width="30px;">x</td><td width="30px;" id="b200soles">0</td>
				  					</tr>
				  				</table>
				  			</td>
				  			<td valign="top"><!--Dólares-->
				  				<table>
				  					<tr><td colspan="4" align="center"><b>Dólares</b></td></tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorDolares(1.00); contadorMenos('b1dolares')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">1.00</td><td width="30px;">x</td><td width="30px;" id="b1dolares">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorDolares(2.00); contadorMenos('b2dolares')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">2.00</td><td width="30px;">x</td><td width="30px;" id="b2dolares">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorDolares(5.00); contadorMenos('b5dolares')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">5.00</td><td width="30px;">x</td><td width="30px;" id="b5dolares">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorDolares(10); contadorMenos('b10dolares')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">10.00</td><td width="30px;">x</td><td width="30px;" id="b10dolares">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorDolares(20); contadorMenos('b20dolares')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">20.00</td><td width="30px;">x</td><td width="30px;" id="b20dolares">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorDolares(50); contadorMenos('b50dolares')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">50.00</td><td width="30px;">x</td><td width="30px;" id="b50dolares">0</td>
				  					</tr>
				  					<tr>
				  						<td width="30px;"><button onclick="decrementaValorDolares(100); contadorMenos('b100dolares')"/><i class="fa fa-minus-circle" aria-hidden="true"></i></button><td width="50px;">100.00</td><td width="30px;">x</td><td width="30px;" id="b100dolares">0</td>
				  					</tr>
				  				</table>
				  			</td>
				  		</tr>
				  	</table>
	  			<div>
	  	</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<br>
		</div>
	</div>
	<div class="row">
		<?php 
		$totalCajaSoles = $caja[0]->montoSoles;
		$totalCajaDolares = $caja[0]->montoDolares;
		?>
    	<div class="col-sm-7">
			<table>
				<tr>
					<td><b>Total en caja:</b></td><td width="100px"></td><td><b>Total conteo:</b></td>
				</tr>
				<tr style="border: solid;  border-width: 1px 0;"><td colspan="4"></td></tr>
				<tr>
					<td><b>Soles</b></td><td><b><?php echo $totalCajaSoles;?></b></td><td><b>Soles</b></td><td id="displaySoles"><b>0.00</b></td>
				</tr>
				<tr>
					<td><b>Dólares</b></td><td><b><?php echo $totalCajaDolares;?></b></td><td><b>Dólares</b></td><td id="displayDolares"><b>0.00</b></td>
				</tr>
				<tr>
					<td></td><td></td><td><b>Diferencia S/</b></td><td id="diferenciaSoles"><b><?php echo "-".$totalCajaSoles;?></b></td>
				</tr>
				<tr>
					<td></td><td></td><td><b>Diferencia $</b></td><td id="diferenciaDolares"><b><?php echo "-".$totalCajaDolares;?></b></td>
				</tr>
			</table><br>
    		</div>
    	<div class="col-sm-2"><button class="btn btn-danger btn-xl" onclick="cerrar_caja(<?php echo $caja[0]->IdCaja;?>)"><i class="fa fa-window-close-o fa-4x" aria-hidden="true" title="CERRAR CAJA"></i><span class="my-text"><br>CERRAR CAJA</span></div>
	</div>
</div>
    <script type="text/javascript">
    var totalCierreCajaSoles = 1;
    var totalCierreCajaDolares = 1;
    	
    var totalConteoSoles = 0;
    var m01soles = 0;
    var m02soles = 0;
    var m05soles = 0;
    var m1soles = 0;
    var m2soles = 0;
    var m5soles = 0;
    var b10soles = 0;
    var b20soles = 0;
    var b50soles = 0;
    var b100soles = 0;
    var b200soles = 0;

    var totalConteoDolares = 0;
	var b1dolares = 0;
    var b2dolares = 0;
    var b5dolares = 0;
    var b10dolares = 0;
    var b20dolares = 0;
    var b50dolares = 0;
    var b100dolares = 0;
    


    function contadorMas(destino) {

    	if (destino == 'm01soles')
    	{
    		m01soles ++;
    		document.getElementById(destino).innerHTML = m01soles        
    	}
    	else if(destino == 'm02soles'){
    		m02soles ++;
    		document.getElementById(destino).innerHTML = m02soles        
    	}
    	else if(destino == 'm05soles'){
    		m05soles ++;
    		document.getElementById(destino).innerHTML = m05soles        
    	}
    	else if(destino == 'm1soles'){
    		m1soles ++;
    		document.getElementById(destino).innerHTML = m1soles        
    	}	
    	else if(destino == 'm2soles'){
    		m2soles ++;
    		document.getElementById(destino).innerHTML = m2soles        
    	}	
    	else if(destino == 'm5soles'){
    		m5soles ++;
    		document.getElementById(destino).innerHTML = m5soles        
    	}	    	
    	else if(destino == 'b10soles'){
    		b10soles ++;
    		document.getElementById(destino).innerHTML = b10soles        
    	}	
    	else if(destino == 'b20soles'){
    		b20soles ++;
    		document.getElementById(destino).innerHTML = b20soles        
    	}	
    	else if(destino == 'b50soles'){
    		b50soles ++;
    		document.getElementById(destino).innerHTML = b50soles        
    	}	
    	else if(destino == 'b100soles'){
    		b100soles ++;
    		document.getElementById(destino).innerHTML = b100soles        
    	}	
    	else if(destino == 'b200soles'){
    		b200soles ++;
    		document.getElementById(destino).innerHTML = b200soles        
    	}	

    	else if(destino == 'b1dolares'){
    		b1dolares ++;
    		document.getElementById(destino).innerHTML = b1dolares        
    	}   	
    	else if(destino == 'b2dolares'){
    		b2dolares ++;
    		document.getElementById(destino).innerHTML = b2dolares        
    	}   
    	else if(destino == 'b5dolares'){
    		b5dolares ++;
    		document.getElementById(destino).innerHTML = b5dolares        
    	}   
    	else if(destino == 'b10dolares'){
    		b10dolares ++;
    		document.getElementById(destino).innerHTML = b10dolares        
    	}   
    	else if(destino == 'b20dolares'){
    		b20dolares ++;
    		document.getElementById(destino).innerHTML = b20dolares        
    	}   
    	else if(destino == 'b50dolares'){
    		b50dolares ++;
    		document.getElementById(destino).innerHTML = b50dolares        
    	}   
    	else if(destino == 'b100dolares'){
    		b100dolares ++;
    		document.getElementById(destino).innerHTML = b100dolares        
    	}
    }

    function contadorMenos(destino) {
   		if (destino == 'm01soles')
    	{
    		if ((m01soles - 0.1) > 0) 
    		{
    			m01soles --;
	    		document.getElementById(destino).innerHTML = m01soles   
    		}
    	}
    	else if(destino == 'm02soles'){
    		if ((m02soles - 0.2) > 0) 
    		{    		
	    		m02soles --;
	    		document.getElementById(destino).innerHTML = m02soles 
    		}       
    	}
    	else if(destino == 'm05soles'){
    		if ((m05soles - 0.5) > 0) 
    		{    		
    		m05soles --;
    		document.getElementById(destino).innerHTML = m05soles 
    		}       
    	}
    	else if(destino == 'm1soles'){
    		if ((m1soles - 1) >= 0) 
    		{    		
    		m1soles --;
    		document.getElementById(destino).innerHTML = m1soles
    		}        
    	}	
    	else if(destino == 'm2soles'){
    		if ((m2soles - 1) >= 0) 
    		{    		
    		m2soles --;
    		document.getElementById(destino).innerHTML = m2soles
    		}        
    	}	
    	else if(destino == 'm5soles'){
    		if ((m5soles - 1) >= 0) 
    		{    		
    		m5soles --;
    		document.getElementById(destino).innerHTML = m5soles
    		}        
    	}	    	
    	else if(destino == 'b10soles'){
    		if ((b10soles - 1) >= 0) 
    		{    		
    		b10soles --;
    		document.getElementById(destino).innerHTML = b10soles 
    		}       
    	}	
    	else if(destino == 'b20soles'){
    		if ((b20soles - 1) >= 0) 
    		{    		
    		b20soles --;
    		document.getElementById(destino).innerHTML = b20soles 
    		}       
    	}	
    	else if(destino == 'b50soles'){
    		if ((b50soles - 1) >= 0) 
    		{    	    		
    		b50soles --;
    		document.getElementById(destino).innerHTML = b50soles 
    		}       
    	}	
    	else if(destino == 'b100soles'){
    		if ((b100soles - 1) >= 0) 
    		{    		
    		b100soles --;
    		document.getElementById(destino).innerHTML = b100soles   
    		}     
    	}	
    	else if(destino == 'b200soles'){
    		if ((b200soles - 1) >= 0) 
    		{    		
    		b200soles --;
    		document.getElementById(destino).innerHTML = b200soles     
    		}   
    	}	


    	else if(destino == 'b1dolares'){
    		if ((b1dolares - 1) >= 0) 
    		{    		
	    		b1dolares --;
	    		document.getElementById(destino).innerHTML = b1dolares 
    		}       
    	}	
    	else if(destino == 'b2dolares'){
    		if ((b2dolares - 1) >= 0) 
    		{    		
	    		b2dolares --;
	    		document.getElementById(destino).innerHTML = b2dolares 
    		}       
    	}	
    	else if(destino == 'b5dolares'){
    		if ((b5dolares - 1) >= 0) 
    		{    		
	    		b5dolares --;
	    		document.getElementById(destino).innerHTML = b5dolares
    		}        
    	}	    	
    	else if(destino == 'b10dolares'){
    		if ((b10dolares - 1) >= 0) 
    		{    		
	    		b10dolares --;
	    		document.getElementById(destino).innerHTML = b10dolares
    		}        
    	}	
    	else if(destino == 'b20dolares'){
    		if ((b20dolares - 1) >= 0) 
    		{    		
	    		b20dolares --;
	    		document.getElementById(destino).innerHTML = b20dolares  
    		}      
    	}	
    	else if(destino == 'b50dolares'){
    		if ((b50dolares - 1) >= 0) 
    		{    		
	    		b50dolares --;
	    		document.getElementById(destino).innerHTML = b50dolares
    		}        
    	}	
    	else if(destino == 'b100dolares'){
    		if ((b100dolares - 1) >= 0) 
    		{    		
	    		b100dolares --;
	    		document.getElementById(destino).innerHTML = b100dolares    
    		}    
    	}

    }

    function incrementaValorSoles(valor) {


        totalConteoSoles += valor;
        var totalCajaSoles = <?php echo json_encode($totalCajaSoles); ?>;

        document.getElementById("displaySoles").innerHTML = totalConteoSoles.toFixed(2) 
        document.getElementById("diferenciaSoles").innerHTML = (totalConteoSoles - totalCajaSoles).toFixed(2);

        totalCierreCajaSoles = (totalConteoSoles - totalCajaSoles).toFixed(2);
        if (totalCierreCajaSoles == 0)
        {
       	    	alert('Monto de soles en cero');
        }
    }

    function incrementaValorDolares(valor) {


        totalConteoDolares += valor;
     	var totalCajaDolares = <?php echo json_encode($totalCajaDolares); ?>;

        document.getElementById("displayDolares").innerHTML = totalConteoDolares.toFixed(2) 
       	document.getElementById("diferenciaDolares").innerHTML = (totalConteoDolares - totalCajaDolares).toFixed(2); 

       	totalCierreCajaDolares = (totalConteoDolares - totalCajaDolares).toFixed(2);;
       	if (totalCierreCajaDolares == 0)
        {
       	    	alert('Monto de dólares en cero');
        }      
    }

    function decrementaValorSoles(valor) {
    	if ((totalConteoSoles - valor) < 0) { alert('No es posible conteo menor de 0');}
    	else
    	{
	    	totalConteoSoles -= valor;
	    	var totalCajaSoles = <?php echo json_encode($totalCajaSoles); ?>;
	       
	        document.getElementById("displaySoles").innerHTML = totalConteoSoles.toFixed(2);
	        document.getElementById("diferenciaSoles").innerHTML = (totalConteoSoles-totalCajaSoles).toFixed(2) ;

    	}	
 
    }

    function decrementaValorDolares(valorDolares) {
    	if ((totalConteoDolares - valorDolares) < 0) { alert('No es posible conteo menor de 0');}
    	else
    	{
	    	totalConteoDolares -= valorDolares;
	    	var totalCajaDolares = <?php echo json_encode($totalCajaDolares); ?>;
	       
	        document.getElementById("displayDolares").innerHTML = totalConteoDolares.toFixed(2);
	        document.getElementById("diferenciaDolares").innerHTML = (totalConteoDolares - totalCajaDolares).toFixed(2);       	
    	}
   
    }
    </script>
</body>