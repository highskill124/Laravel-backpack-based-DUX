let fpid;

$(document).ready(function()
{


    if($("input[name='is_ongoing_promotion']:checked").val()==1)
        $("#date_range").parent().parent('div').fadeOut();

    if($("input[name='vip_promotion']:checked").val()==0)
         $("#vip_promotion_description").parent('div').fadeOut();

    $("input[name='is_ongoing_promotion']").change(function() {

        if($("input[name='is_ongoing_promotion']:checked").val()==0) {
            $("#date_range").parent().parent('div').fadeIn();
        }
        else
        {
            $("#date_range").parent().parent('div').fadeOut();
            //$("#vip_promotion_description").hide();

        }
    });

    $("input[name='vip_promotion']").change(function() {

        if($("input[name='vip_promotion']:checked").val()==1) {

            $("#vip_promotion_description").parent('div').fadeIn();
        }
        else
        {
            $("#vip_promotion_description").parent('div').fadeOut();
            //$("#vip_promotion_description").hide();

        }
    });


    $('#Popup').click(function() {
        var x = screen.width/2 - 1024/2;
        var y = screen.height/2 - 800/2;

        //var NWin = window.open($(this).prop('href'), '', 'height=800,width=1024,toolbar=0,location=no,left='+x+',top='+y);
        var NWin = window.open($(this).prop('href'), '', 'height='+(x-50)+',width=1024,toolbar=0,location=no');
        if (window.focus)
        {
            NWin.focus();
        }
        return false;
    });


    var $form = $("form");
    var $submitbutton = $(".btn-success");



    $("input[name='is_active']").change(function() {
        $("#is_active-error").hide();
        $submitbutton.removeAttr("disabled");
    });


    $("form").validate({
        rules: {
            promotion_title: "required",
            promotion_description: "required",
            promotion_fineprint: "required",
            'locations[]' : "required",
        },
        messages : {
            promotion_title: {
                required: "promotion title field is required"
            },
            promotion_description: {
                required: "promotion description field is required"
            },
            promotion_fineprint: {
                required: "promotion fineprint field is required"
            }

        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "locations[]") {
                error.insertBefore(element.parent());

            } else {
                error.insertAfter(element);
            }
        },

    });

    $form.on("blur keyup", "input", () => {
        $submitbutton.removeAttr("disabled");
    });

    $("textarea").on("blur keyup",function() {
        $submitbutton.removeAttr("disabled");

    });

})





