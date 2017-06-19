$("#btngotocashier").click(function(){
    window.location.href = "/cashier/index";
});
$("#btnprint").click(function(){
    //alert("NIS : "+$("#nis").val());
    $.ajax({
        url:'/cashier/saveall',
        data:{
            "sppfrstmonth":$("#sppfrstmonth").val(),
            "sppfrstyear":$("#sppfrstyear").val(),
            "sppnextmonth":$("#sppnextmonth").val(),
            "sppnextyear":$("#sppnextyear").val(),
            "nis":$("#nis").val(),
            "spp":$("#spp").val(),
            "frstyear":$("#frstyear").val(),
            "frstmonth":$("#frstmonth").val(),
            "psb":$("#psb").val(),
            "book":$("#book").val(),
            "orispp":$("#orispp").val(),
            "months":["012017","022017","032017"]
        },
        type:'post'
    })
    .done(function(res){
        console.log(res);
        window.location.href = "/cashier/kwitansi"
    })
    .fail(function(err){
        alert("Err saveall"+err);
        console.log(err);
    });
});