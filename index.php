<!DOCTYPE html>
<html>
    <head>
        <title>
            ui rest api
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
        <script type="text/javascript">
              
            var isNew =true;
            
           
           
       

            $(function () {
                $("#reset").click(function(){
    $("#images").hide();
  });
                // if (isNew) {
                //     $("#images").hide();
                // }else{
                //     $("#images").show();
                // }
                $("#images").hide();
               
                all();
                
            });

            function all() {

               
                
                $.ajax({
                    url:"http://localhost/restful_api_ci_img/pegawai/all"
                }).then(function (data) {
                    var row='';
                    $.each(data, function (idx, pegawai){
                        row +='<tr>';
                        row +='<td onclick="prepareupdate('+pegawai.id+')"><a href="#">'+pegawai.id+'</td>';
                        row +='<td>'+pegawai.foto+'</td>';
                        row +='<td>'+pegawai.nama+'</td>';
                        row +='<td>'+pegawai.email+'</td>';
                        row +='</tr>';
                        
                    });
                    $('#row').append(row);
                });
                
                
                
             }
            function insertOrupdate(){

                if (isNew) {
                    $.ajax({
                        url:"http://localhost/restful_api_ci_img/pegawai/insert",
                        type:'POST',
                        data: 'nama='+$('#nama').val()+'&email='+$('#email').val()
                    }).then(function (data) {
                        console.log(data);
                        all();
                        $("reset").trigger('click');

                    });
                } else {
                    // let formData = new FormData($('#images').val());
                    // let img = $("#images")[0].files[0];
                    // formData.append('images',img);

                    var file_data = $('#images').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('images', file_data);
                    form_data.append('nama',$('#nama').val());
                    form_data.append('email',$('#email').val());
                    form_data.append('id',$('#id').val());

                    
                    $.ajax({
                        url:"http://localhost/restful_api_ci_img/pegawai/update",                        
                        type:'POST',
                        contentType : false,
                        processData: false,
                        mimeType: "multipart/form-data",
                        encode: true,
                        // data: 'nama='+$('#nama').val()+'&email='+$('#email').val()+'&id='+$('#id').val(),
                        data: form_data
                    }).then(function (data) {
                        console.log(data);
                        all();

                    });
                    // $.ajax({
                    //     url:"http://localhost/restful_api_ci_img/pegawai/upload",                        
                    //     type:'POST',
                    //     contentType : false,
                    //     processData: false,
                    //     mimeType: "multipart/form-data",
                    //     encode: true,
                    //     data: form_data
                    // }).then(function (data) {
                    //     console.log(data);
                    //     all();

                    // });
                }
                isNew=true;
                $("reset").trigger('click');
                $("#images").hide();

                    
                }
            function prepareupdate(id) {
                isNew=false;
                $("#images").show();
                
                $.ajax({
                    url:"http://localhost/restful_api_ci_img/pegawai/byid?id="+id

                }).then(function (data) {
                    $('#id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#email').val(data.email);
                    $('#images').val(data.foto);
                    
                });
                
            }
            function hapus(){
                if (confirm("menghapus data??")) {
                    $.ajax({
                    url:"http://localhost/restful_api_ci_img/pegawai/delete",
                    type:'POST',
                    data: 'id='+$('#id').val()
                }).then(function (data) {
                    console.log(data);
                    all();
                    $("reset").trigger('click');
                   
                    isNew=true;
                });
                }
                $("#images").hide();
                
            }
            

            
        </script>
        <script type="text/javascript">
            // $(document).ready(function(){
            //     // $("#hide").click(function(){
            //     //     $("#p").hide();
            //     // });
            //     // $("#show").click(function(){
            //     //     $("#p").show();
            //     // });

            //     if (isNew) {
                    
            //     $("#images").hide();
            //     }else{
                    
            //     $("#images").show();

            //     }
            // });
        </script>

    </head>
    <body>
        <form id="form" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" id="id"/><br>
            Nama Lengkap : <input type="text" name="nama" id="nama"><br>
            Email : <input type="text" name="email" id="email"><br>
            Foto : <input type="file" name="images" id="images"><br>
            <button onclick="insertOrupdate()" type="button">Simpan</button>
            <button onclick="hapus()" type="button">Hapus</button>
            <input type="reset" value="reset" id="reset">
            <br>
            
        </form>
        <!-- <button id="hide">Hide</button> -->
<!-- <button id="show">Show</button> -->
        <table border=1>
            <tr>
                <td>id</td>
                <td>foto</td>
                <td>nama</td>
                <td>email</td>
            </tr>
            <tbody id="row">

            </tbody>
        </table>
    </body>

</html>