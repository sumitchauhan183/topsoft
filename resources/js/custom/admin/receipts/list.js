let list = function(){
    let baseurl = '/topsoft/';
    let receipt_table = $('#receipt_table').DataTable({columnDefs: [
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
        getReceiptList(this.value)
    });
    function runOnPageload(){
        getReceiptList('all');
    }

    function getReceiptList(id){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/receipts",
            data: {'id':id},
            type: "POST",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              receipt_table.clear();
              let data = [];
              d.receipts.forEach(obj => {
                  let d = [
                    obj.receipt_id,
                      obj.receipt_number,
                      obj.company_name,
                      obj.client_name,
                      obj.observation,
                      obj.amount,
                      obj.note,
                      obj.receipt_date,
                      obj.created_at
                  ];

                  data.push(d);
              });
              receipt_table.rows.add(data);
              receipt_table.draw();
        });
    }

    return {
      init: function(){
          runOnPageload();
      }
  }
  }();
