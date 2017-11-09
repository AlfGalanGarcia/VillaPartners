
<script type="text/javascript">
        
        $(document).ready(function () { 
        
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                   
                    var d = data[2].split("-");
                    var startDate = new Date(d[1]+ "-" +  d[0] +"-" + d[2]);

                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

      
            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true , dateFormat:"dd-mm-yyyy"});
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, dateFormat:"dd-mm-yyyy" });

            var table = $('#tabla_planesPago').DataTable( 
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
                text: 'Registrar plan de pago',
                action: function agregar_planPago()
                    {
                        save_method = 'agregar_planPago';
                        $('#formulario_planPlago')[0].reset(); 
                        $('.form-group').removeClass('has-error'); 
                        $('.help-block').empty(); 
                        $('#modal_planPago').modal('show'); 
                    }
            }                         
          ],
          fixedColumns:   {
            leftColumns: 2
          }
        } ); 

       $('#min, #max').change(function () {
                table.draw();
            });
    } );

</script>

<body>
 <table border="0" cellspacing="5" cellpadding="5">
        <tbody>
            <tr>
                <td style="text-align: left; font-size: 16px"><b>Plan de pagos&nbsp;&nbsp;&nbsp;</b></td>
                <td>Fecha inicio:</td>
                <td><input name="min" id="min" type="text"></td>
                <td>&nbsp;</td>
                <td>Fecha fin:</td>
                <td><input name="max" id="max" type="text"></td>
            </tr>
        </tbody>
    </table> 
    <br>
    <section>
       <table id="tabla_planesPago" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">Opciones</th>
                    <th>Código</th>  
                    <th>Fecha de pago</th>   
                    <th>OC</th>
                    <th>Factura</th>
                    <th>Monto</th>
                    <th>IGV</th>         
                    <th>Total</th>                                               
                </tr>
            </thead>
            <tbody>
                <?php foreach($planesPago as $items){?>
                     <tr>                        
              <td style="vertical-align: middle;">
                  <button class="btn btn-info btn-xs" onclick="editar_planPago(<?php echo $items->IdPlanPago;?>)" title="Editar"><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger btn-xs" onclick="eliminar_planPago(<?php echo $items->IdPlanPago;?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
              </td>
                <td><?php echo $items->IdPlanPago;?></td>
                <td><?php echo date('d-m-Y', strtotime($items->FechaPago));?></td>
                <td><?php echo $items->NroOC;?></td>
                <td><?php echo $items->NroFactura;?></td>                
                <td><?php echo $items->MontoPago;?></td>                                                      
                <td><?php echo $items->MontoIGV;?></td>                      
                <td><?php echo $items->MontoTotal;?></td>
                                
                      </tr>
                     <?php }?>
                </tbody>
        </table>
    </section> 
 
 



<script type="text/javascript">
   
    var save_method;
    
    function editar_planPago(id)
    {
      save_method = 'update';
      $('#formulario_planPlago')[0].reset(); 
      $.ajax({
        url : "<?php echo site_url('index.php/PlanPago/editar_planPago')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {            
            $('[name="input_IdPlanPago"]').val(data.IdPlanPago);
            $('[name="input_NroOC"]').val(data.NroOC);
            $('[name="input_FechaEmisionOC"]').val(data.FechaEmisionOC);
            $('[name="input_RucOC"]').val(data.RucOC);
            $('[name="input_ProveedorOC"]').val(data.ProveedorOC);
            $('[name="input_ConceptoOC"]').val(data.ConceptoOC);
            $('[name="input_IdMonedaOC"]').val(data.IdMonedaOC);
            $('[name="input_MontoOC"]').val(data.MontoOC);
            $('[name="input_NroFactura"]').val(data.NroFactura);            
            $('[name="input_FechaPago"]').datepicker('update', data.FechaPago);
            $('[name="input_MontoPago"]').val(data.MontoPago);
            $('[name="input_MontoIGV"]').val(data.MontoIGV);
            $('[name="input_MontoTotal"]').val(data.MontoTotal);

            $('#modal_planPago').modal('show');
            $('.modal-title').text('Editar plan de pago');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error de datos en Ajax');
        }
    });
    }

    function buscar_oc(oc)
    {
      $.ajax({
        url : "<?php echo site_url('index.php/PlanPago/buscar_oc')?>/" + oc,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {            
            if (!data)
                {
                    alert("Orden de compra no encontrada");
                }
            else
                {                    
                    $('[name="input_NroOC"]').val(data.NroOC);
                    $('[name="input_FechaEmisionOC"]').val(data.FechaEmisionOC);
                    $('[name="input_RucOC"]').val(data.RucOC);
                    $('[name="input_ProveedorOC"]').val(data.ProveedorOC);
                    $('[name="input_ConceptoOC"]').val(data.ConceptoOC);
                    $('[name="input_IdMonedaOC"]').val(data.IdMonedaOC);
                    $('[name="input_MontoOC"]').val(data.MontoOC);
                    $('[name="input_NroFactura"]').val(data.NroFactura);            
                    $('[name="input_FechaPago"]').datepicker('update', data.FechaPago);
                    $('[name="input_MontoPago"]').val(data.MontoPago);
                    $('[name="input_MontoIGV"]').val(data.MontoIGV);
                    $('[name="input_MontoTotal"]').val(data.MontoTotal);
                   
                    $('#modal_form').modal('show'); 
                }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('El campo OC no puede estar vacío');
        }
    });
    }

    function save()
    {
        $('#btnSave').text('Guardando...'); 
        $('#btnSave').attr('disabled',true); 
        var url;
     
        if(save_method == 'agregar_planPago') {
            url = "<?php echo site_url('index.php/PlanPago/agregar_planPago')?>";
        } else {
            url = "<?php echo site_url('index.php/PlanPago/ajax_update')?>";
        }
     
        $.ajax({
            url : url,
            type: "POST",
            data: $('#formulario_planPlago').serialize(),
            dataType: "JSON",
            success: function(data)
            {
     
                if(data.status)
                {
                    $('#modal_planPago').modal('hide');               
                    window.location.reload(true);
                    $('.form-group').removeClass('has-error'); 
                    $('.help-block').empty(); 
                }
                else
                {
                    alert(data);
                }
                $('#btnSave').text('Aceptar');
                $('#btnSave').attr('disabled',false); 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error agregando/actualizando datos');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled',false);
            }
        });
    }

    function eliminar_planPago(id)
    {
      if(confirm('¿Estás seguro? Se va a eliminar el plan de pago'))
      {
          $.ajax({
            url : "<?php echo site_url('index.php/PlanPago/eliminar_planPago')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error borrando los datos');
            }
        });
      }
    }
 
  </script>

