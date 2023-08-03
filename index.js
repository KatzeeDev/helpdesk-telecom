function init(){
}

$(document).ready(function() {

});

$(document).on("click", "#btnsoporte", function () {
    if ($('#rol_id').val()==1){
        $('#lbltitulo').html("Acceso Tecnico de Area");
        $('#btnsoporte').html("Acceso Ejecutivo");
        $('#rol_id').val(2);
        $("#imgtipo").attr("src","public/2.jpg");
    }else{
        $('#lbltitulo').html("Acceso Ejecutivo");
        $('#btnsoporte').html("Acceso Tecnico de Area");
        $('#rol_id').val(1);
        $("#imgtipo").attr("src","public/1.jpg");
    }
});
init();