let edit = function(){

    let email        = $('#email');
    let password     = $('#password');
    let status       = $('#status');
    let device_id   = $('#device-id');
    let update      = $('#update-device');
    let baseurl     = '/topsoft/';
    let data = {
        'email':email.val(),
        'password':password.val(),
        'status':status.val(),
        'is_password':false,
        'device_id':device_id.val()
    }


    status.change(function(){
        data.status = status.val();
    });

    password.mouseout(function(){
        data.password = password.val();
    });

    email.change(function(){
        $('.error').remove();
        data.email = email.val();
        if(validateEmail()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">please enter valid email</span>');
            return;
        }
        checkEmailExist();

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



    update.click(function(){
        $('.error').remove();

        data.email = email.val();
        data.password = password.val();
        data.status = status.val();
        data.device_id = device_id.val();


        if(data.password.length > 1){
            data.is_password == true;
        }else{
            data.is_password == false;
        }

        checkEmailExist();

        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/app-users/update",
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
                  location.reload();
              }
        });



    });

    return {
      init: function(){
      }
  }
  }();
