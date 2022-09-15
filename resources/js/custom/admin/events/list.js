let list = function(){
    let baseurl = '/topsoft/';
    let event_table = $('#event_table').DataTable({columnDefs: [
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
        getEventList(this.value)
    });
    function runOnPageload(){
        getEventList('all');
    }

    function getEventList(id){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/events",
            data: {'id':id},
            type: "POST",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              event_table.clear();
              let data = [];
              d.events.forEach(obj => {
                  let d = [
                      obj.event_id,
                      obj.event_type,
                      obj.client_name,
                      obj.observation,
                      obj.event_date,
                      obj.status
                  ];

                  data.push(d);
              });
              event_table.rows.add(data);
              event_table.draw();
        });
    }

    return {
      init: function(){
          runOnPageload();
      }
  }
  }();
