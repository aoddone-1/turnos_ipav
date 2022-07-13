function countChar(val, cant){ //CUENTA CARACTERES EN UN TEXT AREA, RECIBE EL TEXTO Y LA CANTIDAD ELEGIDA POR EL COMPONENTE
     var len = val.value.length;
     if (len > cant) {
              val.value = val.value.substring(0, 60);
     } else {
       $('#charNum').text((cant - len)+" Caracteres");
     }
};
function copy(){
  var copyText = document.getElementById("url");
  window.open(copyText.value, '_blank');
}

$('#page-content-wrapper').on('click', '.btn-change-pass',function(){
  //var usuario =$(this).attr('data-cod');
  //$('#modalCambiarPass').data('usuario',usuario).modal('show');
  $('#modalCambiarPass').modal('show');
});

$("#image").change(function() {
  var file = this.files[0];
  var imagefile = file.type;
  var match= ["image/jpeg","image/png","image/jpg"];
  if(file.size<=5000000){
    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
        alert('Seleccione un archivo válido (JPEG/JPG/PNG).');
        $("#image").val('');
        return false;
    }
  }else{
    alert('El tamaño de la imagen debe ser menos a 5MB (5000000 bytes).');
    $("#image").val('');
    return false;
  }
});

$("#video_name").change(function() {
  var file = this.files[0];
  var imagefile = file.type;
  if(file.size<=20971520){
    var match= ["mp4","wmv","avi"];
    if(!((imagefile.includes(match[0])) || (imagefile.includes(match[1])) || (imagefile.includes(match[2])))){
        alert('Seleccione un archivo válido (mp4/wmv/avi).');
        $("#video_name").val('');
        return false;
    }
  }else{
    alert('El tamaño del video debe ser menos a 20MB.');
    $("#video_name").val('');
    return false;
  }

});





window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggleOcultar');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
          var ocultar = document.getElementById("sidebarToggleOcultar");
          ocultar.style.display = 'none';
          var mostrar = document.getElementById("sidebarToggleMostrar");
          mostrar.style.display = 'block';
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }


    // Toggle the side navigation
    const sidebarToggle2 = document.body.querySelector('#sidebarToggleMostrar');
    if (sidebarToggle2) {
        sidebarToggle2.addEventListener('click', event => {
          var ocultar = document.getElementById("sidebarToggleOcultar");
          ocultar.style.display = 'block';
          var mostrar = document.getElementById("sidebarToggleMostrar");
          mostrar.style.display = 'none';
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});







function scrollToElement(selector, time, verticalOffset) {
    time = typeof(time) != 'undefined' ? time : 1000;
    verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $(selector);
    offset = element.offset();
    offsetTop = offset.top + verticalOffset;
    $('html, body').animate({
        scrollTop: offsetTop
    }, time);
}


function addLink()
{
    var name = $("#linkName").val();
    var url  = $("#linkUrl").val();

    var dataString = 'name='+name+'&url='+url;
    $.ajax({
        type: "POST",
        url: "panel/addLink",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            if(json_data.error == false)
            {
                $("#linksList").flexReload();
                $("#linkName").val('');
                $("#linkUrl").val('');
            }
            alert(json_data.msg);
        }
    });
}


function addMessage()
{
    var message = $("#messageText").val();

    var dataString = 'text='+message;
    $.ajax({
        type: "POST",
        url: "panel/addMessage",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            if(json_data.error == false)
            {
                $("#messagesList").flexReload();
                $("#messageText").val('');
            }
            alert(json_data.msg);
        }
    });
}



function editWelcomeMessage()
{
    var title = $("#welcomeTitle").val();
    var text  = $("#welcomeText").val();

    var dataString = 'title='+title+'&text='+text+'&active='+$("#welcomeActive").attr('checked');
    $.ajax({
        type: "POST",
        url: "panel/editWelcomeMessage",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            alert(json_data.msg);
        }
    });
}

