function deleteCustomer(id) {
	if (!confirm('Are you sure you want to delete entry associated with this item ?')) return false;
	$.post({
	    type:'POST',
	    url:base_url + '/notifications/' +  id + '/delete',
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

      ajax: base_url + '/notifications/getTableData',

      columns: [ 

         {
             "data": "id",
             render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
             }
         },

         { data: 'notification' }, 

         { 
         	data: 'Actions',
            render: function (data, type, row) {

            	var ret = '<div class="table-data-feature">';

                 ret += `<a class="btn btn-danger btn-sm mr-2" href="javascript:deleteCustomer(${row.id})"><i class="fas fa-trash"></i>Delete</a>`;

                 ret += `<a class="btn btn-info btn-sm edit" href="javascript:;"><i class="fas fa-pencil-alt"></i>Edit</a>`;

                 ret += "</div>"

                 return ret;
             },
          }, 

      ],

      initComplete: function (oSettings, json) {
         $('#mytable').on('click', 'tbody .edit', function() {
            var tr = $(this).closest('tr');
            var row = table.row( tr ).data();

            $('.modal-title').text('Edit Notification');
            $('#id').val(row.id);
            $('#notification').val(row.notification);
            $('#myModal').modal('show');

         });

         table.columns.adjust().draw();
 
      }  

   }); 

   $('#btn_save').click(function() {
      var id = $('#id').val();
      var notification = $('#notification').val();
      var url = base_url + '/notifications/' +  id;
      if (id == '') {
         url = base_url + '/notification/'
      }
      $.post({
          type:'POST',
          url:url,
          data: {notification: notification},
          success:function(data) {
            if (data.errors){
              $('#myModal').modal('show');
              if(data.errors.notification) {
                  $('.invalid-feedback').removeClass('hidden');
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
               if (errors.notification) {
                  alert(errors.notification);
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
         $('#id').val('');
         $('#notification').val('');
        $('#myModal').modal('show');
    });


}); 