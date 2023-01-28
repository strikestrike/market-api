function delete_record(id) {
   if (!confirm('Are you sure you want to delete entry associated with this item ?')) return false;
   $.post({
       type:'POST',
       url:base_url + '/customer_calls/' +  id + '/delete',
       data: {id: id},
       success:function(data) {
          $('#mytable').DataTable().ajax.reload()
       },
      
       error: function (msg) {
           console.log(msg);
          var errors = msg.responseJSON;
       }
   });
}


$(document).ready(function(){ 

   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   // DataTable 

   var table = $('#mytable').DataTable({ 

      processing: true, 

      serverSide: true, 

      autoWidth: false,

      scrollX: true,

      ajax: {
         url: base_url + '/customerscalls/getTableData',
         data: {
            customer_id: customer_id
         }
      },

      columns: [ 

         {
            "data": "id",
            render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
            }
         }, 

         { 
            data: 'customer_id' ,
            visible: customer_id == 'all',
            render: function (data, type, row) {
               return `<a href="${base_url}/customers/${data}/edit">${data} (${row.secret_code})</a>`;
            },
         }, 

         { 
            data: 'number'
         },

         { 
            data: 'name'
         },

         { 
            data: 'call_type',
            render: function (data, type, row) {
               if (data == 'CallType.outgoing') {
                  return '<span class="bi bi-arrow-right-short" style="color:blue;"></span>'
               }
               return '<span class="bi bi-arrow-left-short" style="color:green;"></span>'
            },
         }, 

         { 
            data: 'timestamp'
         }, 

         { 
            data: '',
            render: function (data, type, row) {

               var ret = '<div class="table-data-feature">';

                 ret += `<a class="btn btn-danger btn-sm mr-2" href="javascript:delete_record(${row.id})"><i class="fas fa-trash"></i>Delete</a>`;

                 ret += "</div>";

                 return ret;
             },
          }, 

      ],

      initComplete: function (oSettings, json) {
         table.columns.adjust().draw();
      } 

   });


}); 