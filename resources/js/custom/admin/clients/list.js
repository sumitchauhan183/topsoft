let list = function(){
    let baseurl = '/topsoft/';
    let client_table = $('#client_table').DataTable({columnDefs: [
        {
            targets: [-1,3],
            className: 'text-center'
        },
        {
            targets: [0,1],
            className: 'dt-body-left'
        },
      ]});
    var data = [
        
    ];
    function runOnPageload(){
        getClientList();
    }

    function getClientList(){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/clients",
            data: [],
            type: "GET",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              console.log(d.clients);
              client_table.clear();
              d.clients.forEach(obj => {
                  let d = [
                      obj.name,
                      obj.company_name,
                      obj.email,
                      obj.address,
                      obj.status,
                      '<button class="btn revert">'+
                      '<a href="clients/view/'+obj.client_id+'"><i class="material-icons py-2 view-iconl" title="view">visibility</i></a>'+
                      '<a href="clients/edit/'+obj.client_id+'"><i class="material-icons py-2 view-iconl" title="edit">edit</i></a>'+
                      '<a href="clients/delete/'+obj.client_id+'"><i class="material-icons py-2 view-iconl" title="delete">delete</i></a>'+
                    '</button>'
                  ];

                  data.push(d);
              });
              client_table.rows.add(data);
              client_table.draw();
              
              
        });
    }
  
    return {
      init: function(){
          runOnPageload();
      }
  }  
  }();