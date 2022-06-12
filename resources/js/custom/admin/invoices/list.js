let list = function(){
    let baseurl = '/topsoft/';
    let invoice_table = $('#invoice_table').DataTable({columnDefs: [
        {
            targets: [-1,0,3],
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
        getInvoiceList(this.value)
    });
    function runOnPageload(){
        getInvoiceList('all');
    }

    function getInvoiceList(id){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/invoices",
            data: {'id':id},
            type: "POST",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              invoice_table.clear();
              let data = [];
              d.invoices.forEach(obj => {
                  let d = [
                      obj.invoice_id,
                      obj.invoice_number,
                      obj.client_name,
                      obj.address,
                      obj.sub_total,
                      obj.status,
                      '<button class="btn revert">'+
                      '<a href="invoice/view/'+obj.invoice_id+'"><i class="material-icons py-2 view-iconl" title="view">visibility</i></a>'+
                    '</button>'
                  ];

                  data.push(d);
              });
              invoice_table.rows.add(data);
              invoice_table.draw();
        });
    }
  
    return {
      init: function(){
          runOnPageload();
      }
  }  
  }();