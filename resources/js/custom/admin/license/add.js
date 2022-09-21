let add = function(){


    let deviceCount          = $('#device-count');
    let expirationDate       = $('#expiration-date');
    let companyId            = $('#company-id');

    let add         = $('#add-license');
    let baseurl     = '/topsoft/';
    let data = {
        'device_count':deviceCount.val(),
        'expiration_date':expirationDate.val(),
        'company_id':companyId.val()
    }

    deviceCount.mouseout(function(){
        data.device_count = deviceCount.val();
    });

    expirationDate.mouseout(function(){
        data.expiration_date = expirationDate.val();
    });




    add.click(function(){
        $('.error').remove();
        data.device_count = deviceCount.val();
        data.expiration_date = expirationDate.val();
        if(data.device_count.length < 1){
            deviceCount.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.expiration_date.length < 1){
            expirationDate.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }


        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/company/license/add",
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
                  location.href = baseurl+'admin/company/';
              }
        });



    });

    return {
      init: function(){
      }
  }
  }();
