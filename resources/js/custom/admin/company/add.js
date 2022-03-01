let add = function(){
   
    
    let name        = $('#name');
    let email       = $('#email');
    let greekName   = $('#greek-name');
    let password    = $('#password');
    
    let add         = $('#add-company');
    let baseurl     = '/topsoft/';
    let data = {
        'name':name.val(),
        'greekName':greekName.val(),
        'email':email.val(),
        'password':password.val()
    }

    name.mouseout(function(){
        data.name = name.val();
    });

    email.mouseout(function(){
        data.email = email.val();
    });

    greekName.mouseout(function(){
        data.greekName = greekName.val();
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

    function checkEmailExist(){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/company/check/email",
            data: data,
            type: "POST",
            dataType: 'json'
          })
            .done(function( d ) {
              $('.loader').hide();
              if(d.error){
                 return d.message;
              }else{
                  return false;
              }
            });
    
}

    add.click(function(){
        $('.error').remove();
        if(data.name.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

       /*  if(data.name.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        } */
        
        if(data.email.length < 1){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }else if(validateEmail()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*You have entered an invalid email address!</span>');
            return;
        }else if(checkEmailExist()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*email already used for other company</span>');
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
            url: baseurl+"api/admin/company/add",
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