function editInstitucional()
{
    var title = $("#institucionalTitle").val();
    var text  = escape(tinyMCE.get('institucionalText').getContent());
    var crest = escape(tinyMCE.get('institucionalCrest').getContent());

    var dataString = 'title='+title+'&text='+text+'&crest='+crest;
    $.ajax({
        type: "POST",
        url: "panel/editInstitucional",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            alert(json_data.msg);
        }
    });
}

function addService()
{
    var title = $("#serviceTitle").val();
    var text  = escape(tinyMCE.get('serviceText').getContent());
    var crest = escape(tinyMCE.get('serviceCrest').getContent());

    var dataString = 'title='+title+'&crest='+crest+'&text='+text;
    $.ajax({
        type: "POST",
        url: "panel/addService",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            if(json_data.error == false)
            {
                $("#servicesList").flexReload();
                $("#serviceTitle").val('');
                $("#serviceCrest").val('');
                $("#serviceText").val('');
            }
            alert(json_data.msg);
        }
    });
}

function addSorteo()
{
    var title = $("#sorteoTitle").val();
    var crest = escape(tinyMCE.get('sorteoCrest').getContent());
    var text  = escape(tinyMCE.get('sorteoText').getContent());

    var dataString = 'title='+title+'&crest='+crest+'&text='+text;
    $.ajax({
        type: "POST",
        url: "panel/addSorteo",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            if(json_data.error == false)
            {
                $("#sorteosList").flexReload();
                $("#sorteoTitle").val('');
                tinyMCE.get('sorteoText').setContent('');
                tinyMCE.get('sorteoCrest').setContent('');
            }
            alert(json_data.msg);
        }
    });
}

function addNotice()
{
    var title = $("#noticeTitle").val();
    var crest = escape(tinyMCE.get('noticeCrest').getContent());
    var text  = escape(tinyMCE.get('noticeText').getContent());
    var image  = $("#noticeTipo").val();


    var dataString = 'title='+title+'&crest='+crest+'&text='+text+'&image='+image;
    $.ajax({
        type: "POST",
        url: "panel/addNotice",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            if(json_data.error == false)
            {
                $("#noticesList").flexReload();
                $("#noticeTitle").val('');
                tinyMCE.get('noticeText').setContent('');
                tinyMCE.get('noticeCrest').setContent('');
                $("#noticeTipo").val('');
            }
            alert(json_data.msg);
        }
    });
}
function addLicit()
{
    var title = $("#licitTitle").val();
    var text  = escape(tinyMCE.get('licitText').getContent());
    var apertura  = $("#licitApertura").val();
    var presupuesto  = $("#licitPresupuesto").val();
    var tipo  = $("#licitTipo").val();
    var plazo  = $("#licitPlazo").val();


    var dataString = 'title='+title+'&text='+text+'&apertura='+apertura+'&presupuesto='+presupuesto+'&tipo='+tipo+'&plazo='+plazo;
    $.ajax({
        type: "POST",
        url: "panel/addLicit",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            if(json_data.error == false)
            {
                $("#licitList").flexReload();
                $("#licitTitle").val('');
                $("#licitApertura").val('');
                $("#licitPresupuesto").val('');
                $("#licitTipo").val('');
                $("#licitPlazo").val('');
                tinyMCE.get('licitText').setContent('');
            }
            alert(json_data.msg);
        }
    });
}


function editContact()
{
    var street = $("#contactStreet").val();
    var phones = $("#contactPhones").val();
    var emails = $("#contactEmails").val();

    var dataString = 'street='+street+'&phones='+phones+'&emails='+emails;
    $.ajax({
        type: "POST",
        url: "panel/editContact",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            alert(json_data.msg);
        }
    });
}

function addContent()
{
    var title = $("#contentTitle").val();
    var crest = escape(tinyMCE.get('contentCrest').getContent());
    var text  = escape(tinyMCE.get('contentText').getContent());


    var dataString = 'title='+title+'&crest='+crest+'&text='+text;
    $.ajax({
        type: "POST",
        url: "panel/addContent",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(json_data){
            if(json_data.error == false)
            {
                $("#contentsList").flexReload();
                $("#contentTitle").val('');
                tinyMCE.get('contentText').setContent('');
                tinyMCE.get('contentCrest').setContent('');
            }
            alert(json_data.msg);
        }
    });
}

