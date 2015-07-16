function ready() {
//===== Hide/show sidebar =====//
var baseURL=$("body").data("base");
  
        $(".delete").click(function () {
           // alert('kku');
            var tr=$(this).closest("tr");
            var check=confirm("Are You Sure ?");
            if(check){
           
            var id = $(this).data("id");
            var table = $(this).data("table");
            var string = 'id=' + id+"&table="+table;

            $.ajax({
                type: "POST",
                url: baseURL+"delete.php",
                data: string,
                cache: false,
                //beforeSend : function(){alert(this.url)},
                success: function (data) {
                    data=data.trim();
                    if(data=="Success"){
                        $("#succMsg").html("<span style='color:green;'>Deleted Successfully.</span>")
                        tr.remove();
                    }
                    else{
                        alert(data);
                    }
                }

            });

            return false;
        }
        
        });
    $("#info").hide();
    $("#info1").hide();
    $("#info2").hide();

    $("#hpop").click(function () {
        $("#info").show();

    });
    $("#hpop1").click(function () {
        $("#info1").show();

    });
    $("#hpop2").click(function () {
        $("#info2").show();

    });


    //===== Collapsible plugin for main nav =====//
  

} 
$('.expand').collapsible({
        defaultOpen: 'current,third',
        cookieName: 'navAct',
        cssOpen: 'subOpened',
        cssClose: 'subClosed',
        speed: 200
    });