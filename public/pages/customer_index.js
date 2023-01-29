function deleteCustomer(id) {
	if (!confirm('Are you sure you want to delete entry associated with this item ?')) return false;
	$.post({
	    type:'POST',
	    url:base_url + '/customers/' +  id + '/delete',
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

function editCustomer(id) {
	location.href = base_url + '/customers/' + id + '/edit';
}


function allowCustomer(id, allow) {
   if (!confirm('Are you sure you want to allow the customer to access market?')) return false;
   $.post({
       type:'POST',
       url:base_url + '/customers/' +  id,
       data: {active: allow},
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

      ajax: base_url + '/customers/getTableData',

      columns: [ 

         {
             "data": "id",
             render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
             }
         },

         { data: 'secret_code' }, 

         { data: 'phone' }, 

         { data: 'locale' }, 

         { 
         	data: 'messages_count',
            render: function (data, type, row) {
            	if (data == 0) {
            		return 'No messages.'
            	}
               return `<a href="${base_url}/customers/${row.id}/messages">${data} message${data > 1 ? 's' : ''}</a>`;
             },
         },


         { 
         	data: 'contacts_count',
            render: function (data, type, row) {
            	if (data == 0) {
            		return 'No contacts.'
            	}
               return `<a href="${base_url}/customers/${row.id}/contacts">${data} contact${data > 1 ? 's' : ''}</a>`;
             },
         },

         { 
            data: 'calls_count',
            render: function (data, type, row) {
               if (data == 0) {
                  return 'No calls.'
               }
               return `<a href="${base_url}/customers/${row.id}/calls">${data} call${data > 1 ? 's' : ''}</a>`;
             },
         },

         { 
         	data: 'files_count',
            render: function (data, type, row) {
            	if (data == 0) {
            		return 'No files.'
            	}
               return `<a href="${base_url}/customers/${row.id}/files">${data} file${data > 1 ? 's' : ''}</a>`;
             },
         },

         { 
            data: 'transactions_count',
            render: function (data, type, row) {
               if (data == 0) {
                  return 'No transactions.'
               }
               return `<a href="${base_url}/customers/${row.id}/transactions">${data} transaction${data > 1 ? 's' : ''}</a>`;
             },
         },

         { 
         	data: 'phone',
            render: function (data, type, row) {

            	var ret = '<div class="table-data-feature">';

                 ret += `<a class="btn btn-danger btn-sm mr-2" href="javascript:deleteCustomer(${row.id})"><i class="fas fa-trash"></i>Delete</a>`;

                 ret += `<a class="btn btn-info btn-sm mr-2" href="javascript:editCustomer(${row.id})"><i class="fas fa-pencil-alt"></i>Edit</a>`;

                 ret += `<a class="btn btn-warning btn-sm" href="javascript:allowCustomer(${row.id}, ${row.active==1 ? 0 : 1})"><i class="fas fa-unlock"></i>${row.active==1 ? 'Disable' : 'Allow'}</a>`;

                 ret += "</div>"

                 return ret;
             },
          }, 

      ], 

      initComplete: function (oSettings, json) {
         table.columns.adjust().draw();
      } 

   }); 


}); 