let edit = function(){
   
    let password     = $('#password');
    let status       = $('#status');
    let device_id   = $('#device-id');
    let update      = $('#update-device');
    let baseurl     = '/topsoft/';
    let data = {
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

   



    update.click(function(){
        $('.error').remove();
        

        if(data.password.length > 1){
            data.is_password == true;
        }else{
            data.is_password == false;
        }

        

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