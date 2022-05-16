let list = function(){
    let baseurl = '/topsoft/';
    let item_table = $('#item_table').DataTable({columnDefs: [
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

let company = $('#companies');
company.change(function(){
    getItemsList(this.value);
});

    function runOnPageload(){
        getItemsList('all');
    }

    function getItemsList(id){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/items",
            data: {'id':id},
            type: "POST",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              item_table.clear();
              let data = [];
              d.items.forEach(obj => {
                  let d = [
                      obj.name,
                      obj.quantity,
                      obj.price,
                      obj.description,
                      obj.status,
                      '<button class="btn revert">'+
                      '<a href="items/view/'+obj.item_id+'"><i class="material-icons py-2 view-iconl" title="view">visibility</i></a>'+
                      '<a href="items/edit/'+obj.item_id+'"><i class="material-icons py-2 view-iconl" title="edit">edit</i></a>'+
                      '<a href="items/delete/'+obj.item_id+'"><i class="material-icons py-2 view-iconl" title="delete">delete</i></a>'+
                    '</button>'
                  ];

                  data.push(d);
              });
              item_table.rows.add(data);
              item_table.draw();
              
              
        });
    }
  
    return {
      init: function(){
          runOnPageload();
      }
  }  
  }();