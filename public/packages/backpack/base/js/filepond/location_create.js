$(function(){

    // Turn input element into a pond
  //  $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
    $('.my-pond').filepond();

    // Set allowMultiple property to true
    $('.my-pond').filepond('allowMultiple', true);
    $('.my-pond').filepond('storeAsFile', true);
  //  $('.my-pond').filepond('allowImagePreview', true);
   // $('.my-pond').filepond('imagePreviewUpscale', true);
   // $('.my-pond').filepond('imagePreviewMaxHeight', 140);


    // Listen for addfile event
    $('.my-pond').on('FilePond:addfile', function(e) {
        console.log('file added event', e);
    });   // Manually add a file using the addfile method
    // $('.my-pond').first().filepond('addFile', 'index.html').then(function(file){
    //     console.log('file added', file);
    // });


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

    console.log(name);

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

    $('#form').on('submit', function() {
        // check validation
        if (some_value != "valid") {
            return false;
        }
    });
});
