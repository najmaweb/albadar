var test = false,originspp = 0;
numberWithCommas = function(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
removeCommas = function(myVar){
    //myVar = myVar.replace(/([.,])(\d\d\d\D|\d\d\d$)/g,'$2');
    myVar = myVar.replace(/[ ,]/g, "");
    return myVar;
}
filltotal = function(){
    var total = parseInt(removeCommas($("#spp").val()))+parseInt(removeCommas($("#psb").val()))+parseInt(removeCommas($("#book").val()))+parseInt(removeCommas($("#bimbel").val()));
    $("#total").val(numberWithCommas(total));
}
fillreturnmoney = function(){
    $("#returnmoney").val(numberWithCommas(parseInt(removeCommas($("#cashpay").val()))-parseInt(removeCommas($("#total").val()))));
}
$.ajax({
    url:'/students/getjson',
    dataType:'json'
})
.done(function(res){
    $("#sname").focus(function(){
        $(this).select();
    });
    $('#sname').autocomplete({
        lookup: res.out,
        onSelect: function(suggestion) {
            console.log('suggestion-data',suggestion.data);
            console.log('suggestion',suggestion);
            console.log('cek status');
            $("#nis").val(suggestion.nis);
            $("#studentname").val(suggestion.name);
            $("#grade").val(suggestion.grade);
                $.ajax({
                    url:'/students/getproperties/'+suggestion.nis,
                    type:'get',
                    dataType:'Json'
                })
                .done(function(res){
                    originspp = res.spp;
                    $("#spp_").val(numberWithCommas(res.spp));
                    $("#spp").val(numberWithCommas(res.spp));
                    $("#bimbel").val(numberWithCommas(res.bimbel));
                    filltotal();
                    fillreturnmoney();
                });
            //$('#selction-bts').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
        },
        onHint: function (hint) {
            console.log('hint',hint);
            //$('#autocomplete-bts-x').val(hint);
        },
        onInvalidateSelection: function() {
            //$('#selction-bts').html('You selected: none');
        }
    });
})
.fail(function(err){
    console.log("Error fetch json",err);
});
$("#cashpay").keyup(function(){
    fillreturnmoney()
});
$("#cashpay").focus(function(){
    $(this).select();
})
$("#cashpay").blur(function(){
    $(this).val(numberWithCommas($(this).val()));
})
$(".affect-total").focus(function(){
    $(this).val(removeCommas($(this).val().toString()));
    $(this).select();
})
$(".affect-total").blur(function(){
    $(this).val(numberWithCommas($(this).val().toString()));
})
togglespp = function(){
    if($("#sppcheckbox").prop("checked")){
        $("#sppmonthdiv").show();
    }else{
        $("#sppmonthdiv").hide();
    }
}
togglespp();
$("#sppcheckbox").change(function(){
    togglespp();
})
togglebimbel = function(){
    if($("#bimbelcheckbox").prop("checked")){
        $("#bimbelmonthdiv").show();
    }else{
        $("#bimbelmonthdiv").hide();
    }
}
togglebimbel();
$("#bimbelcheckbox").change(function(){
    togglebimbel();
});
$(".affect-total").keyup(function(){
    filltotal();
//    $("#returnmoney").val(parseInt($("#cashpay").val())-total);
    fillreturnmoney();
});
$(".sppperiod").change(function(){
    console.log("time changed");
    monthcount = 0;
    if($("#sppnextyear").val()===$("#sppfrstyear").val()){
        if($("#sppnextmonth").val()===$("#sppfrstmonth").val()){
            monthcount = 1;
        }else
        if($("#sppnextmonth").val()>$("#sppfrstmonth").val()){
            monthcount = $("#sppnextmonth").val() - $("#sppfrstmonth").val() + 1;
        }else{
            alert("Bulan Kedua harus lebih besar dari bulan Pertama");
        }
    }else
    if($("#sppnextyear").val()>$("#sppfrstyear").val()){
        frsmonths = 12 - $("#sppfrstmonth").val();
        months = 12*($("#sppnextyear").val()-$("#sppfrstyear").val() - 1);
        nexmonths = $("#sppnextmonth").val();
        monthcount = parseInt(frsmonths)+parseInt(months)+parseInt(nexmonths) + 1;
    }else{
        alert("Tahun kedua tidak boleh kurang tahun pertama");
    }
    spptotal = parseInt(originspp)*monthcount;
    $("#spp").val(numberWithCommas(spptotal));
    $("#spp_").val(numberWithCommas(spptotal));
    if(test===true){
        alert(monthcount);
    };
});