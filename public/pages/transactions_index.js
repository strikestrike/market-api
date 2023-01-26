function deleteItem(id) {
   if (!confirm('Are you sure you want to delete entry associated with this item ?')) return false;
   $.post({
       type:'POST',
       url:base_url + '/customer_transactions/' +  id + '/delete',
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
         url: base_url + '/customerstransactions/getTableData',
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

         { data: 'transaction_id' }, 

         { 
            data: 'created_at',
            render: function (data, type, row) {
               if (data) {
                  return data.split('T')[0]
               }
               return data;
            },
         }, 

         { 
            data: 'Actions',
            render: function (data, type, row) {

               var ret = '<div class="table-data-feature">';

                 ret += `<a class="btn btn-danger btn-sm mr-2" href="javascript:deleteItem(${row.id})"><i class="fas fa-trash"></i>Delete</a>`;

                 ret += "</div>"

                 return ret;
             },
          }, 

      ],

      initComplete: function (oSettings, json) {
         table.columns.adjust().draw();
      }

   }); 

   $('#btn_save').click(function() {
      var id = $('#id').val();
      var transaction_id = $('#transaction_id').val();
      $.post({
          type:'POST',
          url:base_url + '/customer_transactions/',
          data: {transaction_id: transaction_id},
          success:function(data) {
            if (data.errors){
              $('#myModal').modal('show');
              if(data.errors.transaction_id) {
                  alert(errors.transaction_id);
              }
            } else {
               $('#mytable').DataTable().ajax.reload()
               $('#myModal').modal('hide');
            }
          },
         
          error: function (msg) {
             var errors = msg.responseJSON.errors;
             if (errors) {
               $('#myModal').modal('show');
               if (errors.transaction_id) {
                  alert(errors.transaction_id);
               }
            } else {
               $('#mytable').DataTable().ajax.reload()
               $('#myModal').modal('hide');
            }
          }
      });   
   });

   $(document).on('click', '#btn_new', function() {
        $('.modal-title').text('New Notification');
         $('#transaction_id').val('');
        $('#myModal').modal('show');
    });


}); 