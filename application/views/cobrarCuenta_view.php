
<script type="text/javascript">
        
    $(document).ready(function () { 

        var table = $('#tabla_pedido').DataTable( 
        { 
          //scrollY: "350px",
          scrollX: true,
          bAutoWidth:false,
          //dom: 'Blfrtip', 
          dom: "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
"<'row'<'col-sm-12'rt>>" +
"<'row'<'col-sm-5'i><'col-sm-7'p>>",
          buttons: 
          [
          ]
        } );     
    } );


    function precuenta(id)
    {       
        if (confirm('¿Está seguro? Se va a realizar la precuenta del pedido')) 
        {
            $.ajax({
            url : "<?php echo site_url('index.php/CobrarCuenta/precuenta')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                window.location.href = "<?php echo site_url('CobrarCuenta/venta')?>/"+id;
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
    <h2><center>Cobro de cuenta</center></h2>
    <section>
        <table id="tabla_pedido" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">Opciones</th>
                    <th>Número pedido</th>
                    <th>Número mesa</th>                      
                    <th>Monto</th>                       
                    <th>Mozo</th>     
                    <th>Estado</th>     
                </tr>
            </thead>
            <tbody>
                <?php foreach($pedidoMesa as $items){?>
                <tr>                        
                <td style="vertical-align: middle;">
                    <?php
                    if ($items->IdEstadoPedido == 2)
                    {
                    ?>
                        <button class="btn btn-success btn-xs" onclick="precuenta(<?php echo $items->IdPedido;?>)" title="Precuenta"><i class="fa fa-usd" aria-hidden="true"></i></button>
                        <button class="btn btn-danger btn-xs" onclick="eliminar_planPago(<?php echo $items->IdPedido;?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
                    <?php
                    }
                    elseif ($items->IdEstadoPedido == 10)
                    {
                        if ($items->IdEmpleadoSesion == $this->session->userdata('id'))  
                        {                                        
                        ?>
                        <button class="btn btn-success btn-xs" onclick="precuenta(<?php echo $items->IdPedido;?>)" title="Precuenta"><i class="fa fa-usd" aria-hidden="true"></i></button>
                        <button class="btn btn-danger btn-xs" onclick="eliminar_planPago(<?php echo $items->IdPedido;?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
                        <?php
                        }
                        else
                        {
                            echo "<font color='red'><b>Atendido por el usuario: ".$items->aliasSesion."</font></b>"; 
                        }
                    }
                    ?>
                </td>
                <td><?php echo $items->IdPedido;?></td>                
                <td><?php echo $items->IdMesa;?></td>
                <td><?php echo $items->MontoPedido;?></td>                
                <td><?php echo $items->nombres?></td>                                                      
                <td><?php echo "<span style='background-color:".$items->colorEtiqueta.";' class='label label-warning'>".$items->Descripcion."</span>";?></td>                                    
                                
                      </tr>
                     <?php }?>
            </tbody>
        </table>
    </section>
</body>