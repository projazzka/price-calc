/**
 * front-end page javascript code
 * Performs form validation and send AJAX requests to server
 * Uses jQuery library
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */



function responseAjax( encoded ) {
	var data = eval( '(' + encoded + ')' );
	switch( data["error"] ) {
		case 1:
			alert( "The server couldn't send the email." );
			break;
		default:
		case 0:
			div = jQuery("#response");
			div.hide("fast");		
			div.html( data["quote"] );
			div.show("fast");
			break;
	}
}

function getParamMap( values ) {
	map = new Object;

	for( idx in values ) {
		id = values[idx];
		obj = jQuery("[name='" + id + "']");
		if( obj.attr("type") == "checkbox" ) 
			param = obj.is(":checked") ? "1" : "";
		else 
			param = obj.val();
		map[id]=param;
	}
	map['price-calc-ajax'] = '1';
	return map;
}

function sendAjax() {
	var all_with_contact = all.slice().concat( contact );
	jQuery.get( "index.php", getParamMap( all_with_contact ), responseAjax );
}

function checkForm() {
	required = obligatory.slice();
	
	// if email selected, then add contact info as required
	if( jQuery("#company_mail").is(":checked") ) {
		required = required.concat( contact_obligatory );
	} 
	
	var ok = true;
	for( idx in required ) {
		input = jQuery("[name='" + required[idx] + "']");
		if( !input.val() || input.val()==0 || input.val()=='' ) {
			input.css("background", "#fee3ad");
			ok = false;
		} else {
			input.css("background", "#ffffff");
		}
	}
	
	return ok;
}

function warnForm() {
		alert("Please fill in all boxes marked with an asterisk (*)");
}

function calculate() {
	if( !checkForm() ) {
		warnForm();
		return false;
	} else {
		sendAjax();
		return false;
	}
}	

function printWindow() {
	var all_with_contact = all.slice().concat( contact );

	if( !checkForm() ) {
		warnForm();
		return false;
	}
	values='';
	for( idx in all ) {
		id = all_with_contact[idx];
		value = jQuery("#" + id).val();
		values += "&" + encodeURI(id) + '=' + encodeURI(value);
	}
	win = window.open('index.php?price-calc-ajax=1&print=1'+values,'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=1,location=1');
}

function updateSubtotal() {
	var price = 0;
	for( i in all_select ) {
		attr = jQuery("#" + all[i] + " option:selected").attr('price');
		if(!isNaN(parseFloat(attr)))
			price += parseFloat(attr);
	}
	for( i in all_fixed ) {
		attr = jQuery("#" + all[i]).attr('price');
		if(!isNaN(parseFloat(attr)))
			price += parseFloat(attr);
	}
	jQuery("#subtotal").val( price );
	if(!checkForm()) {
		warn = "(form incomplete)";
	} else {
		warn = "";
	}
	jQuery("#incomplete").html( warn );		

}

function showMain() {
	jQuery("#main_form").html( "Loading..." );
	jQuery.get( "index.php", { "price-calc-form":1, "variation":jQuery( "#variation" ).val() }, function( html ) {
		jQuery("#main_form").html( html );
		jQuery("#control_form").css( "display", "block" );
		jQuery(":input").change( updateSubtotal );
	} );
}

jQuery(document).ready( function() {
	jQuery("#continue").click( showMain );
	jQuery("#company_mail").change( function() {
		jQuery("div#contact_form").toggle( jQuery(this).val() );
	} );
	jQuery("#calculate").click( calculate );
	jQuery("#print").click( printWindow );
	jQuery(":input").change( updateSubtotal );

} );

	
