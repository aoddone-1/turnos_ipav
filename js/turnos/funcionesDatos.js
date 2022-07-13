
$(document).ready(function(){

  $('select').change(function(e) {
    if ($("option:selected", $(e.currentTarget)).attr("data-default")) {
      CargarLocalidadesProvincia(e);
    }
  });

$('select').each(function(idx, ele) {
  $("option:selected", $(ele)).attr("data-default", "true")
});

$('select').change();

    $('#form-registrar').submit(function(event){
      $.ajax({
            url: '../turnos/registrar_usuario',
            type: "POST",
            data: $('#form-registrar').serialize(),
            dataType: 'json',
            success: function(data){
              document.getElementById("email").className = "form-control";
              document.getElementById("emailconfir").className = "form-control";
              document.getElementById("cuit").className = "form-control";
              document.getElementById("codArea").className = "form-control";
              document.getElementById("telefono").className = "form-control";
              document.getElementById("codAreaC").className = "form-control";
              document.getElementById("celular").className = "form-control";
              $('#mensajeContacto').html(null);
              $('#mensajeCuit').html(null);
              $('#mensajeCorreo').html(null);
              if(data.code=='cuitinvalido'){
                  document.getElementById("cuit").className = "form-control invalid";
                  $('#mensajeCuit').html("\n"+data.message);
              }else{
                if(data.code=='empleado'){
                    document.getElementById("cuit").className = "form-control invalid";
                    $('#mensajeCuit').html(data.message);
                }else{
                  if(data.code=='repetido'){
                      document.getElementById("cuit").className = "form-control invalid";
                      $('#mensajeCuit').html(data.message);
                  }else{
                    if(data.code=='telefono'){
                      document.getElementById("codArea").className = "form-control invalid";
                      document.getElementById("telefono").className = "form-control invalid";
                      document.getElementById("codAreaC").className = "form-control invalid";
                      document.getElementById("celular").className = "form-control invalid";
                      $('#mensajeContacto').html(data.message);
                    }else{
                      if(data.code=='correo'){
                        document.getElementById("email").className = "form-control invalid";
                        document.getElementById("emailconfir").className = "form-control invalid";
                        $('#mensajeCorreo').html(data.message);
                      }else{
                        if(data.code=='OK'){
                          document.getElementById("cuit").value=null;
                          document.getElementById("email").value=null;
                          document.getElementById("emailconfir").value=null;
                          document.getElementById("nombre").value=null;
                          document.getElementById("apellido").value=null;
                          document.getElementById("selectprov").value="";
                          document.getElementById("selectloc").value="";
                          document.getElementById("calle").value=null;
                          document.getElementById("altura").value=null;
                          document.getElementById("dpto").value=null;
                          document.getElementById("codArea").value=null;
                          document.getElementById("telefono").value=null;
                          document.getElementById("codAreaC").value=null;
                          document.getElementById("celular").value=null;

                          $('#mensaje').html(data.message);
                        }
                      }
                    }
                  }
                }
              }






            }
        });
        event.preventDefault();
    });


    $('#updateUsuario-form').submit(function(event){
      alert(hola);
      /*$.ajax({
        success: function(data){
        if(data.code=='correo'){
          document.getElementById("email").className = "form-control invalid";
          document.getElementById("emailconfir").className = "form-control invalid";
          $('#mensajeCorreo').html(data.message);
        }
        event.preventDefault();
      }
    });*/
  });
});
