$(document).ready(function(){  
    $(".megusta").click(function(){
        var id = this.id;
        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registro-reacciones',
            type: 'POST',
            data:{id:id},
            dataType: 'json',
            success: function(data){
                var img = data['img'];
                $('#'+id).html(img);
            }
        })
    });
});