<div class="modal fade" id="modal_planPago" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-6 pull-left">
                <h3 class="modal-title">Nuevo plan de pago</h3>                
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_planPlago" class="form-horizontal">
          <input type="hidden" value="" name="input_IdPlanPago"/>
          <div class="form-body">
            <div class="col-md-6 form-group pull-left">
                                 
                <label class="control-label">OC</label>&nbsp;<input type="button" value="Buscar" onclick="buscar_oc(document.getElementsByName('input_NroOC')[0].value)"  class="btn btn-default btn-xs">
                <input name="input_NroOC" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Fecha emisión</label>
                <input name="input_FechaEmisionOC" class="form-control" type="text" readonly>
                <span class="help-block"></span>

                <label class="control-label">Fecha de pago</label>
                <input name="input_FechaPago" data-date-format="dd-mm-yyyy" class="form-control datepicker" type="text">
                <span class="help-block"></span>

                <label class="control-label">RUC</label>
                <input name="input_RucOC" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Proveedor</label>
                <input name="input_ProveedorOC" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Concepto</label>
                <input name="input_ConceptoOC" class="form-control" type="text">
                <span class="help-block"></span>
             </div>                        
                     
            <div class="col-md-6 form-group pull-right">             
                <label class="control-label">Moneda</label>
                <input name="input_IdMonedaOC" class="form-control" type="text">
                <span class="help-block"></span>
               
                <label class="control-label">Monto OC</label>
                <input name="input_MontoOC" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Nº Factura</label>
                <input name="input_NroFactura" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Monto pago</label>
                <input name="input_MontoPago" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Monto IGV</label>
                <input name="input_MontoIGV" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Monto total</label>
                <input name="input_MontoTotal" class="form-control" type="text">
                <span class="help-block"></span>
            </div> 
            
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Grabar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
          </div>
        </div>
      </div>
</div>

<script src="<?php echo base_url('assests/bootstrap-datepicker/js/datepicker.js')?>"></script>
</body>
</html>