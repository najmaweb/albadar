var parent = "employees";
$(document).ready(function(){
    $('.btn-remove').click(function(e){
        e.preventDefault();
        tr = $(this).stairUp({level:2});
        toremove = tr.find(".nname").html();
        $("#toremove").html(toremove);
        $('#mdlconfirmation').modal('show');
    });
    $("#btndialogconfirmremove").click(function(){
        $.ajax({
            url:"/"+parent+"/remove/",
            data:{
                id:id
            },
            type:'post'
        })
        .done(function(res){
            console.log(res);
        })
        .fail(function(err){
            console.log(err);
        });
    })
});
