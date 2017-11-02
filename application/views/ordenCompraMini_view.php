<body>
    <br>
   <table id="tabla_oc" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
        <thead>
            <tr>
                <th>Nº OC</th>                     
                <th>Proveedor</th> 
                <th>Fecha de pago</th>                           
                <th>Monto</th>                          
                <th>IGV</th>                          
                <th>Monto total</th>                          
                
            </tr>
        </thead>
        <tbody>
            <?php foreach($ordenCompra as $items){?>
            <tr>                        
                <td><?php echo $items->NroOC;?></td>
                <td name="proveedor"><?php echo $items->NombreProveedor;?></td>
                <td><?php echo date('d-m-Y', strtotime($items->FechaPagoOC));?></td>
                <td><?php echo $items->MontoOC." ".$items->AbreviaturaMoneda;?></td>
                <td><?php echo $items->MontoOC*$IGV; ?></td>
                <td><?php echo ($items->MontoOC)+($items->MontoOC*$IGV)." ".$items->AbreviaturaMoneda;?></td>
            </tr>
         <?php }?>
        </tbody>
    </table>
</body>