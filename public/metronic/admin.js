toastr.options = {
  "positionClass": "toast-top-center",
}
$(function () {
  $('[data-toggle="popover"]').popover()
})
$("input#rut_prov").rut({validateOn: 'change'}).on('rutInvalido', function(){ 
   $('#send_prov').attr("disabled","disabled"); 
   $("input#rut_prov").attr('data-content','Rut Incorrecto').css("background","#FD8C92").popover('show');    
});
$("input#rut_prov").rut({validateOn: 'blur'}).on('rutValido', function(){
    $('#send_prov').removeAttr("disabled");
   $("input#rut_prov").popover('destroy').css("background","#fff");   
});                
$("#nuevoproveedor").submit(function(e){
    $("#servicio").removeAttr("disabled");
    $("#categoria").removeAttr("disabled");
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        dataType : 'json',
        success : function(response) {
            if (response.status=='ok'){
           toastr.success(response.descripcion);    
            $("#modal_proveedor").modal('hide');
            $("#id_proveedor").append($('<option></option>').val(response.prov[0].id).html(response.prov[0].nombre));   
            $('#id_proveedor').val(response.prov[0].id);
            $('#id_proveedor').attr('disabled','disabled');                     
            }else{
            toastr.info(response.descripcion);                              
            }                                        
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {            
            toastr.error("Ups, ha ocurrido un error inesperado, favor contacta con soporte");      
        }
    });
    e.preventDefault(); //STOP default action        
});
$("#btnnuevoseguro").click(function(){  
    $.ajax({
        url:'<?php echo $this->basePath()."/admin/infocom/formseguro"?>',
        success: function(response){
            $("#divnuevoseguro").html(response);
            $("#divnuevoseguro").fadeIn(800);       
            $("#btnnuevoseguro").fadeOut(800);     
        }        
    });   
})
$("#seguro").click(function(){
	$.ajax( {  
        url : '<?php echo $this->basePath()."/admin/infocom/seguro"?>',
		type : 'post',
        beforeSend : function() {
            var table = document.getElementById("stabla1");            
           for(var i = table.rows.length - 1; i > 0; i--)
            {
            table.deleteRow(i);
            }
            },        
		success : function(response) { 		  
		  $("#segtable").append(response.tabla);
          /*for (i=0; i<response.seg.length; i++) {
          if(response.seg[i].estado=='0'){var estadoseg="<i class='fa fa-check fa-2x'></i>";}else{var estadoseg="<i class='fa fa-close fa-2x'></i>";}
          $("#segtable").append("<tr><td>"+response.seg[i].poliza+"</td><td>"+response.seg[i].riesgo+"</td><td>$ "+response.seg[i].valor_prima+"</td><td>0/"+response.seg[i].cuotas+"</td><td>"+response.seg[i].vigenciafin+"</td><td>"+estadoseg+"</td><td> <a href='javascript:void(0)' onclick='verDatosSeg("+response.seg[i].id+","+response.seg[i].estado+");' data-toggle='modal' data-target='#myModal'><i class='fa fa-eye fa-2x'></i></a></td></tr>");
          }      */  
		}
	});   
}
);
$("#camara").click(function(){
	$.ajax( {  
        url : '<?php echo $this->basePath()."/admin/infocom/camaras"?>',    
		beforeSend : function() {
          $("#camaras").html("");  
            }, 
        success : function(response) { 		  
		  $("#camaras").append(response);
		},
        error: function(jqXHR, textStatus, errorThrown) {
            toastr.error("Ups, ha ocurrido un error inesperado, favor contacta con soporte");
        }
	});   
}
);
function nuevoProveedor(){
    $.ajax({
        url: '<?php echo $this->basePath()."/admin/infocom/nuevoasegurador"?>',
        success: function(response){
            $("#mostrarDatos").html(response)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr.error("Ups, ha ocurrido un error inesperado, favor contacta con soporte");
        }
        
    })
    
}
function loadImg(){
    $("#sendseg").attr('disabled','disabled');
    $("#filepoliza").add('class','btn-warning');                                        
    $("#sendseg").val('Subiendo imagen...');
    $("#icnAdjuntarPoliza").attr("class","fa fa-spinner fa-spin");    
}  
function unloadImg(){
    $("#sendseg").removeAttr('disabled');
    $("#filepoliza").add('class','btn-success');                                        
    $("#sendseg").val('Adjuntar Boleta');
    $("#icnAdjuntarPoliza").attr("class","fa fa-file"); 
    $("#sendseg").val('Guardar Seguro');      
}   
function formatMonto(){  
    var format = $("#valor_prima").val().replace(/\./g,'').replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    $("#valor_prima").val(format);
    $("#valor_prima").val(format);
}
function selecciona(){
    if(document.getElementById('filepoliza').files[0].size<2500000){  	                        
            var file_data = $('#filepoliza').prop('files')[0];
            var parametros = new FormData();                  
                           parametros.append('fileData', file_data);
                           $.ajax( {
                                    contentType:false,
                                    processData:false,	
                                    cache:false,
                                    data : parametros,
                                    url : '<?php echo $this->basePath()."/admin/infocom/segurofile"?>',
                                    type : 'post',
                                    beforeSend : function() {
                                        loadImg();
                                    },
                                    success : function(response) {
                                        if(response.status == "nok"){
                                            toastr.warning(response.desc);
                                            unloadImg()
                                        }else{
                                            toastr.success(response.desc);       
                                            $("#sendseg").removeAttr('disabled');                                                                                                                            
                                            $("#sendseg").val('Guardar Seguro');                                        
                                            document.getElementById("mostrarnombre").innerHTML="Archivo subido OK: [<strong>"+document.getElementById('filepoliza').files[0].name+"</strong>]";
                                            $("#url_poliza").val(response.name);   
                                            $("#icnAdjuntarPoliza").attr("class","fa fa-check"); 
                                        }
                                                                                                              
                                    },      
                            });
        
    }else{
     document.getElementById("mostrarnombre").innerHTML="<font color='red'>Error Ha superado el limite permitido (2Mb): [<strong>"+document.getElementById('filepoliza').files[0].name+"</strong>] NOK</font>";
    }
}
function loadImg2(){
    $("#sendplan").attr('disabled','disabled');
    $("#fileplan").add('class','btn-warning');                                        
    $("#sendplan").val('Subiendo imagen...');
    $("#icnAdjuntarPlan").attr("class","fa fa-spinner fa-spin");    
}  
function unloadImg2(){
    $("#sendplan").removeAttr('disabled');
    $("#fileplan").add('class','btn-success');                                        
    $("#sendplan").val('Adjuntar Boleta');
    $("#icnAdjuntarPlan").attr("class","fa fa-file"); 
    $("#sendplan").val('Guardar Plan');      
}  
function selecciona2(){
    if(document.getElementById('fileplan').files[0].size<4500000){  	                        
            var file_data = $('#fileplan').prop('files')[0];
            var parametros = new FormData();                  
                           parametros.append('fileData', file_data);
                           $.ajax( {
                                    contentType:false,
                                    processData:false,	
                                    cache:false,
                                    data : parametros,
                                    url : '<?php echo $this->basePath()."/admin/infocom/emergenciafile"?>',
                                    type : 'post',
                                    beforeSend : function() {
                                        loadImg2();
                                    },
                                    success : function(response) {
                                        if(response.status == "nok"){
                                            toastr.warning(response.desc);
                                            unloadImg2()
                                        }else{
                                            toastr.success(response.desc);       
                                            $("#sendplan").removeAttr('disabled');                                                                                                                            
                                            $("#sendplan").val('Guardar Plan');  
                                            $("#url_plan").val(response.name);                                      
                                            document.getElementById("mostrarnombre2").innerHTML="Archivo subido OK: [<strong>"+document.getElementById('fileplan').files[0].name+"</strong>]";                                             
                                            $("#icnAdjuntarPlan").attr("class","fa fa-check"); 
                                        }
                                                                                                              
                                    },      
                            });
        
    }else{
     document.getElementById("mostrarnombre2").innerHTML="<font color='red'>Error Ha superado el limite permitido (2Mb): [<strong>"+document.getElementById('filepoliza').files[0].name+"</strong>] NOK</font>";
    }
}
$("#sendplan").click(function()
{
    var postData = $("#form_plan").serializeArray();
    var formURL = $("#form_plan").attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        dataType : 'json',
        success : function(response) {                    
          toastr.success(response.desc);          
          $('.panel-collapse.in').collapse('toggle');                               
          $('html, body').animate({ scrollTop: 0 }, 'slow');          
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            toastr.error("Ups, ha ocurrido un error inesperado, favor contacta con soporte");
        }
    });  
    
    
});
$("#plan_emergencia").click(function(){
	$.ajax( {  
        url : '<?php echo $this->basePath()."/admin/infocom/emergencia"?>',
		type : 'post',
        beforeSend : function() {
            var table = document.getElementById("ptabla1");            
           for(var i = table.rows.length - 1; i > 0; i--)
            {
            table.deleteRow(i);
            }
            },        
		success : function(response) { 		  
		  $("#plantable").append(response.tabla);        
		}
	});   
}
);
$("#sendseg").click(function()
{ 
    if( $("#id_proveedor").val()== 0){
        toastr.info("Debes seleccionar una entidad aseguradora")
    }else{
    $("#id_proveedor").removeAttr("disabled");
    var postData = $("#form1").serializeArray();
    var formURL = $("#form1").attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        dataType : 'json',
        success : function(response) {                    
          toastr.success(response.descripcion);          
          $('.panel-collapse.in').collapse('toggle');           
          $("#btnnuevoseguro").css("display","block");
          $("#divnuevoseguro").html("");
          $('html, body').animate({ scrollTop: 0 }, 'slow');          
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            toastr.error("Ups, ha ocurrido un error inesperado, favor contacta con soporte");
        }
    });
    }   
});