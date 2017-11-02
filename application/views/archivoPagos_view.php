
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

            var table = $('#tabla_archivoPagos').DataTable( 
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
                text: 'Generar',
                action: function generar_archivoPagos()
                    {
                        save_method = 'generar_archivoPagos';
                        $('#formulario_archivoPagos')[0].reset(); 
                        $('.form-group').removeClass('has-error'); 
                        $('.help-block').empty();
                        $('#modal_archivoPagos').modal('show');
                        
                    }
            }                        
          ]
        } ); 

       $('#min, #max').change(function () {
                table.draw();
            });
    } );

    var save_method; 
    
    function preaprobar_archivoPagos(id)
        {
            if (confirm('¿Está seguro de preaprobar el archivo de pago?')) 
            {
                $.ajax({
                url : "<?php echo site_url('index.php/ArchivoPagos/preaprobar_archivoPagos')?>/"+id,
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

    function editar_archivoPagos(id)
    {

      save_method = 'update';
      $.ajax({
        url : "<?php echo site_url('index.php/OrdenCompra/editar_archivoPagos')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {            

			$('#modal_editarArchivoPagos').modal('show');
            $('.modal-title').text('Editar archivo de pago');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error de datos en Ajax');
        }
    });
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

 function save()
    {
        $('#btnSave').text('Guardando...');
        $('#btnSave').attr('disabled',true); 

        var url;
     
        if(save_method == 'generar_archivoPagos') {
            url = "<?php echo site_url('index.php/ArchivoPagos/generar_archivoPagos')?>";
        } else {
            url = "<?php echo site_url('index.php/OrdenCompra/ajax_update')?>";
        }
     

        $.ajax({
            url : url,
            type: "POST",
            data: $('#formulario_archivoPagos').serialize(),
            dataType: "JSON",
            success: function(data)
            {
     
                if(data.status) 
                {
                    $('#modal_archivoPagos').modal('hide');               
                    location.reload();
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
                alert('Existe un archivo en estado vigente');
                $('#btnSave').text('Grabar');
                $('#btnSave').attr('disabled',false);
     
            }
        });
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
 <table border="0" cellspacing="5" cellpadding="5">
        <tbody>
            <tr>
                <td style="text-align: left; font-size: 16px"><b>Archivo de pagos&nbsp;&nbsp;&nbsp;</b></td>
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
       <table id="tabla_archivoPagos" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                    <?php if ($archivoPagos == TRUE) {
                        ?>

                     <tr>                        
              <td style="vertical-align: middle;">
                <?php
                    if ($archivoPagos[0]->IdEstado == 3) 
                    {
                        ?>
                        <button id="editarArchivoPagos" class="btn btn-info btn-xs" onclick="editar_archivoPagos(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Modificar" disabled><i class="glyphicon glyphicon-pencil"></i></button>
                        <button id="editarArchivoPagos" class="btn btn-primary btn-xs" onclick="mostrar_archivoPagosMini(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Mostrar OC"><i class="fa fa-search"></i></button>
                        <?php
                    }
                    else
                       {
                        ?>
                        <button id="editarArchivoPagos" class="btn btn-info btn-xs" onclick="editar_archivoPagos(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Modificar"><i class="glyphicon glyphicon-pencil"></i></button>
                        <button id="editarArchivoPagos" class="btn btn-success btn-xs" onclick="preaprobar_archivoPagos(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Preaprobar"><i class="fa fa-check-square-o"></i></button>
                      <?php
                    }
                ?>
                  
                  <button class="btn btn-danger btn-xs" onclick="eliminar_archivoPagos(<?php echo $archivoPagos[0]->IdArchivoPagos;?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
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
    </section> 
</body>

<div class="modal fade" id="modal_archivoPagos" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-6 pull-left">
                <h4 class="modal-title">Registrar archivo de pago</h4>                
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_archivoPagos" class="form-horizontal">
          <input type="hidden" value="1" name="input_IdArchivoPagos"/>
          <div class="form-body">
            <div class="col-md-6 form-group pull-left">
				<label class="control-label">Fecha de creación</label>
                <input name="input_FechaCreacion" value="<?php echo date('d-m-Y');?>" class="form-control" type="text" readonly>
                <span class="help-block"></span>

                <label class="control-label">Estado&nbsp;&nbsp;</label><span style='background-color: #00A012;' class='label label-warning'>REGISTRADO</span>
                <input type="hidden" value="1" name="input_Estado"/>
                <input type="hidden" value="1" name="input_IdMoneda"/>
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
</div>

<div class="modal fade" id="modal_editarArchivoPagos" role="dialog">
  	<div class="modal-dialog modal-lg" style="width: 900px; height: 500px;">
	    <div class="modal-content">
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
	            <div class="col-md-6 pull-left">
	                <h3 class="modal-title">Editar archivo de pagos</h3>                
	            </div>
	        </div>      
	      	<div class="modal-body" style="height: 500px;">                
	        	<?php include('ordenCompra_view.php');?>
	        </div>
		    <div class="modal-footer">
		        <button type="button" id="btnSave" onclick="saveOC()" class="btn btn-primary">Grabar</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
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
<script src="<?php echo base_url('assests/bootstrap-datepicker/js/datepicker.js')?>"></script>
