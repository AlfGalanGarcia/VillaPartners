<script type="text/javascript">    
    $(document).ready(function () { 

    var table = $('#tabla_archivoPagos').DataTable( 
        { 
            //scrollY: "350px",
            scrollX: true,
            bAutoWidth:false,
            //dom: 'Blfrtip', 
            dom: "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'rt>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons:[]
        } ); 
    } );

    //var save_method; 

    function generar_pago()
        {            
            //$('#formulario_archivoPagos')[0].reset();             
            $('#modal_generarPago').modal('show');
        }

    function ver_tabla()
        {                        
            $('#modal_tablaBanco').modal('show');
        }
    
    function aprobar_pago(id)
        {
            if (confirm('¿Está seguro de aprobar el pago?')) 
            {
                $.ajax({
                url : "<?php echo site_url('index.php/AprobarPagos/aprobar_pago')?>/"+id,
                type: "POST",                
                dataType: "JSON",
                success: function(data)
                {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error modificando los datos');
                }
                });
            }    
        }

    function generar_tabla_banco()
    {
        if (confirm('¿Está seguro de generar la tabla?')) 
            {
                $.ajax({
                url : "<?php echo site_url('index.php/AprobarPagos/generar_tabla_banco')?>/",
                type: "POST", 
                data: $('#fomulario_tablaBanco').serialize(),               
                dataType: "JSON",
                success: function(data)
                {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error modificando los datos');
                }
                });
            }
    }

    function mostrar_archivoPagosMini(id)
    {
      $.ajax({
        url : "<?php echo site_url('index.php/OrdenCompra/editar_archivoPagos')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {            

            $('#modal_archivoPagosMini').modal('show');
            $('.modal-title').text('Órdenes de compra');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error de datos en Ajax');
        }
        });
        }

    function rechazar_pago_modal(id)
    {
        $('#modal_rechazar_pago').modal('show');
    }

    function rechazar_pago()
    {
        if(confirm('¿Estás seguro? Se va a rechazar la aprobación del pago'))
        {
            
            $.ajax({
            url : "<?php echo site_url('index.php/AprobarPagos/rechazar_pago')?>",
            type: "POST",
            data: $('#formulario_rechazar_pago').serialize(),
            dataType: "JSON",
            success: function(data)
            {               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
            }
        });
        }
    }
        

    function eliminar_archivoPagos(id)
    {
      if(confirm('¿Estás seguro? Se va a eliminar el archivo de pago'))
      {

          $.ajax({
            url : "<?php echo site_url('index.php/ArchivoPagos/eliminar_archivoPagos')?>/"+id,
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
    <CENTER><h3>APROBACIÓN DE PAGO A PROVEEDORES</h3></CENTER><br>
    <section style="border-style: inset; margin-left: 20px; margin-right: 20px; background-color: #EAEAEA;">   
    <div style="margin-left: 20px; margin-right: 20px; margin-top: 20px; margin-bottom: 20px;">

                <table id="tabla_archivoPagos" class="table table-striped table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="no-sort">Opciones</th>
                            <th>Código</th>  
                            <th>Fecha de creación</th>   
                            <th>Monto total órdenes de compra</th>
                            <th>Moneda</th>                          
                            <th>Estado</th>                          
                        </tr>
                    </thead>
                    <tbody>
                            <?php if ($archivoPagos == TRUE && $archivoPagos[0]->IdEstado != 1) {
                                ?>
                        <tr>                        
                        <td style="vertical-align: middle;">
                        <?php
                            if ($archivoPagos[0]->IdEstado == 3) 
                            {
                                ?>
                                <button id="mostrarArchivoPagosMini" class="btn btn-primary btn-xs" onclick="mostrar_archivoPagosMini(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Ver"><i class="fa fa-search"></i></button>
                                <button id="aprobarPago" class="btn btn-success btn-xs" onclick="aprobar_pago(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Aprobar"><i class="fa fa-check-square-o"></i></button> 
                                <button class="btn btn-warning btn-xs" onclick="rechazar_pago_modal()" title="Rechazar"><i class="fa fa-times" aria-hidden="true"></i></button>
                                <?php
                            }
                            elseif ($archivoPagos[0]->IdEstado == 6 || $archivoPagos[0]->IdEstado == 7) 
                               {
                                ?>
                            <button id="mostrarArchivoPagosMini" class="btn btn-primary btn-xs" onclick="mostrar_archivoPagosMini(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Ver OCs"><i class="fa fa-search"></i></button>
                            <button id="generar_pago" class="btn btn-success btn-xs" onclick="generar_pago()" title="Generar pago"><i class="fa fa-usd" aria-hidden="true"></i></button>                            
                                        <?php
                                }
                            elseif ($archivoPagos[0]->IdEstado == 8) 
                               {
                                ?>
                                <button id="mostrarArchivoPagosMini" class="btn btn-primary btn-xs" onclick="mostrar_archivoPagosMini(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Ver OCs"><i class="fa fa-search"></i></button>
                                <button id="generar_pago" class="btn btn-info btn-xs" onclick="ver_tabla()" title="Ver tabla para exportar"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                                <button class="btn btn-danger btn-xs" onclick="eliminar_archivoPagos(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
                                <?php
                                }    
                                ?>                  
                        </td>
                        <td><?php echo $archivoPagos[0]->IdArchivoPagos;?></td>
                        <td><?php echo date('d-m-Y', strtotime($archivoPagos[0]->FechaCreacion));?></td>
                        <td><?php echo sprintf('%0.3f', $sumaMontoTotalOC[0]->sumaMontos);?></td>
                        <td><?php echo $archivoPagos[0]->AbreviaturaMoneda;?></td>
                        <td><?php echo "<span style='background-color:".$archivoPagos[0]->colorEtiqueta.";' class='label label-warning'>".$archivoPagos[0]->Descripcion."</span>";?></td>
                                                
                             <?php   
                            };?>        
                        </tr>
                    </tbody>
                </table>
    </div>
    </section> 
</body>

<div class="modal fade" id="modal_generarPago" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-6 pull-left">
                <h4 class="modal-title">Registrar aprobación</h4>                
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="fomulario_tablaBanco" class="form-horizontal">
          <input type="hidden" value="1" name="input_IdArchivoPagos"/>
          <div class="form-body row">
            <div class="col-md-6 form-group" style="margin-left: 20px;">
                <table>
                    <tr>
                        <td nowrap="">
				            <label class="control-label">Fecha de pago</label>
                        </td>
                        <td>
                            <input name="input_FechaPago" class="datepicker" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Banco</label>
                        </td>
                        <td>
                            <select name="input_NroCtaCteOrigen" class="form-control">
                            <option selected="">Elegir banco</option>
                                <?php foreach ($banco as $item) {
                                    echo "<option value='".$item->NroCtaCteVC."'>".$item->NombreBanco."</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($datosAprobar as $item) {                    
                    echo "
                        <input type='hidden' name='input_IdBanco".$i."' value=".$item->IdBanco." />
                        <input type='hidden' name='input_IdProveedor".$i."' value=".$item->IdProveedor." /> 
                        <input type='hidden' name='input_MontoOC".$i."' value=".$item->MontoOC." />                        
                        <input type='hidden' name='input_NroOC".$i."' value=".$item->NroOC." />                                               
                        <input type='hidden' name='input_NroCtaCteDestino".$i."' value=".$item->NroCtaCte." />                        
                    ";
                    $i++;
                    }
                    ?>
               </table>     
            </div>                       
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="generar_tabla_banco()" class="btn btn-primary">Generar tabla</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
          </div>
        </div>
        </div>
      </div>
 </div>

 <div class="modal fade" id="modal_rechazar_pago" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-6 pull-left">
                <h4 class="modal-title">Rechazar pago</h4>                
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_rechazar_pago" class="form-horizontal">
          <input type="hidden" value="1" name="input_IdArchivoPagos"/>
          <div class="form-body row">
            <div class="col-md-6 form-group" style="margin-left: 20px;">
                <table>
                    <tr>
                        <td nowrap="">
                            <label class="control-label">Fecha de rechazo</label>
                        </td>
                        <td>
                            <input name="input_FechaRechazo" class="datepicker" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Motivo rechazo</label>
                        </td>
                        <td>
                            <textarea name="input_MotivoRechazo" class="form-control"></textarea>                            
                        </td>
                    </tr>
               </table>     
            </div>                       
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="rechazar_pago()" class="btn btn-primary">Rechazar pago</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
          </div>
        </div>
        </div>
      </div>
 </div>

<div class="modal fade" id="modal_archivoPagosMini" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
                <div class="col-md-6 pull-left">
                    <h3 class="modal-title">Ordenes de compra</h3>                
                </div>
            </div>      
            <div class="modal-body" style="height: 500px;">                
                <?php include('ordenCompraMini_view.php');?>
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () { 
        $('#tabla_archivoBanco').DataTable( 
        { 
            //scrollY: "350px",
            //scrollX: true,
            bAutoWidth:false,
            //dom: 'Blfrtip', 
            dom: "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'rt>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons:[

                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: ':visible:not(:eq(0))',
                            header: 'none' 
                        }
                    }
                    ]
        } ); 
    });