function deleteService(id)
{
    if(confirm("Seguro que desea eliminar el servicio?"))
    {
        var dataString = 'id='+id;
        $.ajax({
            type: "POST",
            url: "panel/deleteService",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.response == true)
                {
                        $("#servicesList").flexReload();
                        alert("Servicio eliminado");
                }else{
                        alert("No se pudo eliminar el servicio, por favor intente nuevamente.");
                }
            }
        });
    }
}

function deleteArchivo(id)
{
    if(confirm("Seguro que desea eliminar el archivo?"))
    {
        var dataString = 'id='+id;
        $.ajax({
            type: "POST",
            url: "panel/deleteArchivo",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.response == true)
                {
                        $("#archivosList").flexReload();
                        alert("Archivo eliminado");
                }else{
                        alert("No se pudo eliminar el archivo, por favor intente nuevamente.");
                }
            }
        });
    }
}


function deleteNotice(id)
{
    if(confirm("Seguro que desea eliminar la noticia?"))
    {
        var dataString = 'id='+id;
        $.ajax({
            type: "POST",
            url: "panel/deleteNotice",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.response == true)
                {
                        $("#noticesList").flexReload();
                        alert("Noticia eliminada");
                }else{
                        alert("No se pudo eliminar la noticia, por favor intente nuevamente.");
                }
            }
        });
    }
}
function deleteLicit(id)
{
    if(confirm("Seguro que desea eliminar la licitación?"))
    {
        var dataString = 'id='+id;
        $.ajax({
            type: "POST",
            url: "panel/deleteLicit",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.response == true)
                {
                        $("#licitsList").flexReload();
                        alert("Licitación eliminada");
                }else{
                        alert("No se pudo eliminar la Licitación, por favor intente nuevamente.");
                }
            }
        });
    }
}


function deleteMessage(id)
{
    if(confirm("Seguro que desea eliminar el mensaje?"))
    {
        var dataString = 'id='+id;
        $.ajax({
            type: "POST",
            url: "panel/deleteMessage",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.response == true)
                {
                        $("#messagesList").flexReload();
                        alert("Mensaje eliminado");
                }else{
                        alert("No se pudo eliminar el mensaje, por favor intente nuevamente.");
                }
            }
        });
    }
}

function deleteLink(id)
{
    if(confirm("Seguro que desea eliminar el enlace?"))
    {
        var dataString = 'id='+id;
        $.ajax({
            type: "POST",
            url: "panel/deleteLink",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.response == true)
                {
                        $("#linksList").flexReload();
                        alert("Enlace eliminado");
                }else{
                        alert("No se pudo eliminar el enlace, por favor intente nuevamente.");
                }
            }
        });
    }
}

function deleteContent(id)
{
    if(confirm("Seguro que desea eliminar el contenido?"))
    {
        var dataString = 'id='+id;
        $.ajax({
            type: "POST",
            url: "panel/deleteContent",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.response == true)
                {
                        $("#contentsList").flexReload();
                        alert("Contenido eliminado");
                }else{
                        alert("No se pudo eliminar el contenido, por favor intente nuevamente.");
                }
            }
        });
    }
}




