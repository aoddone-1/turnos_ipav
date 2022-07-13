


$(document).ready(function () {
    $(".nav-link").click(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("container").innerHTML = this.responseText;
            }
            else {
                document.getElementById("container").innerHTML = "Cargando..."
            }
        };
        var str = $(this).attr("data-href");
        //false para que se haga de forma sincrona y devuelva el resultado junto con el refresco de pag
        //ver en un futuro cambiarlo y ponerle un cargando
        xhttp.open("GET", str, false);
        xhttp.send();


    });
});
