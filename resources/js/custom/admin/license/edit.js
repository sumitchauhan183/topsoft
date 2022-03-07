let edit = function(){
   
    let deviceCount          = $('#device-count');
    let expirationDate       = $('#expiration-date');
    let license_id           = $('#license-id');
    
    let update         = $('#update-license');
    let baseurl        = '/topsoft/';
    let data = {
        'device_count':deviceCount.val(),
        'expiration_date':expirationDate.val(),
        'license_id':license_id.val()
    }

    deviceCount.mouseout(function(){
        data.device_count = deviceCount.val();
    });

    expirationDate.mouseout(function(){
        data.expiration_date = expirationDate.val();
    });




    update.click(function(){
        $('.error').remove();
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
            url: baseurl+"api/admin/company/license/update",
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