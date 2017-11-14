
<script type="text/javascript">
        
    $(document).ready(function () { 

        var table = $('#tabla_pedido').DataTable( 
        { 
          "order": [[ 5, "desc" ]],  
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


    function mostrar_detalle_pedido(id)
    {       
        window.location.href = "<?php echo site_url('CobrarCuenta/venta')?>/"+id;       
    }

    function anular(id)
    {
      if(confirm('¿Estás seguro? Se va a anular el pedido'))
      {

          $.ajax({
            url : "<?php echo site_url('index.php/CobrarCuenta/anular')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {             
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error modificando la OC');
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
                        <button class="btn btn-primary btn-xs" onclick="mostrar_detalle_pedido(<?php echo $items->IdPedido;?>)" title="Mostrar detalle de pedido"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <button class="btn btn-danger btn-xs" onclick="anular(<?php echo $items->IdPedido;?>)" title="Anular"><i class="glyphicon glyphicon-trash"></i></button>
                    <?php
                    }
                    elseif ($items->IdEstadoPedido == 10)
                    {
                        if ($items->IdEmpleadoSesion == $this->session->userdata('id'))  
                        {                                        
                        ?>
                            <button class="btn btn-primary btn-xs" onclick="mostrar_detalle_pedido(<?php echo $items->IdPedido;?>)" title="Mostrar detalle de pedido"><i class="fa fa-search" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-xs" onclick="anular(<?php echo $items->IdPedido;?>)" title="Anular"><i class="glyphicon glyphicon-trash"></i></button>
                        <?php
                        }
                        else
                        {
                        ?>
                            <button class="btn btn-primary btn-xs" onclick="mostrar_detalle_pedido(<?php echo $items->IdPedido;?>)" title="Mostrar detalle de pedido"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <?php
                        }
                    }
                    elseif ($items->IdEstadoPedido == 12 || $items->IdEstadoPedido == 11)
                    {
                    ?>
                            <button class="btn btn-primary btn-xs" onclick="mostrar_detalle_pedido(<?php echo $items->IdPedido;?>)" title="Mostrar detalle de pedido"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <?php
                    }
                      
                    ?>
                </td>
                <td><?php echo $items->IdPedido;?></td>                
                <td><?php echo $items->IdMesa;?></td>
                <td><?php echo $items->MontoPedido;?></td>                
                <td><?php echo $items->nombres;?></td>                                                      
                <td><?php echo "<span style='background-color:".$items->colorEtiqueta.";' class='label label-warning'>".$items->Descripcion."</span>";?></td>                                    
                                
                      </tr>
                     <?php }?>
            </tbody>
        </table>
    </section>
</body>