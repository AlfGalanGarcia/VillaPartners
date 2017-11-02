
<script type="text/javascript">
        
        //Filtro fechas
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

            var table = $('#tabla_valeProvisional').DataTable( 
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
                text: 'Registrar',
                action: function agregar_vale_provisional()
                    {
                        save_method = 'agregar_vale_provisional';
                        $('#formulario_valeProvisional')[0].reset();
                        $('.form-group').removeClass('has-error'); 
                        $('.help-block').empty();
                        $('#modal_valeProvisional').modal('show');
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
                <td style="text-align: left; font-size: 16px"><b>Vale Provisional&nbsp;&nbsp;&nbsp;</b></td>
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
       <table id="tabla_valeProvisional" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">Opciones</th>
                    <th>Código</th>  
                    <th>Motivo</th>   
                    <th>Monto solicitado</th>
                    <th>Monto utilizado</th>
                    <th>Colaborador</th>
                    <th>Fecha Creación</th>         
                    <th>Estado</th>                          
                     
                </tr>
            </thead>
            <tbody>
                <?php foreach($valeProvisional as $items){?>
                     <tr>                        
              <td style="vertical-align: middle;">
                  <button class="btn btn-info btn-xs" onclick="editar_valeProvisional(<?php echo $items->IdVale;?>)" title="Editar"><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger btn-xs" onclick="eliminar_valeProvisional(<?php echo $items->IdVale;?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
              </td>
                <td><?php echo $items->IdVale;?></td>
                <td><?php echo $items->Motivo;?></td>
                <td><?php echo $items->MontoSolicitado;?></td>
                <td><?php echo $items->MontoUtilizado;?></td>                                                      
                <td><?php echo $items->nombres;?></td>   
                <td><?php echo date('d-m-Y', strtotime($items->FechaCreacion));?></td>                   
                <td><?php echo "<span style='background-color:".$items->colorEtiqueta.";' class='label label-warning'>".$items->Descripcion."</span>";?></td>
                                
                      </tr>
                     <?php }?>
                </tbody>
        </table>
    </section> 
 
 



<script type="text/javascript">
   
    var save_method;
 
    function editar_valeProvisional(id)
    {
      save_method = 'update';
      $('#formulario_valeProvisional')[0].reset();
      $.ajax({
        url : "<?php echo site_url('index.php/ValeProvisional/editar_valeProvisional/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {            
            $('[name="input_IdVale"]').val(data.IdVale);
            $('[name="input_motivo"]').val(data.Motivo);
            $('[name="input_montoSolicitado"]').val(data.MontoSolicitado);
            $('[name="input_empleado"]').val(data.IdEmpleado);
            $('[name="input_IdLocal"]').val(data.IdLocal);
            $('[name="input_FechaCreacion"]').val(data.FechaCreacion);
            $('[name="input_IdEstado"]').val(data.IdEstado);
            
            $('#modal_valeProvisional').modal('show');
            $('.modal-title').text('Editar vale provisional'); 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error de datos en Ajax');
        }
    });
    }

    function save()
    {
        $('#btnSave').text('Guardando...'); 
        $('#btnSave').attr('disabled',true); 
        var url;
     
        if(save_method == 'agregar_vale_provisional') {
            url = "<?php echo site_url('index.php/ValeProvisional/agregar_vale_provisional')?>";
        } else {
            url = "<?php echo site_url('index.php/ValeProvisional/ajax_update')?>";
        }
     
        $.ajax({
            url : url,
            type: "POST",
            data: $('#formulario_valeProvisional').serialize(),
            dataType: "JSON",
            success: function(data)
            {    
                if(data.status)
                {
                    $('#modal_valeProvisional').modal('hide');               
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
                $('#btnSave').text('Aceptar');
                $('#btnSave').attr('disabled',false);
            }
        });
    }

    function eliminar_valeProvisional(id)
    {
      if(confirm('¿Estás seguro? Se va a eliminar el vale provisional'))
      {
          $.ajax({
            url : "<?php echo site_url('index.php/ValeProvisional/eliminar_valeProvisional')?>/"+id,
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

<div class="modal fade" id="modal_valeProvisional" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-6 pull-left">
                <h3 class="modal-title">Generar archivo pagos</h3>                
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_valeProvisional" class="form-horizontal">
          <input type="hidden" value="" name="input_IdVale"/>
          <input type="hidden" value="<?php echo date('d-m-Y');?>" name="input_FechaCreacion"/>
          <div class="form-body">
            <div class="col-md-6 form-group pull-left">

                <label class="control-label">Motivo</label>
                <input name="input_motivo" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Monto solicitado</label>
                <input name="input_montoSolicitado" class="form-control" type="text">
                <span class="help-block"></span>

                <label class="control-label">Colaborador</label>
                <select name="input_empleado" class="form-control">
                    <?php foreach ($empleado as $item) {
                        echo "<option value='".$item->IdEmpleado."'>".$item->nombres."</option>";
                    }
                    ?>
                </select>
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
  <script type="text/javascript">
   $.fn.datepicker.dates['en'] = {
    days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    daysShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    today: "Hoy",
    clear: "Limpiar",
    format: "dd-mm-yyyy",
    titleFormat: "MM yyyy",
    weekStart: 1
    };
    $(function() {
      $('input.datepicker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,        
        defaultViewDate: "today",
        keyboardNavigation: true 
      });     
    });
</script>
</body>
</html>