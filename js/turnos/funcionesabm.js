/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Example starter JavaScript for disabling form submissions if there are invalid fields




(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
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
    }, false);
})();



$(document).ready(function () {
    $(".btn.btn-danger").click(function () {
        $('#id').val($(this).val());
    });

    $('#addModal').on('shown.bs.modal', function () {
        $('#nombreadd').trigger('focus');

    });

    $('#deleteModal').on('shown.bs.modal', function () {

    });

    $('#updateModal').on('shown.bs.modal', function () {
        $('#nombreupdate').trigger('focus');
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
    $(".btn.btn-primary.editar").click(function () {
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

$(document).ready(function () {
    $(".tooltips").tooltip();
});

$(document).ready(function () {
    $('.toast').toast('show');
});