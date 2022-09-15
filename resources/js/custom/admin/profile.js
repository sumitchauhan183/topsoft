let profile = function(){
    let update = $('#update-profile');
    let name        = $('#name');
    let email       = $('#email');
    let password    = $('#password');
    let baseurl     = '/topsoft/';
    let data = {
        'name':name.val(),
        'email':email.val(),
        'password':password.val(),
        'is_password': false
    }

    name.mouseout(function(){
        data.name = name.val();
    });

    email.mouseout(function(){
        data.email = email.val();
    });

    password.mouseout(function(){
        data.password = password.val();
    });

    function validateEmail(){
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(data.email))
             {
               return (false)
             }
               return (true)

    }



    update.click(function(){
        $('.error').remove();

        if(data.name.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(validateEmail()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">enter valid email</span>');
            return;
        }

        if(data.password.length > 1){
            data.is_password == true;
        }else{
            data.is_password == false;
        }



        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/profile/update",
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
