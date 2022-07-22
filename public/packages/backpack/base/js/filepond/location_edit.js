const limages = $.map($('input[type=hidden][name="limages[]"]'), function(el) { return el.value; });

$(function(){

    // Turn input element into a pond
    $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
    $('.my-pond').filepond();

    // Set allowMultiple property to true
    $('.my-pond').filepond('allowMultiple', true);
    $('.my-pond').filepond('storeAsFile', true);
    $('.my-pond').filepond('allowImagePreview', true);
    $('.my-pond').filepond('imagePreviewUpscale', true);
    $('.my-pond').filepond('imagePreviewMaxHeight', 140);


    // Listen for addfile event
    $('.my-pond').on('FilePond:addfile', function(e) {
        console.log('file added event', e);
    });   // Manually add a file using the addfile method
    // $('.my-pond').first().filepond('addFile', 'index.html').then(function(file){
    //     console.log('file added', file);
    // });

    if(limages.length>0)
    {
        limages.forEach(function(item) {
            var furl =  window.location.origin+"/storage/location/"+$('#location-id').val()+"/"+item;

            $('.my-pond')
                .filepond('addFile', furl)
                .then(function (file) {
                     console.log('file added', file);
                })

        });
    }

    //Manually add a file using the addfile method



});

function leadingZeros(input) {

    let name=String(input.name);
    if(!isNaN(input.value) && input.value.length === 1) {
        input.value = '0' + input.value;

    }
    else if(isNaN(input.value))
    {
        input.value = '00';

    }

    if(name.includes("min") && parseInt(input.value)>59)
    {
        input.value='00';

    }

}

function leadingZeroshours(input, ampm) {


    let name=String(input.name);



    if(!isNaN(input.value)) {

        if(input.value.length === 1)
            input.value = '0' + input.value;

        if(name.includes("hr") && parseInt(input.value)>23)
        {
            input.value='00';

        }
        if(parseInt(input.value)>12)
        {
            $('#'+ampm+'').bootstrapToggle('off');
            input.value=input.value-12;
            if(input.value.length === 1)
                input.value = '0' + input.value;

        }




    }
    else if(isNaN(input.value))
    {
        input.value = '00';
        $('#'+ampm+'').bootstrapToggle('on');
    }

}




