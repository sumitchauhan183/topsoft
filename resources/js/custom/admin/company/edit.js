let edit = function(){

    let name        = $('#name');
    let greekName   = $('#greek-name');
    let password    = $('#password');
    let company_id  = $('#company_id');
    let update      = $('#update-company');
    let mobile      = $('#mobile');
    let address     = $('#address');
    let city        = $('#city');
    let region      = $('#region');
    let postal_code = $('#postal_code');
    let baseurl     = '/topsoft/';
    let data = {
        'name':name.val(),
        'greekName':greekName.val(),
        'company_id':company_id.val(),
        'password':password.val(),
        'is_password':false,
        'mobile': mobile.val(),
        'address': address.val(),
        'city':city.val(),
        'region':region.val(),
        'postal_code': postal_code.val(),
    }

    name.mouseout(function(){
        data.name = name.val();
    });

    greekName.mouseout(function(){
        data.greekName = greekName.val();
    });

    password.mouseout(function(){
        data.password = password.val();
    });

    mobile.change(function (){
        data.mobile = mobile.val();
    });

    address.change(function (){
        data.address = address.val();
    });

    city.change(function (){
        data.city = city.val();
    });

    region.change(function (){
        data.region = region.val();
    });

    postal_code.change(function (){
        data.postal_code = postal_code.val();
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
            url: baseurl+"api/admin/clients/check/email",
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

    update.click(function(){
        $('.error').remove();
        if(data.company_id.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*company id is missing</span>');
            return;
        }
        if(data.name.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.password.length > 1){
            data.is_password == true;
        }else{
            data.is_password == false;
        }



        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/company/update",
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
