/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    $(".tooltips").tooltip();
});

$(document).ready(function () {
    $('.toast').toast('show');
});
$(document).ready(function () {
    $('.snackbar').snackbar('show');
});

function countChars(obj){
//    alert('hola');
    var maxLength = 150;
    var strLength = obj.value.length;
    var charRemain = (maxLength - strLength);

    if(charRemain < 11){
        document.getElementById("charNum").innerHTML = '<span style="color: red;">'+charRemain+' caracteres restantes</span>';
    }else{
        document.getElementById("charNum").innerHTML = charRemain+' caracteres restantes';
    }
}

$('#detalleModal').on('shown.bs.modal', function () {

});

$(document).ready(function (){
    $('#updateModal').on('shown.bs.modal', function () {

        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
});

$(document).ready(function () {
    $(".btn.btn-success.editar").click(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("updateModal").innerHTML = this.responseText;
            }
            else {
                document.getElementById("updateModal").innerHTML = "Cargando..."
            }
        };
        var str = $(this).attr("data-href") + "?id=" + $(this).val() + "&pag=" + $("#pag").val()
        //false para que se haga de forma sincrona y devuelva el resultado junto con el refresco de pag
        //ver en un futuro cambiarlo y ponerle un cargando
        xhttp.open("GET", str, false);
        xhttp.send();


    });
});

$(document).ready(function (){
    $('#anularModal').on('shown.bs.modal', function () {

        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
});


$(document).ready(function () {
    $(".btn.btn-danger.anular").click(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("anularModal").innerHTML = this.responseText;
            }
            else {
                document.getElementById("anularModal").innerHTML = "Cargando..."
            }
        };
        var str = $(this).attr("data-href") + "?id=" + $(this).val() + "&pag=" + $("#pag").val()
        //false para que se haga de forma sincrona y devuelva el resultado junto con el refresco de pag
        //ver en un futuro cambiarlo y ponerle un cargando
        xhttp.open("GET", str, false);
        xhttp.send();


    });
});

$(document).ready(function (){
    $('#finalizarModal').on('shown.bs.modal', function () {

        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
});


$(document).ready(function () {
    $(".btn.btn-primary.finalizar").click(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("finalizarModal").innerHTML = this.responseText;
            }
            else {
                document.getElementById("finalizarModal").innerHTML = "Cargando..."
            }
        };
        var str = $(this).attr("data-href") + "?id=" + $(this).val() + "&pag=" + $("#pag").val()
        //false para que se haga de forma sincrona y devuelva el resultado junto con el refresco de pag
        //ver en un futuro cambiarlo y ponerle un cargando
        xhttp.open("GET", str, false);
        xhttp.send();


    });
});


$(document).ready(function (){
    $('#coordinarModal').on('shown.bs.modal', function () {

        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
});


$(document).ready(function () {
    $(".btn.btn-primary.coordinar").click(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("coordinarModal").innerHTML = this.responseText;
            }
            else {
                document.getElementById("coordinarModal").innerHTML = "Cargando..."
            }
        };
        var str = $(this).attr("data-href") + "?id=" + $(this).val() + "&pag=" + $("#pag").val()
        //false para que se haga de forma sincrona y devuelva el resultado junto con el refresco de pag
        //ver en un futuro cambiarlo y ponerle un cargando
        xhttp.open("GET", str, false);
        xhttp.send();


    });
});


window.onload = function() {
  var myInput = document.getElementById('email');
  var myInput2 = document.getElementById('emailconfir');
  var myInput3 = document.getElementById('cuit');
  var myInput4 = document.getElementById('ntramite');
  myInput.onpaste = function(e) {
    e.preventDefault();
  }
  myInput2.onpaste = function(e) {
    e.preventDefault();
  }
  myInput.oncopy = function(e) {
    e.preventDefault();
  }
  myInput2.oncopy = function(e) {
    e.preventDefault();
  }
  myInput3.onpaste = function(e) {
    e.preventDefault();
  }
  myInput3.oncopy = function(e) {
    e.preventDefault();
  }
  myInput4.onpaste = function(e) {
    e.preventDefault();
  }
  myInput4.oncopy = function(e) {
    e.preventDefault();
  }
}

function validar_email() {

    var cla1 = document.regist.email.value;
    var cla2 = document.regist.emailconfir.value;
    var enviar="si";

    if (cla1 != cla2) {
        alert ("Los correos electrónicos deben ser iguales en ambos campos");
        enviar="no";
    }
    if (enviar=="no") {
      return false;
    };
  }
