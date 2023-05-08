function ajax_envia_email(js_cd_chamado,js_titulo,js_msg,js_grupo_dest,js_dest){

    $.ajax({
        url:"email/envio_email_universal.php",
        type: "GET",  
        data: {
            cd_chamado : js_cd_chamado,
            msg : js_msg,
            titulo : js_titulo,
            grupo_dest: js_grupo_dest,
            dest: js_dest
        },
        success:function(result){
            console.log(result);
        }
    });

}