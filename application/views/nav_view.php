 <nav class="navbar navbar-inverse bg-primary">
      <a class="navbar-brand" href="<?php echo site_url('LoginVilla/index/');?>" ><img src="<?php echo base_url() ?>img/logoVilla.jpg" style="max-width:35px; margin-top: -7px;"></a>      
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
                      <?php
                      if ($this->session->userdata('rol') == 'JEFE CONTADOR') {
                      ?>
                      <li><button class="btn btn-default" onclick="window.location='<?php echo site_url('aprobarPagos/index/');?>'" style="width: 100%; text-align: left;"><i class="fa fa-check-square" aria-hidden="true">&nbsp;&nbsp;Aprobar pago a proveedores</i></button></li>      
                      <?php
                      }
                      ?>
                      <li><button class="btn btn-default" onclick="window.location='<?php echo site_url('CajaChica/index/');?>'" style="width: 100%; text-align: left;"><i class="fa fa-usd" aria-hidden="true">&nbsp;&nbsp;Documentos de caja chica</i></button></li>
                      <li><button class="btn btn-default" onclick="window.location='<?php echo site_url('AbrirCaja/index/');?>'" style="width: 100%; text-align: left;"><i class="fa fa-university" aria-hidden="true">&nbsp;&nbsp;Abrir caja</i></button></li>
                    </ul>
                  </div>
                </li>

      </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php
            if ($this->session->userdata('rol') == 'CAJERO' && $this->session->userdata('MotivoRechazo') != NULL) {
            ?>
            <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Observados">
              <i class="fa fa-flag-o"></i>
              <span class="badge badge-danger" style="background:red; position:relative; top: -15px; left: -30px;"><?php echo $this->session->userdata('NroRechazos');?></span>
            </a>            
            <ul class="dropdown-menu" style="width: 200px;">              
              <li>                
                <font color="orange"><i class="fa fa-warning text-yellow"></font><font color="black">Archivo <?php echo $this->session->userdata('IdArchivoPagos');?>: rechazado</i>
              </li> 
              <li>
                <i class="fa fa-calendar">&nbsp;Fecha: <?php echo date('d/m', strtotime($this->session->userdata('FechaRechazo')));?></i>
              </li> 
              <li>
                <i class="fa fa-question-circle">&nbsp;Motivo: <?php echo $this->session->userdata('MotivoRechazo');?></font></i>                  
              </li>              
            </ul>
          </li>
          <?php
           }
           ?>
      <li><i class="fa fa-user-circle"></i>&nbsp;<?php echo $this->session->userdata('empleado')." - ".$this->session->userdata('rol')?>&nbsp; <button class="btn btn-danger btn-xs" onclick="window.location='<?php echo site_url('loginVilla/logout/');?>'" title="Logout"><i class="fa fa-sign-out" aria-hidden="true"></i></button>&nbsp;</li>      
    </ul>
  </div>
    </nav>