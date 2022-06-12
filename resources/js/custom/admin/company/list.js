let list = function(){
    let baseurl = '/topsoft/';
    let table = $('#company_table').DataTable({columnDefs: [
        
        {
            targets: [0,1,4,5,-6],
            className: 'text-center',
            order:[]
        }
      ]});
    var data = [
        
    ];
    function runOnPageload(){
        getCompanyList();
    }

    function getCompanyList(){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/company",
            data: [],
            type: "GET",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              table.clear();
              d.company.forEach(obj => {
                  let license = '<button class="btn revert">'+
                                '<a href="company/'+obj.company_id+'/license/add"><i class="material-icons py-2" title="add license">add</i></a>'+
                                '</button>';
                  if(obj.license){
                        license = '<button class="btn revert">'+
                        '<a href="company/license/view/'+obj.license.licence_id+'"><i class="material-icons py-2 view-iconl" title="view license">visibility</i></a>'+
                        '<a href="company/license/edit/'+obj.license.licence_id+'"><i class="material-icons py-2 view-iconl" title="edit license">edit</i></a>'+
                        '<a href="company/license/delete/'+obj.license.licence_id+'"><i class="material-icons py-2 view-iconl" title="delete license">delete</i></a>'+
                        '</button>';
                    }
                  let d = [
                    '<a href="company/'+obj.company_id+'/app-users"><i class="material-icons py-2 view-iconl" title="app users">people</i></a>',
                      obj.company_id,
                      obj.name,
                      obj.greek_name,
                      obj.public_key,
                      obj.status,
                      license,
                      '<button class="btn revert">'+
                      '<a href="company/view/'+obj.company_id+'"><i class="material-icons py-2 view-iconl" title="view">visibility</i></a>'+
                      '<a href="company/edit/'+obj.company_id+'"><i class="material-icons py-2 view-iconl" title="edit">edit</i></a>'+
                      '<a href="company/delete/'+obj.company_id+'"><i class="material-icons py-2 view-iconl" title="delete">delete</i></a>'+
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