$(document).ready(function(){

    fmethod = $("input[name=_method]").val();

    $('#address-input').on('input propertychange paste', function() {

        $('#map_changed').attr('required', 'true');
        $("#map_changedlbl").css("color","red");
        $("#map_changed").css("outline","4px solid red");
        $('#map_changed').attr('value', '1');
        $('#map_changed').prop('checked', false);

    });

    $('#address-latitude').on('input propertychange paste', function() {

        $('#map_changed').attr('required', 'true');
        $("#map_changedlbl").css("color","red");
        $("#map_changed").css("outline","4px solid red");
        $('#map_changed').attr('value', '1');
        $('#map_changed').prop('checked', false);

    });
    $('#address-longitude').on('input propertychange paste', function() {

        $('#map_changed').attr('required', 'true');
        $("#map_changedlbl").css("color","red");
        $("#map_changed").css("outline","4px solid red");
        $('#map_changed').attr('value', '1');
        $('#map_changed').prop('checked', false);

    });



    if($("input:radio[name=is_open_sunday]:checked").val()==1){
       $('#sunday').show();
    }
    if($("input:radio[name=is_open_monday]:checked").val()==1){
        $('#monday').show();
    }
    if($("input:radio[name=is_open_tuesday]:checked").val()==1){
        $('#tuesday').show();
    }
    if($("input:radio[name=is_open_wednesday]:checked").val()==1){
        $('#wednesday').show();
    }
    if($("input:radio[name=is_open_thursday]:checked").val()==1){
        $('#thursday').show();
    }
    if($("input:radio[name=is_open_friday]:checked").val()==1){
        $('#friday').show();
    }
    if($("input:radio[name=is_open_saturday]:checked").val()==1){
        $('#saturday').show();
    }



    $('input[name$="is_open_sunday"]').click(function(){
        var test = $(this).val();
        if(test==1)
        {
            $("#sunday").show();
        }
        else
        {
            $("#sunday").hide();
            $('input[name$="from_sun_hr"]').val("");
            $('input[name$="to_sun_hr"]').val("");
            $('input[name$="from_sun_min"]').val("");
            $('input[name$="to_sun_min"]').val("");
        }
    });
    $('input[name$="is_open_monday"]').click(function(){
        var test = $(this).val();
        if(test==1)
        {
            $("#monday").show();
        }
        else
        {
            $("#monday").hide();
            $('input[name$="from_mon_hr"]').val("");
            $('input[name$="to_mon_hr"]').val("");
            $('input[name$="from_mon_min"]').val("");
            $('input[name$="to_mon_min"]').val("");
        }
    });
    $('input[name$="is_open_tuesday"]').click(function(){
        var test = $(this).val();
        if(test==1)
        {
            $("#tuesday").show();
        }
        else
        {
            $("#tuesday").hide();
            $('input[name$="from_tue_hr"]').val("");
            $('input[name$="to_tue_hr"]').val("");
            $('input[name$="from_tue_min"]').val("");
            $('input[name$="to_tue_min"]').val("");
        }
    });
    $('input[name$="is_open_wednesday"]').click(function(){
        var test = $(this).val();
        if(test==1)
        {
            $("#wednesday").show();
        }
        else
        {
            $("#wednesday").hide();
            $('input[name$="from_tue_hr"]').val("");
            $('input[name$="to_tue_hr"]').val("");
            $('input[name$="from_tue_min"]').val("");
            $('input[name$="to_tue_min"]').val("");
        }
    });
    $('input[name$="is_open_thursday"]').click(function(){
        var test = $(this).val();
        if(test==1)
        {
            $("#thursday").show();
        }
        else
        {
            $("#thursday").hide();
            $('input[name$="from_thu_hr"]').val("");
            $('input[name$="to_thu_hr"]').val("");
            $('input[name$="from_thu_min"]').val("");
            $('input[name$="to_thu_min"]').val("");
        }
    });
    $('input[name$="is_open_friday"]').click(function(){
        var test = $(this).val();
        if(test==1)
        {
            $("#friday").show();
        }
        else
        {
            $("#friday").hide();
            $('input[name$="from_fri_hr"]').val("");
            $('input[name$="to_fri_hr"]').val("");
            $('input[name$="from_fri_min"]').val("");
            $('input[name$="to_fri_min"]').val("");
        }
    });
    $('input[name$="is_open_saturday"]').click(function(){
        var test = $(this).val();
        if(test==1)
        {
            $("#saturday").show();
        }
        else
        {
            $("#saturday").hide();
            $('input[name$="from_sat_hr"]').val("");
            $('input[name$="to_sat_hr"]').val("");
            $('input[name$="from_sat_min"]').val("");
            $('input[name$="to_sat_min"]').val("");
        }
    });



        $("#location-form").validate({
            rules: {
                location_name: "required",
                location_address: "required",
                email_id: {
                    required: true,
                    email: true
                },
                phone_number: "required",
                location_description: "required",
                phone_number: "required",
                is_active : "required",
                latitude : "required",
                longitude : "required",
                'category[]' : "required"

            },
            messages : {
                location_name: {
                    required: "location name field is required"
                },
                is_active: {
                    required: "Status is required"
                },
                location_description: {
                    required: "location description field is required"
                },
                location_address: {
                    required: "location address field is required"
                },
                email_id: {
                    required: "valid email field is required"
                },
                phone_number: {
                    required: "phone number field is required"
                },
                latitude: {
                    required: "latitude field is required"
                },
                longitude: {
                    required: "longitude field is required"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "is_active") {
                    error.insertAfter(element.parent());
                }
                else if (element.attr("name") == "category[]") {
                        error.insertBefore(element.parent());

                } else {
                    error.insertAfter(element);
                }
            },

        });


});


