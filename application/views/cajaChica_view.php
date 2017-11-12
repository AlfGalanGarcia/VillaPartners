
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
            $('[name="input_FechaEmision"]').val(data.FechaEmision);
            $('[name="input_DescripcionCC"]').val(data.DescripcionCC);            
            $('[name="input_IdMoneda"]').val(data.IdMoneda);
            $('[name="input_IdIgv"]').val(data.IdIgv);
            $('[name="input_Monto"]').val(data.Monto);
            
            $('#modal_editarDocumento').modal('show');
            $('.modal-title').text('Editar documento'); 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error de datos en Ajax');
        }
    });
    }

 function save()
    {
        if(save_method == 'registrar_documento') {
                var dataArray = $("#formulario_documento").serializeArray(),
                    dataObj = {};
            }
            else
            {
                var dataArray = $("#formulario_editarDocumento").serializeArray(),
                    dataObj = {};
            }
                $(dataArray).each(function(i, field){
                  dataObj[field.name] = field.value;
                });

            var Monto = dataObj['input_Monto'];
            var MontoCC = dataObj['input_MontoCC'];
        
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
                var formularioGrabar = $('#formulario_documento');
                var modalGrabar = $('#modal_documento');
            }
            else
            {
                url = "<?php echo site_url('index.php/CajaChica/ajax_update')?>";
                var formularioGrabar = $('#formulario_editarDocumento');
                var modalGrabar = $('#modal_editarDocumento');
            }
         

            $.ajax({
                url : url,
                type: "POST",
                data: formularioGrabar.serialize(),
                dataType: "JSON",
                success: function(data)
                {
         
                    if(data.status) 
                    {
                        modalGrabar.modal('hide');               
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
                    alert('Documento ya registrado.');
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
    <?php $montoCCSession = $this->session->userdata('MontoCC');?>
    <?php $montoCCTotal = sprintf('%0.3f', ($montoCCSession)-($sumaMontosCC[0]->sumaMontosCC)) ;?>
    <h3 style="border-bottom: 1px solid rgb(200, 200, 200)"></i>Saldo caja chica: <b><?php echo
    $montoCCTotal;?></b></h3>
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
                <td><?php echo "S/ ".sprintf('%0.2f',$items->Monto)?></td>                                                                  
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
                <input name="input_FechaEmision" data-date-format="dd-mm-yyyy" class="form-control datepicker" type="text" value="<?php echo date('d-m-Y');?>">

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
                <input name="input_Monto" id="inputEditar_Monto" class="form-control" type="text">
                <input type="hidden" name="input_MontoCC" id="inputEditar_MontoCC" value="<?php echo htmlspecialchars($montoCCTotal); ?>" />
                </form>
            </div>                        
                     
            <div class="col-md-12 form-group pull-right"> 
                <center>
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Grabar</button>
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
                <input name="input_IdDetalleCC" class="form-control" type="text" readonly>
                
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
                <input name="input_Monto" id="input_Monto" class="form-control" type="text">
                <input type="hidden" name="input_MontoCC" id="input_MontoCC" value="<?php echo htmlspecialchars($montoCCTotal); ?>" />
                </form>
            </div>                        
                     
            <div class="col-md-12 form-group pull-right"> 
                <center>
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Grabar</button>
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