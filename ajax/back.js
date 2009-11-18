function toggleDiv() {
	jQuery( this ).parent().toggleClass( 'closed' );
}

jQuery( document ).ready( function() {
	jQuery( '.handlediv, .hndle' ).click( toggleDiv );
})
