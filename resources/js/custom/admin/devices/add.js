let add = function(){


    let email        = $('#email-new');
    let password       = $('#password-new');
    let status   = $('#status');
    let company  = $('#company-id');

    let add         = $('#add-device');
    let baseurl     = '/topsoft/';
    let data = {
        'email':email.val(),
        'password':password.val(),
        'status':status.val(),
        'company_id':company.val(),
        'email_error':false
    }

    email.change(function(){
        $('.error').remove();
        data.email = email.val();
        if(validateEmail()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">please enter valid email</span>');
            return;
        }
        checkEmailExist();

    });

    password.change(function(){
        $('.error').remove();
        data.password = password.val();
        if(data.password.length < 8 || data.password.length > 16){
            password.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*8-16 characters</span>');
            return;
        }
    });

    status.change(function(){
        data.status = status.val();
    });

    function validateEmail(){
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(data.email))
             {
               return (false)
             }
               return (true)

    }



    function checkEmailExist(){

        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/app-users/check/email",
            data: data,
            type: "POST",
            dataType: 'json',
            async:false
          })
            .done(function( d ,ret) {
              $('.loader').hide();
              if(d.error){
                email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">'+d.message+'</span>');
                data.email_error = true;
              }else{
                data.email_error = false;
              }
            });

}

    add.click(function(){
        $('.error').remove();

        data.email = email.val();
        data.password = password.val();
        data.status = status.val();
        data.company_id = company.val();
        if(data.email.length < 1){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }else if(validateEmail()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*You have entered an invalid email address!</span>');
            return;
        }
        checkEmailExist();

        if(data.email_error){
            return;
        }

        if(data.password.length < 1){
            password.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }
        if(data.password.length < 8 || data.password.length > 16){
            password.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*8-16 characters</span>');
            return;
        }


        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/app-users/add",
            data: data,
            type: "POST",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              if(d.error){
                alert(d.message);

              }else{
                  alert(d.message);
                  window.location.href = baseurl+"admin/company/"+data.company_id+"/app-users";
              }
        });



    });

    return {
      init: function(){
      }
  }
  }();
