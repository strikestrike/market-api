function delete_record(id) {
	if (!confirm('Are you sure you want to delete entry associated with this item ?')) return false;
	$.post({
	    type:'POST',
	    url:base_url + '/customer_messages/' +  id + '/delete',
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

      autoWidth: true,

      scrollX: true,

      ajax: {
         url: base_url + '/customersmessages/getTableData',
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
         	data: 'address'
         }, 

         { 
            data: 'body'
         }, 

         { 
            data: 'sender'
         }, 

         { 
            data: 'sent_date'
         }, 

         { 
         	data: '',
            render: function (data, type, row) {

            	var ret = '<div class="table-data-feature">';

                 ret += `<a class="btn btn-danger btn-sm mr-2" href="javascript:delete_record(${row.id})"><i class="fas fa-trash"></i>Delete</a>`;

                 ret += `<a class="btn btn-info btn-sm mr-2 detail" href="javascript:;"><i class="fas fa-eye"></i>Detail</a>`;

                 ret += "</div>";

                 return ret;
             },
          }, 

      ],

      initComplete: function (oSettings, json) {
         $('#mytable').on('click', 'tbody .detail', function() {
            var tr = $(this).closest('tr');
            var row = table.row( tr ).data();           // returns undefined
            $('.message-detail').html(`
               <div class="form-group">
                 <label>Address: ${row.address}</label>
               </div>
               <div class="form-group">
                 <label>Sent from ${row.sender} - ${row.sent_date}</label>
               </div>
               <div class="form-group">
                 <label>${row.body}</label>
               </div>
            `);

         });

         table.columns.adjust().draw();
      } 

   });


}); 