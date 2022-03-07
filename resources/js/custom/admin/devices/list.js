let list = function(){
    let baseurl = '/topsoft/';
    let company_id = $('#company_id').val();
    let table = $('#devices_table').DataTable({columnDefs: [
        
        {
            targets: [2,3],
            className: 'text-center'
        }
      ]});
    var data = [
        
    ];
    function runOnPageload(){
        getDevices();
    }

    function getDevices(){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/app-users",
            data: {'company_id':company_id},
            type: "POST",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              table.clear();
              d.devices.forEach(obj => {
                  
                  let d = [
                      obj.email,
                      obj.status,
                      obj.created_at,
                      '<button class="btn revert">'+
                      '<a href="'+baseurl+'admin/company/app-users/view/'+obj.device_id+'"><i class="material-icons py-2 view-iconl" title="view">visibility</i></a>'+
                      '<a href="'+baseurl+'admin/company/app-users/edit/'+obj.device_id+'"><i class="material-icons py-2 view-iconl" title="edit">edit</i></a>'+
                      '<a href="'+baseurl+'admin/company/app-users/delete/'+obj.device_id+'"><i class="material-icons py-2 view-iconl" title="delete">delete</i></a>'+
                    '</button>'
                  ];

                  data.push(d);
              });
              table.rows.add(data);
              table.draw();
        });
    }
  
    return {
      init: function(){
        runOnPageload();
      }
  }  
  }();