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


   $(".btn-cancelar").click(function () {

        $('#idturno').val($(this).val());
    });

    $(".btn.btn-light").click(function () {

        $('#observacion').text($(this).val());
    });
});
