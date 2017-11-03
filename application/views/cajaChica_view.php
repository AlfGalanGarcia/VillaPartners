
<script type="text/javascript">
       
    $(document).ready(function () { 
        var table = $('#tabla_cajaChica').DataTable( 
        { 
          //scrollY: "350px",
          //scrollX: true,
          bAutoWidth:false,
          //dom: 'Blfrtip', 
          dom: "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
"<'row'<'col-sm-12'rt>>" +
"<'row'<'col-sm-5'i><'col-sm-7'p>>",
          buttons: 
          [
            {
                extend: 'collection',
                text: 'Exportar',
                buttons: 
                [
                    {extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible:not(:eq(0))' 
                                }
                            }, 
                    {extend: 'csvHtml5',
                        exportOptions: {
                            columns: ':visible:not(:eq(0))' 
                        }
                    }
                ]
            }, 
            //'colvis',
            {
                extend: 'collection',
                text: 'Registrar',
                action: function registrar_documento()
                    {
                        save_method = 'registrar_documento';
                        $('#formulario_documento')[0].reset(); 
                        $('.form-group').removeClass('has-error'); 
                        $('.help-block').empty();
                        $('#modal_documento').modal('show');
                        
                    }
            }                        
          ]
        } ); 
    } );

    var save_method; 
    

      function editar_documento(id)
    {
      save_method = 'update';
      $('#formulario_editarDocumento')[0].reset();
      $.ajax({
        url : "<?php echo site_url('index.php/CajaChica/editar_documento/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {    
                  
            $('[name="input_IdDetalleCC"]').val(data.IdDetalleCC);   
            $('[name="input_IdCajaChica"]').val(data.IdCajaChica); 
            $('[name="input_IdTipoDoc"]').val(data.IdTipoDoc);                      
            $('[name="input_IdProveedor"]').val(data.IdProveedor);
            $('[name="input_FechaEmision"]').datepicker('update', data.FechaEmision);
            $('[name="input_DescripcionCC"]').val(data.DescripcionCC);            
            $('[name="input_IdMoneda"]').val(data.IdMoneda);
            $('[name="input_IdIgv"]').val(data.IdIgv);
            $('[name="input_Monto"]').val(data.Monto);
            $('[name="input_MontoCC"]').val(data.MontoCC);
            
            $('#modal_editarDocumento').modal('show');
            $('.modal-title').text('Editar documento'); 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error de datos en Ajax');
        }
    });
    }


