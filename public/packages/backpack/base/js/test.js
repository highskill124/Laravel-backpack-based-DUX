$(document).ready(function()
{

    // $("input[name='vip_promotion']").click(function() {
    //     alert("XXX");
    //
    // });

     if($("input[name='vip_promotion']").prop('checked')== false)
         $("#vip_promotion_description").parent('div').fadeOut();

    $("input[name='vip_promotion']").change(function() {

        if($(this).prop('checked')) {
            $("#vip_promotion_description").parent('div').fadeIn();
        }
        else
        {
            $("#vip_promotion_description").parent('div').fadeOut();
            //$("#vip_promotion_description").hide();

        }
    });


})


