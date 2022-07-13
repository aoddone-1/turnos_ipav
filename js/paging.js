function cargar_paginado_tabla_resumenes(table,rowsShown,nav) {
    var totalRows =$(table + ' tbody tr').length; // Cantidad de Filas de la tabla #table
    var lastPage = 1;

    $(table).before('<nav><ul id="'+nav+'" class="pagination pagination-sm justify-content-end"><li class="page-item disabled" data-page="prev"><span class="page-link" >Anterior<span class="sr-only">(current)</span></span></li><li class="page-item" data-page="next" id="prev"><span class="page-link" >Siguiente<span class="sr-only">(current)</span></span></li></ul></nav>');
    lastPage = 1;
    $('#'+nav+'').find('li').slice(1, -1).remove();
    var trnum = 0;
    var maxRows = rowsShown;
    if (totalRows<=rowsShown) {
      $('#'+nav+'').hide();
    } else {
      $('#'+nav+'').show();
    }
    $(table + ' tr:gt(0)').each(function() {
      trnum++;
      if (trnum > maxRows) {
        $(this).hide();
      }
      if (trnum <= maxRows) {
        $(this).show();
      }
    });
    if (totalRows > maxRows) {
      var pagenum = Math.ceil(totalRows / maxRows);
      for (var i = 1; i <= pagenum; ) {
        $('#'+nav+' #prev').before('<li class="page-item" data-page="'+ i +'">\<span class="page-link" >' +i++ +'<span class="sr-only">(current)</span></span>\</li>').show();
      }
    }
    $('#'+nav+' [data-page="1"]').addClass('active');
    /*if(lastPage==1){
      $('#'+nav+' [data-page="prev"]').addClass('disabled');
    }else{

    }*/
    $('#'+nav+' li').on('click', function(evt) {
      // on click each page
      evt.stopImmediatePropagation();
      evt.preventDefault();
      var pageNum = $(this).attr('data-page');
      var maxRows = rowsShown;

      if (pageNum == 'prev') {
        if (lastPage == 1) {
          bloquearBotones(nav,lastPage);
          return;
        }
        pageNum = --lastPage;
      }
      if (pageNum == 'next') {
        if (lastPage == $('#'+nav+' li').length - 2) {
          bloquearBotones(nav,$('#'+nav+' li').length - 2);
          return;
        }
        pageNum = ++lastPage;
      }
      bloquearBotones(nav,pageNum);
      lastPage = pageNum;
      var trIndex = 0;

      $('#'+nav+' li').removeClass('active');
      $('#'+nav+' [data-page="' + lastPage + '"]').addClass('active');

      limitPagging(nav);
      $(table + ' tr:gt(0)').each(function() {
        trIndex++;
        if (trIndex > maxRows * pageNum ||
          trIndex <= maxRows * pageNum - maxRows) {
          $(this).hide();
        } else {
          $(this).show();
        }
      });
    });
    limitPagging(nav);
}
function bloquearBotones(nav,pageNum){
  if(pageNum>1){
    $('#'+nav+' [data-page="prev"]').removeClass('disabled');
  }else{
    $('#'+nav+' [data-page="prev"]').addClass('disabled');
  }
  if(pageNum<($('#'+nav+' li').length - 2)){
    $('#'+nav+' [data-page="next"]').removeClass('disabled');
  }else{
    $('#'+nav+' [data-page="next"]').addClass('disabled');
  }
}
function limitPagging(nav){
  if($('#'+nav+' li').length > 7 ){
    if( $('#'+nav+' li.active').attr('data-page') <= 3 ){
      $('#'+nav+' li:gt(5)').hide();
      $('#'+nav+' li:lt(5)').show();
      $('#'+nav+' [data-page="next"]').show();
    }
    if ($('#'+nav+' li.active').attr('data-page') > 3){
      $('#'+nav+' li:gt(0)').hide();
      $('#'+nav+' [data-page="next"]').show();
      for( let i = ( parseInt($('#'+nav+' li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('#'+nav+' li.active').attr('data-page'))  + 2 ) ; i++ ){
        $('#'+nav+' [data-page="'+i+'"]').show();
      }
    }
  }
}
