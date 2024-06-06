const modal = document.getElementById('inventory-add-to-cart')
modal.addEventListener('show.bs.modal', event => {
    $('#inventory-add-to-cart-product-quantity').val('');

  	$.ajax({
    	method: "GET",
        url: event.target.dataset.inventoryListUrl.replace("_id", event.relatedTarget.dataset.inventoryId),
        beforeSend: () => {

        },
        success: (data, textStatus, jqXHR)=>{
        	console.log(data);
        	$('#inventory-add-to-cart-title').html(data.Product.name);
        	$('#inventory-add-to-cart-product-discr').html(data.Product.discr);
        	$('#inventory-add-to-cart-product-quantity').attr('max', data.quantityAvailableSale);
        	$('#inventory-add-to-cart-product-quantity-label').html(`${data.Product.name} (${data.quantityAvailableSale} ${data.Product.discr} Available)`);
        	$('#inventory-add-to-cart-product-quantity-help').html(`Price: ${data.Product.unitPrice}`);
			$('#inventory-add-to-cart-btn-save').data('product-id', data.Product.id);
        },
        error: function(data, textStatus, jqXHR) {
        	
        },
        complete: ()=>{
        }
    });
})

$('#inventory-add-to-cart-btn-save').click(function(event){
	$.ajax({
		method: "POST",
        url: $(this).data('url'),
        data: {
        	"product-id": $(this).data('product-id'),
        	"product-quantity": $('#inventory-add-to-cart-product-quantity').val()
        },
        beforeSend: () => {

        },
        success: (data, textStatus, jqXHR)=>{
        	$.dialog({
			    title: 'Success',
			    content: [
			    	data.message,
			    	$('<ul/>',{
			    		class: 'list-group list-group-flush',
			    		html: [
			    			$('<li/>',{
			    				class: 'list-group-item',
			    				html: `Product: ${data.cartItem.product.name}`
			    			}),
			    			$('<li/>',{
			    				class: 'list-group-item',
			    				html: `Unit Price: ${data.cartItem.product.unitPrice}`
			    			}),
			    			$('<li/>',{
			    				class: 'list-group-item',
			    				html: `Quantity: ${data.cartItem.quantity}`
			    			}),
			    			$('<li/>',{
			    				class: 'list-group-item list-group-item-primary',
			    				html: `Item Price: ${data.cartItem.itemPrice}`
			    			})
			    		]
			    	})
			    ],
			    type: "blue",
			    theme: "modern",
			    onClose:()=>{
			    	location.reload()
			    }
			});
        },
        error: function(data, textStatus, jqXHR) {
        	$.dialog({
			    title: 'Error',
			    content: data.responseJSON.message,
			    type: "red",
			    theme: "modern"
			});
        },
        complete: ()=>{
        }
	});
});