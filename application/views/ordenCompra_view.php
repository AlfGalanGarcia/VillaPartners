<script type="text/javascript">
        $(document).ready(function () {
        $.fn.dataTable.ext.errMode = 'none'; 
        var tablaOC = $('#tabla_oc').DataTable( 
        { 
          //scrollY: "350px",
          //scrollX: true,
          bAutoWidth:false,
          //dom: 'lBfrtip', 
          dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'rt>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        } ); 
    } );

   function buscar_oc(oc)
    {
    var tablaOC = $('#tabla_oc').DataTable( 
        { 
          bAutoWidth:false,
          dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'rt>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        } ); 
     $.ajax({
        url : "<?php echo site_url('index.php/OrdenCompra/buscar_oc')?>/"+oc,
        type: "GET",
        dataType: "JSON",
        success: function(data)
            {         
              var montoIGV = data.MontoOC*0.18;
                if (!data)
                    {
                        alert("Orden de compra no encontrada");
                    }
                else
                    {
                        alert('Orden de compra '+data.NroOC+' encontrada, se añadirá a la lista');
                        tablaOC.row.add( [
                                        '<button class="btn btn-danger btn-xs" onclick="eliminar_OC('+data.NroOC+')" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>',
                                        data.NroOC,
                                        data.NombreProveedor,
                                        data.FechaPagoOC,
                                        data.MontoOC+" "+data.AbreviaturaMoneda,
                                        montoIGV,
                                        parseFloat(data.MontoOC)+parseFloat(montoIGV)+" "+data.AbreviaturaMoneda,
                                     ] ).draw();      

                        $('[name="input_NroOC"]').val(data.NroOC);
                        $('[name="input_FechaEmisionOC"]').val(data.FechaEmisionOC);
                        $('[name="input_FechaPagoOC"]').val(data.FechaPagoOC);
                        $('[name="input_RucOC"]').val(data.RucOC);
                        $('[name="input_ProveedorOC"]').val(data.NombreProveedor);
                        $('[name="input_ConceptoOC"]').val(data.ConceptoOC);
                        $('[name="input_IdMonedaOC"]').val(data.IdMonedaOC);                        
                        $('[name="input_MontoOC"]').val(data.MontoOC);
                        $('[name="input_MontoIGVOC"]').val(data.MontoIGVOC);
                        $('[name="input_MontoTotalOC"]').val(data.MontoTotalOC);
                        $('[name="input_IdEstado"]').val(data.IdEstado);
                        $('[name="input_IdArchivoPagos"]').val(data.IdArchivoPagos);            
                    }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('El campo OC no puede estar vacío');
            }
        });
    }

    function cerrar()
    {
        $('#modal_oc').modal('hide');   
    }

    function saveOC()
    {

        $.ajax({
            url : "<?php echo site_url('index.php/OrdenCompra/agregar_OC')?>",
            type: "POST",
            data: $('#formulario_oc').serialize(),
            dataType: "JSON",
            success: function(data)
            {          
                location.reload();                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error agregando/actualizando datos');
                $('#btnGrabar').text('Grabar');
                $('#btnGrabar').attr('disabled',false);
     
            }
        });
    }



    function eliminar_OC(id)
    {
      if(confirm('¿Estás seguro? Se va a eliminar la orden de compra'))
      {
          $.ajax({
            url : "<?php echo site_url('index.php/OrdenCompra/eliminar_OC')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {             
               window.location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error borrando los datos');
            }
        });
      }
    }
</script>

<body>
<?php
 $IGV = 0.18;
 ?>
    <br>
<input type="button" value="Buscar" onclick="buscar_oc(document.getElementsByName('busquedaOC')[0].value)"  class="btn btn-default btn-xs">&nbsp;Orden de compra
                <input id="busqueda" name="busquedaOC" class="form-control" type="text" style="width: 100px;">
       <table id="tabla_oc" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
            <thead>
                <tr>
                    <th class="no-sort">Opciones</th>
                    <th>Nº OC</th>                     
                    <th>Proveedor</th> 
                    <th>Fecha de pago</th>                           
                    <th>Monto</th>                          
                    <th>IGV</th>                          
                    <th>Monto total</th>                          
                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($ordenCompra as $items){?>
                     <tr>                        
              <td style="vertical-align: middle;">
                  <button class="btn btn-danger btn-xs" onclick="eliminar_OC(<?php echo $items->NroOC;?>)" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
              </td>
                <td><?php echo $items->NroOC;?></td>
                <td name="proveedor"><?php echo $items->NombreProveedor;?></td>
                <td><?php echo date('d-m-Y', strtotime($items->FechaPagoOC));?></td>
                <td><?php echo $items->MontoOC." ".$items->AbreviaturaMoneda?></td>
                <td><?php echo $items->MontoOC*$IGV; ?></td>
                <td><?php echo ($items->MontoOC)+($items->MontoOC*$IGV)." ".$items->AbreviaturaMoneda;?></td>
                 

                        
              </tr>
             <?php }?>
                </tbody>
        </table>

<div class="modal fade" id="modal_oc" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_oc" class="form-horizontal">
          <input type="hidden" value="" name="input_NroOC"/>
          <input type="hidden" value="" name="input_FechaEmisionOC"/>
          <input type="hidden" value="" name="input_FechaPagoOC"/>
          <input type="hidden" value="" name="input_RucOC"/>
          <input type="hidden" value="" name="input_ProveedorOC"/>
          <input type="hidden" value="" name="input_ConceptoOC"/>
          <input type="hidden" value="" name="input_IdMonedaOC"/>
          <input type="hidden" value="" name="input_MontoOC"/>
          <input type="hidden" value="" name="input_MontoIGVOC"/>
          <input type="hidden" value="" name="input_MontoTotalOC"/>
          <input type="hidden" value="" name="input_IdEstado"/>
          <input type="hidden" value="" name="input_IdArchivoPagos"/>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnGrabar" onclick="saveOC()" class="btn btn-primary">Grabar</button>
            <button type="button" id="btnSalir" onclick="cerrar()" class="btn btn-danger">Salir</button>
          </div>
        </div>
        </div>
      </div>
</body>