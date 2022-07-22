function clickLogin(type){
    if(type==1){
        jQuery('#login-frm').show();
        jQuery('#register-frm').hide();
    }else if(type==2){
        jQuery('#login-frm').hide();
        jQuery('#register-frm').show();
    }
}
//flag is variable used to validation variable
var flag=0;
function checkUser(email){
    jQuery.ajax({
        type: "POST",
        url:base_url+'/check-email',
        data: {'email':email},
        dataType: "html",
        success: function(resultData){
            jQuery('.error').remove();
            jQuery('.error1').remove();
            if(resultData!=""){
                flag=1;
                jQuery('#email').after('<span class="error1">This email is already used...!</span>');
            }else{
                flag=0;
            }
        }
    })
}
function checkUsername(username){
    jQuery.ajax({
        type: "POST",
        url:base_url+'/check-username',
        data: {'username':username},
        dataType: "html",
        success: function(resultData){
            jQuery('.error').remove();
            jQuery('.error1').remove();
            if(resultData!=""){
                flag=1;
                jQuery('#username').after('<span class="error1">This username is already used...!</span>');
            }else{
                flag=0;
            }
        }
    })
}
function blurValidation(type){
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var data=[];
    jQuery('.error').remove();
    flag=0;
    if(type==1 && jQuery('#clickregister').val()==1){
        if(jQuery('#email').val()==""){
            jQuery('#email').after('<span class="error">Please enter email</span>');
            flag=1;
        }else if(emailReg.test(jQuery('#email').val())==false){
            jQuery('#email').after('<span class="error">Invalid email</span>');
            flag=1;
        }
        if(jQuery('#username').val()==""){
            jQuery('#username').after('<span class="error">Please enter username</span>');
            flag=1;
        }
        if(jQuery('#password').val()==""){
            jQuery('#password').after('<span class="error">Please enter password</span>');
            flag=1;
        }
        if(jQuery('#fullname').val()==""){
            jQuery('#fullname').after('<span class="error">Please enter fullname</span>');
            flag=1;
        }
        if(jQuery('#phone').val()==""){
            jQuery('#phone').after('<span class="error">Please enter phone</span>');
            flag=1;
        }
        if(jQuery('#businessname').val()==""){
            jQuery('#businessname').after('<span class="error">Please enter bussiness name</span>');
            flag=1;
        }
        if(jQuery('#businessaddress').val()==""){
            jQuery('#businessaddress').after('<span class="error">Please enter bussiness address</span>');
            flag=1;
        }
        if(jQuery('#position').val()==""){
            jQuery('#position').after('<span class="error">Please enter company position</span>');
            flag=1;
        }
        if(jQuery('#city').val()==""){
            jQuery('#city').after('<span class="error">Please enter city</span>');
            flag=1;
        }
        if(jQuery('#country').val()==""){
            jQuery('#country').after('<span class="error">Please enter country</span>');
            flag=1;
        }
        if(jQuery('#postalcode').val()==""){
            jQuery('#postalcode').after('<span class="error">Please enter postal code</span>');
            flag=1;
        }
        if(jQuery('#cpassword').val()==""){
            jQuery('#cpassword').after('<span class="error">Please enter confirmation password</span>');
            flag=1;
        }
        let _password_val = jQuery('#password').val();
        let _conf_password_val = jQuery('#cpassword').val();
        if (_password_val!=_conf_password_val) {

            jQuery('.error').remove();
            jQuery('#cpassword').after("<span class='error'>Password or confirmation doesn't match</span>");
            flag=1;
        }
    }
}

