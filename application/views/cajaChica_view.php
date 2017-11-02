<body>
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
                   <!-- <?php if ($archivoPagos == TRUE) {
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
-->
                </tbody>
        </table>
    </section> 
</body>

<div class="modal fade" id="modal_crearDocumento" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            <div class="col-md-6 pull-left">
                <h4 class="modal-title">Crear documento</h4>                
            </div>
        </div>      
      <div class="modal-body form">
        <form action="#" id="formulario_crearDocumento" class="form-horizontal">
          <input type="hidden" value="" name="input_IdArchivoPagos"/>
          <div class="form-body">
            <div class="col-md-6 form-group pull-left">
                <label class="control-label">Número de documento</label>
                <input name="input_motivo" class="form-control" type="text">
                
                <label class="control-label">Proveedor</label>
                <input name="input_motivo" class="form-control" type="text">
                
                <label class="control-label">Fecha de emisión</label>
                <input name="input_FechaCreacion" value="<?php echo date('d-m-Y');?>" class="form-control" type="text" readonly>

                <label class="control-label">Descripción</label>
                <input name="input_motivo" class="form-control" type="text">
                
                <label class="control-label">Tipo de documento</label>
                <select name="input_empleado" class="form-control">
                    <option value='' selected=""></option>
                    <option value='Boleta'>Boleta</option>
                    <option value='Factura'>Factura</option>
                    <option value='Ticket'>Ticket</option>
                </select>
            </div>                        
                     
            <div class="col-md-6 form-group pull-right">    
                <label class="control-label">Tipo de moneda</label>
                <select name="input_empleado" class="form-control">
                    <!--<?php foreach ($empleado as $item) {
                        echo "<option value='".$item->IdEmpleado."'>".$item->nombres."</option>";
                    }
                    ?>-->
                </select>

                <label class="control-label">Monto</label>
                <input name="input_motivo" class="form-control" type="text">

                <label class="control-label">Importe total</label>
                <input name="input_motivo" class="form-control" type="text">
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
<script src="<?php echo base_url('assests/bootstrap-datepicker/js/datepicker.js')?>"></script>