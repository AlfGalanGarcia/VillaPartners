 <nav class="navbar navbar-inverse bg-primary">
      <a class="navbar-brand" href="#" ><img src="<?php echo base_url() ?>img/logoVilla.jpg" style="max-width:35px; margin-top: -7px;"></a>      
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="nav navbar-nav navbar-left">
                <li><a href="#" >Local: <?php echo $local[0]->Nombre;?>&nbsp;&nbsp;</a></li>
                <li>
                  <div class="btn-group">
                    <button data-toggle="dropdown" class="btn navbar-btn btn-danger dropdown-toggle">Caja&nbsp;&nbsp;<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <li><button class="btn btn-default" onclick="window.location='<?php echo site_url('PlanPago/index/');?>'" style="width: 100%; text-align: left;"><i class="fa fa-list">&nbsp;&nbsp;Elaborar plan de pago</i></button></li>
                      <li><button class="btn btn-default" onclick="window.location='<?php echo site_url('ValeProvisional/index/');?>'" style="width: 100%; text-align: left;"><i class="fa fa-money">&nbsp;&nbsp;Vale provisional</i></button></li>
                      <li><button class="btn btn-default" onclick="window.location='<?php echo site_url('archivoPagos/index/');?>'" style="width: 100%; text-align: left;"><i class="fa fa-file">&nbsp;&nbsp;Archivo de pagos</i></button></li>
                    </ul>
                  </div>
                </li>
      </ul>
          <ul class="nav navbar-nav navbar-right">
      <li><i class="fa fa-user-circle"></i>&nbsp;<?php echo $empleadoLogin[0]->nombres;?>&nbsp; <button class="btn btn-danger btn-xs" onclick="window.location='<?php echo site_url('loginVilla/index/');?>'" title="Logout"><i class="fa fa-sign-out" aria-hidden="true"></i></button>&nbsp;</li>      
    </ul>
  </div>
    </nav>