function createLogin(type){
    jQuery('#clickregister').val(1);
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var data=[];
    jQuery('.error').remove();
    if(type==1){
        if(jQuery('#email').val()==""){
            jQuery('#email').after('<span class="error">Please enter email</span>');
            flag=1;
        }else if(emailReg.test(jQuery('#email').val())==false){
            jQuery('#email').after('<span class="error">Invalid email</span>');
            flag=1;
        }
        if(jQuery('#username').val()==""){
            jQuery('#username').after('<span class="error">Please enter username</span>');
            flag=1;
        }
        if(jQuery('#password').val()==""){
            jQuery('#password').after('<span class="error">Please enter password</span>');
            flag=1;
        }
        if(jQuery('#fullname').val()==""){
            jQuery('#fullname').after('<span class="error">Please enter fullname</span>');
            flag=1;
        }
        if(jQuery('#phone').val()==""){
            jQuery('#phone').after('<span class="error">Please enter phone</span>');
            flag=1;
        }
        if(jQuery('#businessname').val()==""){
            jQuery('#businessname').after('<span class="error">Please enter bussiness name</span>');
            flag=1;
        }
        if(jQuery('#businessaddress').val()==""){
            jQuery('#businessaddress').after('<span class="error">Please enter bussiness address</span>');
            flag=1;
        }
        if(jQuery('#position').val()==""){
            jQuery('#position').after('<span class="error">Please enter company position</span>');
            flag=1;
        }
        if(jQuery('#city').val()==""){
            jQuery('#city').after('<span class="error">Please enter city</span>');
            flag=1;
        }
        if(jQuery('#country').val()==""){
            jQuery('#country').after('<span class="error">Please enter country</span>');
            flag=1;
        }
        if(jQuery('#postalcode').val()==""){
            jQuery('#postalcode').after('<span class="error">Please enter postal code</span>');
            flag=1;
        }
        if(jQuery('#cpassword').val()==""){
            jQuery('#cpassword').after('<span class="error">Please enter confirmation password</span>');
            flag=1;
        }
        let _password_val = jQuery('#password').val();
        let _conf_password_val = jQuery('#cpassword').val();
        if (_password_val!=_conf_password_val) {
            jQuery('#cpassword').after("<span class='error'>Password or confirmation doesn't match</span>");
            flag=1;
        }
    }
    if(flag==0){
        jQuery.ajax({
            type: "POST",
            url:base_url+'/checkout',
            data: {'data':jQuery('#regi-frm').serialize()},
            dataType: "html",
            success: function(resultData){
                jQuery('.error1').remove();
                var splitData = resultData.split("###");
                if(splitData[0]==0){
                    jQuery('#email').after('<span class="error1">This email is already used...!</span>');
                }else if(splitData[0]==3){
                    jQuery('#username').after('<span class="error1">This username is already used...!</span>');
                }else{
                    var basicDetail = splitData[2].split('@@@');
                    console.log(basicDetail);
                    jQuery('#regi-frm')[0].reset();
                    jQuery('.register-box').hide();
                    jQuery('.login-box').hide();
                    jQuery('#register-detail').show();
                    jQuery('#usernametxt').text(basicDetail[0]);
                    jQuery('#fullnametxt').text(basicDetail[1]);
                    jQuery('#emailtxt').text(basicDetail[2]);
                    jQuery('#phonetxt').text(basicDetail[3]);
                    var planUrl = jQuery('input[name="plan_url"]').val();
                    jQuery('#pay-btn').removeClass('btn-disabled');
                    jQuery('.btn-checkout').show();
                    jQuery('#pay-btn').removeAttr('disabled','disabled');
                    planUrl+='/'+btoa(btoa(splitData[1]));
                    jQuery('#pay-btn').attr('href',planUrl);
                    //jQuery('#pay-btn').attr('type','submit');
                    jQuery('.success').show();
                    setTimeout(function(){
                        jQuery('.success').hide();
                    },3000);
                    /*setTimeout(function(){
                       window.location.href=base_url+'/admin/dashboard';
                    },2000);*/

                }
            }
        })
    }
}
function loginUser(){
    if(jQuery('#emaillog').val()!="" && jQuery('#passwordlog').val()!=""){
        jQuery.ajax({
            type: "POST",
            url:base_url+'/admin/checksubscription',
            data: {'email':jQuery('#emaillog').val()},
            dataType: "html",
            success: function(result){
                var splitArr = result.split('###');
                var userId='';
                jQuery('.error-login').hide();
                jQuery('.error-login').text('');
                if(splitArr[0]=='1'){
                    jQuery('.error-login').show();
                    jQuery('.error-login').text('Aleady activated subscriptions plan for this user...!');
                    setTimeout(function(){
                        jQuery('.error-login').hide();
                    },3000);
                }else if(splitArr[0]=='2'){
                    jQuery('.error-login').show();
                    jQuery('.error-login').text('This account does not exists...!');
                    setTimeout(function(){
                        jQuery('.error-login').hide();
                    },3000);
                }else{
                    userId = splitArr[1];
                    jQuery.ajax({
                        type: "POST",
                        url:base_url+'/admin/login',
                        data: {'email':jQuery('#emaillog').val(),'password':jQuery('#passwordlog').val()},
                        dataType: "html",
                        success: function(resultData){
                            jQuery('.register-box').hide();
                            jQuery('.login-box').hide();
                            jQuery('#username-detail').show();
                            jQuery('.username').text('You have successfully logged in');
                            jQuery('.btn-checkout').show();
                            jQuery('#pay-btn').removeClass('btn-disabled');
                            var planUrl = jQuery('input[name="plan_url"]').val();
                            jQuery('#pay-btn').removeAttr('disabled','disabled');
                            planUrl+='/'+btoa(btoa(userId));
                            jQuery('#pay-btn').attr('href',planUrl);
                            jQuery('.success-login').show();
                            setTimeout(function(){
                                jQuery('.success-login').hide();
                            },3000);
                            jQuery('.error-login').hide();
                        },
                        error: function (error) {
                            jQuery('.error-login').show();
                            setTimeout(function(){
                                jQuery('.error-login').hide();
                            },3000);
                        }
                    });
                }
            }
        });
    }else{
        if(jQuery('#emaillog').val()==""){
            jQuery('#emaillog').after('<span class="error">Please enter email address</span>');
            flag=1;
        }
        if(jQuery('#passwordlog').val()==""){
            jQuery('#passwordlog').after('<span class="error">Please enter password</span>');
            flag=1;
        }
    }
}
function checkPassword() {
    let _password_val = jQuery('#password').val();
    let _conf_password_val = jQuery('#confrimpassword').val();
    jQuery('.error').remove();
    if (_password_val!=_conf_password_val) {
        $('#confrimpassword').after("<span class='error'>Password or confirmation doesn't match</span>");
        return false;
    }
}
function validationPassword(){
    //flagp is variable used to validation check 
    var flagp=0;
    jQuery('.error').remove();
    if (jQuery('#currentpassword').val()==""){
       $('#currentpassword').after('<span class="error">Please enter current password</span>');
       flagp=1;
    }
    if (jQuery('#password').val()==""){
       $('#password').after('<span class="error">Please enter password</span>');
       flagp=1;
    }
    if (jQuery('#confrimpassword').val()==""){
       $('#confrimpassword').after('<span class="error">Please enter confirmation password</span>');
       flagp=1;
    }
    if(jQuery('#password').val()!=jQuery('#confrimpassword').val()) {
        $('#confrimpassword').after("<span class='error'>Password or confirmation doesn't match</span>");
        flagp=1;
    }
    if(flagp==0){
        return true;
    }else{
        return false;
    }
}

