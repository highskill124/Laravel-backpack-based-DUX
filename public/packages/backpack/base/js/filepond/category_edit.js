var url = window.location.origin + "/storage/" + $('[name=category_image]').val();
let fpid;

$(function(){

    // Turn input element into a pond
    $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
    $('.my-pond').filepond();

    // Set allowMultiple property to true
    $('.my-pond').filepond('allowMultiple', false);
    $('.my-pond').filepond('storeAsFile', true);
    $('.my-pond').filepond('allowImagePreview', true);
    $('.my-pond').filepond('imagePreviewUpscale', true);
    $('.my-pond').filepond('imagePreviewHeight', 180);


//Manually add a file using the addfile method
    $('.my-pond')
        .filepond('addFile', url)
        .then(function (file) {
           // console.log('file added', file);
        });

    $('.my-pond').on('FilePond:addfile', function(e) {
        // console.log('file added event', e);
        //console.log(fpid);
        $("#"+fpid).hide();
    });
});

$(document).ready(function(){

    var $form = $("form");
    var $submitbutton = $(".btn-success");
    var imageid= $("[name='category_image']");
    fpid = imageid.attr('id')+"-error";



    $("input[name='is_active']").change(function() {
        $("#is_active-error").hide();
        $submitbutton.removeAttr("disabled");
    });

    console.log(fpid);



    $("form").validate({
        ignore: [],
        rules: {
            category_image: "required",
            category_name: "required",
            category_description: "required",
            is_active : "required",
        },
        messages : {
            category_image: {
                required: "category image field is required"
            },
            category_name: {
                required: "category name field is required"
            },
            category_description: {
                required: "category description field is required"
            },
            is_active: {
                required: "status field is required"
            }

        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "category_image") {
                error.insertBefore(element.parent().parent());

            }
            else if (element.attr("name") == "is_active") {
                error.insertAfter(element);
            }
            else {
                error.insertAfter(element);
            }
        },

    });

    $form.on("blur keyup", "input", () => {
        $submitbutton.removeAttr("disabled");
        //    if ($form.valid()) {
        //        $submitbutton.removeAttr("disabled");
        //    } else {
        //       $submitbutton.attr("disabled", "disabled");
        //   }
    });

    $("textarea").on("blur keyup",function() {
        $submitbutton.removeAttr("disabled");

    });
})
