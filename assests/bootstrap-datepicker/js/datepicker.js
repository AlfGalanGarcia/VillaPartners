
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