function profileValidation(){
    jQuery('.error').remove();
    //flag11 is variable used to validation check 
    var flag11=0;
    
    if(jQuery('#fullname').val()==""){
        jQuery('#fullname').after('<span class="error">Please enter fullname</span>');
        flag11=1;
    }
    if(jQuery('#phone').val()==""){
        jQuery('#phone').after('<span class="error">Please enter phone</span>');
        flag11=1;
    }
    if(jQuery('#businessname').val()==""){
        jQuery('#businessname').after('<span class="error">Please enter bussiness name</span>');
        flag11=1;
    }
    if(jQuery('#businessaddress').val()==""){
        jQuery('#businessaddress').after('<span class="error">Please enter bussiness address</span>');
        flag11=1;
    }
    if(jQuery('#position').val()==""){
        jQuery('#position').after('<span class="error">Please enter company position</span>');
        flag11=1;
    }
    if(jQuery('#state').val()==""){
        jQuery('#state').after('<span class="error">Please enter state</span>');
        flag11=1;
    }
    if(jQuery('#city').val()==""){
        jQuery('#city').after('<span class="error">Please enter city</span>');
        flag11=1;
    }
    if(jQuery('#country').val()==""){
        jQuery('#country').after('<span class="error">Please enter country</span>');
        flag=1;
    }
    if(jQuery('#postalcode').val()==""){
        jQuery('#postalcode').after('<span class="error">Please enter postal code</span>');
        flag11=1;
    }
    if(flag11==0){
        return true;
    }else{
        return false;
    }
}
jQuery(document).ready(function(){
    setTimeout(function(){
        jQuery('.alert-success').hide();
    },3000);
})
jQuery('.frequency-interval input[type="radio"]').on('change', function(e) {
    var strfre='';
    if(jQuery(this).val()=='week'){
        jQuery('input[name="interval_count"]').attr('min','1');
        jQuery('input[name="interval_count"]').attr('max','48');
        strfre='weeks';
    }else if(jQuery(this).val()=='day'){
        jQuery('input[name="interval_count"]').attr('min','1');
        jQuery('input[name="interval_count"]').attr('max','365');
        strfre='days';
    }else if(jQuery(this).val()=='month'){
        jQuery('input[name="interval_count"]').attr('min','1');
        jQuery('input[name="interval_count"]').attr('max','12');
        strfre='months';
    }else if(jQuery(this).val()=='year'){
        jQuery('input[name="interval_count"]').attr('min','1');
        jQuery('input[name="interval_count"]').attr('max','1');
        strfre='years';
    }
    jQuery('.interval-count').find('label').text('Number of '+strfre+' for plan');
});
jQuery(document).ready(function(){
    var href = location.href;
    href=href.match(/([^\/]*)\/*$/)[1];
    if(href=='edit'){
        if(jQuery('body').find('.currency-cls').length!=0){
            jQuery('.currency-cls').find('input[type="radio"]').attr('disabled','disabled');   
        }
        if(jQuery('body').find('.price-fld').length!=0){
            jQuery('.price-fld').find('input[name="price"]').attr('readonly','readonly');   
        }
    }
});

function copyToClipboard(text) {
    var sampleTextarea = document.createElement("textarea");
    document.body.appendChild(sampleTextarea);
    sampleTextarea.value = text; //save main text in it
    sampleTextarea.select(); //select textarea contenrs
    document.execCommand("copy");
    document.body.removeChild(sampleTextarea);
    new Noty({
        type: "success",
        text: 'Successfully copied link',
    }).show();
}

function myFunction(){
    var copyText = document.getElementById("copylink");
    copyToClipboard(copyText.getAttribute("data-route"));
}
