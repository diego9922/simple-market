$('.btn-remove-cart-item').click(function(){
	const url = $(this).data('url');
	$.confirm({
	    title: 'Are you sure?',
	    content: 'Are you sure of remove item from shopping cart?',
	    type: "orange",
	    theme: "modern",
	    buttons: {
	        yes: function () {
	        	$.ajax({
			    	method: "DELETE",
			        url,
			        beforeSend: () => {

			        },
			        success: (data, textStatus, jqXHR)=>{
			        	console.log(data);
			        	$.dialog({
						    title: 'Success',
						    content: data.message,
						    type: "blue",
						    theme: "modern",
						    onClose:()=>{
						    	location.reload()
						    }
						});
			        },
			        error: function(data, textStatus, jqXHR) {
			        	$.dialog({
						    title: 'It is no possible remove item',
						    content: data.message,
						    type: "red",
						    theme: "modern",
						    onClose:()=>{
						    	location.reload()
						    }
						});
			        },
			        complete: ()=>{
			        }
			    });
	            $.alert('Confirmed!');
	        },
	        no: function () {
	            $.alert('Canceled!');
	        }
	    }
	});
});