function actualizar_documento()
    {
        /*if ((Monto*1.18) > MontoCC) 
        {
            alert('No se puede crear el documento, el saldo en la caja chica es: '+MontoCC+", monto del documento: "+(Monto*1.18));
        }
        else
        {*/
            $('#btnSave').text('Guardando...');
            $('#btnSave').attr('disabled',true); 

            var url;
            if(save_method == 'update') {
                url = "<?php echo site_url('index.php/CajaChica/ajax_update')?>";
            }


            $.ajax({
                url : url,
                type: "POST",
                data: $('#formulario_editarDocumento').serialize(),
                dataType: "JSON",
                success: function(data)
                {
         
                    if(data.status) 
                    {
                        $('#modal_editarDocumento').modal('hide');               
                        location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                    $('#btnSave').text('Grabar'); 
                    $('#btnSave').attr('disabled',false);
         
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error en los datos.');
                    $('#btnSave').text('Grabar');
                    $('#btnSave').attr('disabled',false);
         
                }
            });
        //}
        
    }

 function save(Monto, MontoCC)
    {
        if ((Monto*1.18) > MontoCC) 
        {
            alert('No se puede crear el documento, el saldo en la caja chica es: '+MontoCC+".");
        }
        else
        {
            $('#btnSave').text('Guardando...');
            $('#btnSave').attr('disabled',true); 

            var url;
         
            if(save_method == 'registrar_documento') {
                url = "<?php echo site_url('index.php/CajaChica/registrar_documento')?>";
            }
         

            $.ajax({
                url : url,
                type: "POST",
                data: $('#formulario_documento').serialize(),
                dataType: "JSON",
                success: function(data)
                {
         
                    if(data.status) 
                    {
                        $('#modal_documento').modal('hide');               
                        location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                    $('#btnSave').text('Grabar'); 
                    $('#btnSave').attr('disabled',false);
         
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error en los datos.');
                    $('#btnSave').text('Grabar');
                    $('#btnSave').attr('disabled',false);
         
                }
            });
        }
        
    }


    function eliminar_documento(id, monto, montoCC)
    {
      if(confirm('¿Estás seguro? Se va a eliminar el documento'))
      {

          $.ajax({
            url : "<?php echo site_url('index.php/CajaChica/eliminar_documento')?>/",
            type: "POST",
            data: {id, monto, montoCC},
            dataType: "JSON",
            success: function(data)
            {               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error eliminando el documento');
            }
        });
      }
    }
</script>
<body>
    <h3 style="border-bottom: 1px solid rgb(200, 200, 200)"></i>Saldo caja chica: <b><?php echo $this->session->userdata('MontoCC');?></b></h3>
    <section>        
       <table id="tabla_cajaChica" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">Opciones</th>
                    <th>Número documento</th>  
                    <th>Tipo documento</th>  
                    <th>Proveedor</th>   
                    <th>Fecha de emisión</th>
                    <th>Descripción</th>                                                   
                    <th>Monto total</th>                          
                </tr>
            </thead>
            <tbody>
                <?php foreach($detalleCajaChica as $items){?>
                     <tr>                        
              <td style="vertical-align: middle;">
                  <button class="btn btn-info btn-xs" onclick="editar_documento(<?php echo $items->IdDetalleCC;?>)" title="Editar"><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger btn-xs" onclick="eliminar_documento(<?php echo $items->IdDetalleCC;?>,<?php echo $items->Monto;?>,<?php $this->session->userdata('MontoCC');?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
              </td>
                <td><?php echo $items->IdDetalleCC;?></td>
                <td><?php echo $items->DescripcionTipoDoc;?></td>
                <td><?php echo $items->NombreProveedor;?></td>
                <td><?php echo date('d-m-Y', strtotime($items->FechaEmision));?></td>    
                <td><?php echo $items->DescripcionCC;?></td>
                <td><?php echo $items->Monto;?></td>                                                                  
                      </tr> 
                     <?php }?>
            </tbody>
        </table>
    </section> 
</body>

<div class="modal fade" id="modal_documento" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-12 pull-left">
                <h4 class="modal-title">Registrar documento <br><b></h4>           
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_documento" class="form-horizontal">          
          <div class="form-body">
            <div class="col-md-6 form-group pull-left">
                <input type="hidden" value="1" name="input_IdCajaChica"/>
                <label class="control-label">Número de documento </label>
                <input name="input_IdDetalleCC" class="form-control" type="text">
                
                <label class="control-label">Proveedor</label>
                <select name="input_IdProveedor" class="form-control">
                    <?php foreach ($proveedor as $item) {
                        echo "<option value='".$item->IdProveedor."'>".$item->NombreProveedor."</option>";
                    }
                    ?>
                </select>
                
                <label class="control-label">Fecha de emisión</label>
                <input name="input_FechaEmision" data-date-format="dd-mm-yyyy" class="form-control datepicker" type="text">

                <label class="control-label">Descripción</label>
                <input name="input_DescripcionCC" class="form-control" type="text">
            </div>                        
                     
            <div class="col-md-6 form-group pull-right">                   
                <label class="control-label">Tipo de documento</label>
                <select name="input_IdTipoDoc" class="form-control">
                    <?php foreach ($tipoDoc as $item) {
                        echo "<option value='".$item->IdTipoDoc."'>".$item->DescripcionTipoDoc."</option>";
                    }
                    ?>
                </select>
 
                <label class="control-label">Tipo de moneda</label>
                <select name="input_IdMoneda" class="form-control">
                    <?php foreach ($moneda as $item) {
                        echo "<option value='".$item->IdMoneda."'>".$item->DescripcionMoneda."</option>";
                    }
                    ?>
                </select>

                <label class="control-label">IGV</label>
                <input type="hidden" value="1" name="input_IdIgv"/>
                <?PHP echo "<input type='text' value='".$igv[0]->valor."' class='form-control' name='' readonly/>";?>

                <label class="control-label">Monto total</label>
                <input name="input_Monto" class="form-control" type="text">
                <input type="hidden" name="input_MontoCC" value="<?php echo htmlspecialchars($montoCajaChica[0]->MontoCC); ?>" />
                </form>
            </div>                        
                     
            <div class="col-md-12 form-group pull-right"> 
                <center>
                    <button type="button" id="btnSave" onclick="save(document.getElementsByName('input_Monto')[0].value, document.getElementsByName('input_MontoCC')[0].value)" class="btn btn-primary">Grabar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
                </center>                 
            </div>
            <div class="modal-footer">            
            </div>
        </div>
        </div>
      </div>
</div>
</div>

<div class="modal fade" id="modal_editarDocumento" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-12 pull-left">
                <h4 class="modal-title">Registrar documento <br><b></h4>           
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_editarDocumento" class="form-horizontal">          
          <div class="form-body">
            <div class="col-md-6 form-group pull-left">
                <input type="hidden" value="1" name="input_IdCajaChica"/>                
                <label class="control-label">Número de documento </label>
                <input name="input_IdDetalleCC" class="form-control" type="text">
                
                <label class="control-label">Proveedor</label>
                <select name="input_IdProveedor" class="form-control">
                    <?php foreach ($proveedor as $item) {
                        echo "<option value='".$item->IdProveedor."'>".$item->NombreProveedor."</option>";
                    }
                    ?>
                </select>
                
                <label class="control-label">Fecha de emisión</label>
                <input name="input_FechaEmision" data-date-format="dd-mm-yyyy" class="form-control datepicker" type="text">

                <label class="control-label">Descripción</label>
                <input name="input_DescripcionCC" class="form-control" type="text">
            </div>                        
                     
            <div class="col-md-6 form-group pull-right">                   
                <label class="control-label">Tipo de documento</label>
                <select name="input_IdTipoDoc" class="form-control">
                    <?php foreach ($tipoDoc as $item) {
                        echo "<option value='".$item->IdTipoDoc."'>".$item->DescripcionTipoDoc."</option>";
                    }
                    ?>
                </select>
 
                <label class="control-label">Tipo de moneda</label>
                <select name="input_IdMoneda" class="form-control">
                    <?php foreach ($moneda as $item) {
                        echo "<option value='".$item->IdMoneda."'>".$item->DescripcionMoneda."</option>";
                    }
                    ?>
                </select>

                <label class="control-label">IGV</label>
                <input type="hidden" value="1" name="input_IdIgv"/>
                <?PHP echo "<input type='text' value='".$igv[0]->valor."' class='form-control' name='' readonly/>";?>

                <label class="control-label">Monto total</label>
                <input name="input_Monto" class="form-control" type="text">
                <input type="hidden" name="input_MontoCC" value="<?php echo htmlspecialchars($montoCajaChica[0]->MontoCC); ?>" />
                </form>
            </div>                        
                     
            <div class="col-md-12 form-group pull-right"> 
                <center>
                    <button type="button" id="btnSave" onclick="actualizar_documento()" class="btn btn-primary">Grabar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
                </center>                 
            </div>
            <div class="modal-footer">            
            </div>
        </div>
        </div>
      </div>
</div>
<script src="<?php echo base_url('assests/bootstrap-datepicker/js/datepicker.js')?>"></script>