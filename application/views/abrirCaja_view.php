<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
    function save()
    {
        $('#btnSave').text('Guardando...'); 
        $('#btnSave').attr('disabled',true); 
        var url;
    
        url = "<?php echo site_url('index.php/AbrirCaja/abrir_caja')?>";
            
        $.ajax({
            url : url,
            type: "POST",
            data: $('#formulario_abrirCaja').serialize(),
            dataType: "JSON",
            success: function(data)
            {    
                if(data.status)
                {                          
                    window.location.href = '<?php echo site_url('index.php/AbrirCaja/cuadrar_caja')?>';
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
                alert('Error');
                $('#btnSave').text('Aceptar');
                $('#btnSave').attr('disabled',false);
            }
        });
    }
</script>

<div class="container">
    <div class="row">
        <div class="col-md-offset-5 col-md-3">
            <table align="center" style="border-collapse: separate; border-spacing: 10px;">
                <form action="#" id="formulario_abrirCaja" class="form-horizontal"> 
                    <tr>
                        <td colspan="3" style="text-align: center;"><b><h2>ABRIR CAJA</h2></b></td>
                    </tr>
                    <tr>
                        <td><label><i class="fa fa-user fa-2x"></i></label></td>
                        <td><input name="user" id="user" class="form-control" type="text" readonly placeholder="<?php echo $this->session->userdata('empleado');?>"></td>          
                        <td><input name="userId" id="userId" class="form-control" value="<?php echo $this->session->userdata('id');?>" type="hidden"></td>  
                    </tr>
                    <tr>
                        <td><label><img src="<?php echo base_url() ?>img/iconoSol.png" width="50%" height="50%"></i></label></td>
                        <td><input name="montoSoles" id="montoSoles" class="form-control" type="text" placeholder="Monto anterior Soles"></td>
                    </tr>
                        <tr>
                        <td><label><i class="fa fa-usd fa-2x" aria-hidden="true"></i></label></td>
                        <td><input name="montoDolares" id="montoDolares" class="form-control" type="text" placeholder="Monto anterior Soles"></td>
                    </tr>
                    
                    <tr>
                        <td align="center" colspan="2"><button type="submit"  id="btnSave" onclick="save()" class="btn btn-success btn-sm" title="ABRIR CAJA"><i class="fa fa-key fa-2x"></i></button></td>
                    </tr>
                </form>
            </table>
        
        </div>
    </div>
</div>