//flexigrid
$(document).ready(function(){
	$("#servicesList").flexigrid({
		url: 'panel/getServices',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_ser', width : 20, sortable : true, align: 'center'},
			{display: 'Nombre', name : 'titulo_ser', width : 500, sortable : true, align: 'center'},
                        {display: 'Imagen', name : 'imagen', width : 220, sortable : false, align: 'center'},
			{display: 'Acciones', name : 'accion', width : 130, sortable : false, align: 'center'},
			],
		sortname : "id_ser",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de servicios',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});

        $("#sorteosList").flexigrid({
		url: 'panel/getSorteos',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_sort', width : 20, sortable : true, align: 'center'},
			{display: 'Nombre', name : 'titulo_sort', width : 500, sortable : true, align: 'center'},
                        {display: 'Imagen', name : 'imagen', width : 220, sortable : false, align: 'center'},
			{display: 'Acciones', name : 'accion', width : 120, sortable : false, align: 'center'},
			],
		sortname : "id_sort",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de Sorteos',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});
        $("#noticesList").flexigrid({
		url: 'panel/getNotices',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_not', width : 20, sortable : true, align: 'center'},
			{display: 'Nombre', name : 'titulo_not', width : 500, sortable : true, align: 'center'},
                        {display: 'Imagen', name : 'imagen', width : 220, sortable : false, align: 'center'},
			{display: 'Acciones', name : 'accion', width : 120, sortable : false, align: 'center'},
			],
		sortname : "id_not",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de noticias',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});
        $("#licitsList").flexigrid({
		url: 'panel/getLicits',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_lic', width : 20, sortable : true, align: 'center'},
			{display: 'Nombre', name : 'titulo_lic', width : 500, sortable : true, align: 'center'},
                        {display: 'Imagen', name : 'imagen', width : 220, sortable : false, align: 'center'},
			{display: 'Acciones', name : 'accion', width : 120, sortable : false, align: 'center'},
			],
		sortname : "id_lic",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de licitaciones',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});

        $("#messagesList").flexigrid({
		url: 'panel/getMessages',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_men', width : 20, sortable : true, align: 'center'},
			{display: 'Mensaje', name : 'texto', width : 500, sortable : false, align: 'left'},
			{display: 'Acciones', name : 'accion', width : 75, sortable : false, align: 'center'},
			],
		sortname : "id_men",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de mensajes',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});

        $("#linksList").flexigrid({
		url: 'panel/getLinks',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_not', width : 20, sortable : true, align: 'center'},
			{display: 'Enlaces', name : 'nombre_enl', width : 500, sortable : true, align: 'left'},
			{display: 'Acciones', name : 'accion', width : 75, sortable : false, align: 'center'},
			],
		sortname : "id_enl",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de enlaces',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});

        $("#contentsList").flexigrid({
		url: 'panel/getContents',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_not', width : 20, sortable : true, align: 'center'},
			{display: 'Contenidos', name : 'titulo_adi', width : 500, sortable : true, align: 'left'},
			{display: 'Acciones', name : 'accion', width : 75, sortable : false, align: 'center'},
			],
		sortname : "id_adi",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de contenidos',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});


        $("#archivosList").flexigrid({
		url: 'panel/getArchivos',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_arc', width : 20, sortable : true, align: 'center'},
			{display: 'Nombre', name : 'nombre_arc', width : 500, sortable : true, align: 'left'},
                        {display: 'Ubicacion', name : 'ubicacion_arc', width : 220, sortable : false, align: 'center'},
			{display: 'Acciones', name : 'accion', width : 150, sortable : false, align: 'center'},
			],
		sortname : "id_arc",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de archivos',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});

        $("#imagesList").flexigrid({
		url: 'panel/getImagenes',
		dataType: 'json',
		colModel : [
			{display: '#', name : 'id_loc', width : 20, sortable : true, align: 'center'},
			{display: 'Nombre', name : 'nombre_loc', width : 500, sortable : true, align: 'left'},
			{display: 'Acciones', name : 'accion', width : 150, sortable : false, align: 'center'},
			],
		sortname : "id_loc",
		sortorder : "desc",
		usepager : true,
		title : 'Listado de imagenes',
		useRp : true,
		rp : 15,
		height: 400,
		showTableToggleBtn : true
	});

});

    $(document).ready(function()
    {
        $(".tablesorter").tablesorter();
        }
    );
    $(document).ready(function() {

        //When page loads...
        $(".tab_content").hide(); //Hide all content
        $("ul.tabs li:first").addClass("active").show(); //Activate first tab
        $(".tab_content:first").show(); //Show first tab content

        //On Click Event
        $("ul.tabs li").click(function() {

                $("ul.tabs li").removeClass("active"); //Remove any "active" class
                $(this).addClass("active"); //Add "active" class to selected tab
                $(".tab_content").hide(); //Hide all tab content

                var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                $(activeTab).fadeIn(); //Fade in the active ID content
                return false;
        });

        //On Click Event
        $("ul.tabsLeft li").click(function() {

            $("ul.tabs li").removeClass("active"); //Remove any "active" class
            $(this).addClass("active"); //Add "active" class to selected tab
            $(".tab_content").hide(); //Hide all tab content

            var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
            $(activeTab).fadeIn(); //Fade in the active ID content
            return false;
        });

    });


    //edits

    function editSetService(id, title, crest, text)
    {
	$("#editarServicios").show('slow');
        scrollToElement('#editarServicios');
        $("#serviceIdEdit").attr("value",id);
	$("#serviceTitleEdit").attr("value",title);
	$("#serviceCrestEdit").attr("value",crest);
        $("#serviceTextEdit").attr("value",text);
    }

    function editSetNotice(id, title, crest, text)
    {
        var crestesc = escape(crest);
        var textesc  = escape(text);
	$("#editarNoticias").show('slow');
        scrollToElement('#editarNoticias');
	$("#noticeTitleEdit").attr("value",title);
        tinyMCE.get('noticeCrestEdit').setContent(crestesc);
        tinyMCE.get('noticeTextEdit').setContent(textesc);
    }
    function editSetLicit(id, title, text, apertura,presupuesto, tipo, plazo)
    {
        var textesc  = escape(text);
        var aperturaesc  = escape(apertura);
	$("#editarLicitaciones").show('slow');
        scrollToElement('#editarLicitaciones');
	$("#licitTitleEdit").attr("value",title);
        tinyMCE.get('licitAperturaEdit').setContent(aperturaesc);
        tinyMCE.get('licitPresupuestoEdit').setContent(presupuesto);
        tinyMCE.get('licitTipoEdit').setContent(tipo);
        tinyMCE.get('licitPlazoEdit').setContent(plazo);
        tinyMCE.get('licitTextEdit').setContent(textesc);
    }


    function editSetMessage(id, text)
    {
	$("#editarMensajes").show('slow');
        scrollToElement('#editarMensajes');
        $("#messageIdEdit").attr("value",id);
        $("#messageTextEdit").attr("value",text);
    }

    function editSetLink(id, name, url)
    {
	$("#editarEnlaces").show('slow');
        scrollToElement('#editarEnlaces');
        $("#linkIdEdit").attr("value",id);
        $("#linkNameEdit").attr("value",name);
        $("#linkUrlEdit").attr("value",url);
    }

    function editSetContent(id, title, crest, text)
    {
	$("#editarContenidos").show('slow');
        scrollToElement('#editarContenidos');
        $("#contentIdEdit").attr("value",id);
        $("#contentTitleEdit").attr("value",title);
        $("#contentCrestEdit").attr("value",crest);
        $("#contentTextEdit").attr("value",text);
    }

    function editService()
    {
        var crest = escape(tinyMCE.get('serviceCrestEdit').getContent());
        var text  = escape(tinyMCE.get('serviceTextEdit').getContent());

        var dataString = 'id='+$("#serviceIdEdit").val()+'&title='+$("#serviceTitleEdit").val()+'&crest='+crest+'&text='+text;
        $.ajax({
            type: "POST",
            url: "../../panel/editService",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.error == false)
                {
                    $("#servicesList").flexReload();
                }
                alert(json_data.msg);
            }
        });
    }

    function editSorteo()
    {
        var crest = escape(tinyMCE.get('sorteoCrestEdit').getContent());
        var text  = escape(tinyMCE.get('sorteoTextEdit').getContent());

        var dataString = 'id='+$("#sorteoIdEdit").val()+'&title='+$("#sorteoTitleEdit").val()+'&crest='+crest+'&text='+text;
        $.ajax({
            type: "POST",
            url: "../../panel/editSorteo",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.error == false)
                {
                    $("#sorteosList").flexReload();
                }
                alert(json_data.msg);
            }
        });
    }

    function editNotice()
    {
        var crest = escape(tinyMCE.get('noticeCrestEdit').getContent());
        var text  = escape(tinyMCE.get('noticeTextEdit').getContent());

        var dataString = 'id='+$("#noticeIdEdit").val()+'&title='+$("#noticeTitleEdit").val()+'&crest='+crest+'&text='+text;
        $.ajax({
            type: "POST",
            url: "../../panel/editNotice",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.error == false)
                {
                    $("#noticesList").flexReload();
                }
                alert(json_data.msg);
            }
        });
    }
    function editLicit()
    {
        var text  = escape(tinyMCE.get('licitTextEdit').getContent());
        var apertura  = $("#licitAperturaEdit").val();
        var presupuesto  = $("#licitPresupuestoEdit").val();
        var tipo  = $("#licitTipoEdit").val();
        var plazo  = $("#licitPlazoEdit").val();

        var dataString = 'id='+$("#licitIdEdit").val()+'&title='+$("#licitTitleEdit").val()+'&text='+text+'&apertura='+apertura+'&presupuesto='+presupuesto+'&tipo='+tipo+'&plazo='+plazo;
        $.ajax({
            type: "POST",
            url: "../../panel/editLicit",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.error == false)
                {
                    $("#licitsList").flexReload();
                }
                alert(json_data.msg);
            }
        });
    }

    function addDocuments()
    {

        var dataString = $("#addFilesForm").serialize();
        $.ajax({
            type: "POST",
            url: "../../../../panel/addFiles",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                alert(json_data.msg);
            }
        });
    }

    function editContent()
    {
        var crest = escape(tinyMCE.get('contentCrestEdit').getContent());
        var text  = escape(tinyMCE.get('contentTextEdit').getContent());

        var dataString = 'id='+$("#contentIdEdit").val()+'&title='+$("#contentTitleEdit").val()+'&crest='+crest+'&text='+text;
        $.ajax({
            type: "POST",
            url: "../../panel/editContent",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.error == false)
                {
                    $("#contentsList").flexReload();
                }
                alert(json_data.msg);
            }
        });
    }

    function editMessage()
    {
        var dataString = 'id='+$("#messageIdEdit").val()+'&text='+$("#messageTextEdit").val();
        $.ajax({
            type: "POST",
            url: "panel/editMessage",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.error == false)
                {
                    $("#messagesList").flexReload();
                }
                alert(json_data.msg);
            }
        });
    }

    function editLink()
    {
        var dataString = 'id='+$("#linkIdEdit").val()+'&name='+$("#linkNameEdit").val()+'&url='+$("#linkUrlEdit").val();
        $.ajax({
            type: "POST",
            url: "panel/editLink",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(json_data){
                if(json_data.error == false)
                {
                    $("#linksList").flexReload();
                }
                alert(json_data.msg);
            }
        });
    }
    // \edits



// images
function appendImageService(id)
{
    $('#idImageSer').val(id);
    $('#imageService').show();
    scrollToElement('#imageService');
}

function appendImageSorteo(id)
{
    $('#idImageSort').val(id);
    $('#imageSorteo').show();
    scrollToElement('#imageSorteo');
}
function appendImageNotice(id)
{
    $('#idImageNot').val(id);
    $('#imageNotice').show();
    scrollToElement('#imageNotice');
}
function appendImageLicit(id)
{
    $('#idImageLic').val(id);
    $('#imageLicit').show();
    scrollToElement('#imageLicit');
}

function appendImageContent(id)
{
    $('#idImageCont').val(id);
    $('#imageContent').show();
    scrollToElement('#imageContent');
}




$(function() {
    setTimeout(function() {
        $("#messageURI").hide('blind', {}, 500)
    }, 5000);
});
// \edits