</script>
<div class="modal fade" id="modal_tablaBanco" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <table id="tabla_archivoBanco" class="table table-striped table-bordered" cellspacing="0">
                    <thead>
                        <tr>                            
                            <th>Banco</th>  
                            <th>Archivo de pago</th>   
                            <th>Fecha de pago</th>
                            <th>Monto</th>                          
                            <th>Nº cuenta origen</th>                          
                            <th>Nº cuenta destino</th>
                            <th>Proveedor</th>                                                    
                            <th>Nº Orden de compra</th>                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($archivoBanco as $item) {
                            ?>
                        <tr>                        
                        <td><?php echo $item->IdBanco;?></td>
                        <td><?php echo $item->IdArchivoPagos;?></td>
                        <td><?php echo date('d-m-Y', strtotime($item->FechaPago));?></td>                        
                        <td><?php echo $item->MontoPago;?></td>
                        <td><?php echo $item->NroCtaCteOrigen;?></td>
                        <td><?php echo $item->NroCtaCteDestino;?></td>
                        <td><?php echo $item->NombreProveedor;?></td>
                        <td><?php echo $item->NroOC;?></td>
                        <?php
                            }
                        
                        ?>
                        </tr>
                    </tbody>
                </table>
            </div>      
            <div class="modal-footer">                
                <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assests/bootstrap-datepicker/js/datepicker.js')?>"></script>
