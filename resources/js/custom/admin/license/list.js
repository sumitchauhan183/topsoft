let list = function(){
    let baseurl = '/topsoft/';
    let table = $('#company_table').DataTable({columnDefs: [
        {
            targets: [-1,3],
            className: 'dt-body-center'
        },
        {
            targets: [0,1],
            className: 'dt-body-left'
        },
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
                        '<a href="company/license/view/'+obj.license.licence_id+'"><i class="material-icons py-2 " title="view license">visibility</i></a>'+
                        '<a href="company/license/edit/'+obj.license.licence_id+'"><i class="material-icons py-2 " title="edit license">edit</i></a>'+
                        '<a href="company/license/delete/'+obj.license.licence_id+'"><i class="material-icons py-2 " title="delete license">delete</i></a>'+
                        '</button>';
                    }
                  let d = [
                      obj.name,
                      obj.greek_name,
                      obj.public_key,
                      obj.status,
                      license,
                      '<button class="btn revert">'+
                      '<a href="company/view/'+obj.company_id+'"><i class="material-icons py-2 view-icon" title="view">visibility</i></a>'+
                      '<a href="company/edit/'+obj.company_id+'"><i class="material-icons py-2 edit-icon" title="edit">edit</i></a>'+
                      '<a href="company/delete/'+obj.company_id+'"><i class="material-icons py-2 delete-icon" title="delete">delete</i></a>'+
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