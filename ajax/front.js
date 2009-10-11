/**
 * front-end page javascript code
 * Performs form validation and send AJAX requests to server
 * Uses jQuery library
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

function validate_unequal_reference( left, right, msg ) {
	leftval = jQuery("#"+left).val();
	rightval = jQuery("#"+right).val();
	if (leftval != rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_unequal_value( left, right, msg ) {
	leftval = jQuery("#"+left).val();
	if (leftval != right) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_greater_reference( left, right, msg ) {
	leftval = parseFloat(jQuery("#"+left).val());
	rightval = parseFloat(jQuery("#"+right).val());
	if (leftval > rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_greater_value( left, right, msg ) {
	leftval = parseFloat(jQuery("#"+left).val());
	if (leftval > parseFloat(right)) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_less_reference( left, right, msg ) {
	leftval = parseFloat(jQuery("#"+left).val());
	rightval = parseFloat(jQuery("#"+right).val());
	if (leftval < rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_less_value( left, right, msg ) {
	leftval = parseFloat(jQuery("#"+left).val());
	if (leftval < parseFloat(right)) {
		alert(msg);
		return false;
	}
	return true;
}

function validate_equal_reference( left, right, msg ) {
	leftval = jQuery("#"+left).val();
	rightval = jQuery("#"+right).val();
	if (leftval == rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_equal_value( left, right, msg ) {
	leftval = jQuery("#"+left).val();
	if (leftval == right) {
		alert(msg);
		return false;
	}
	return true;
}


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
		if (input.length != 0) { // ignore if form element is not displayed
			if (!input.val() || input.val() == 0 || input.val() == '') {
				input.css("background", "#fee3ad");
				ok = false;
			}
			else {
				input.css("background", "#ffffff");
			}
		}
	}
	
	return ok;
}

function warnForm() {
		alert("Please fill in all boxes marked with an asterisk (*)");
}

function calculate() {
	if( !validate_extra() )
		return false;
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

	if( !validate_extra() )
		return false;

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
	var total = 0;
	for( i in formula_ids ) {
		id = formula_ids[i];
		operator = formula_operators[i];
		operand = 0;
		valid = false;
		switch (types[id]) {
			case 'select':
				price = jQuery("#" + id + " option:selected").attr('price');
				operand = parseFloat(price);
				valid = !isNaN( operand );
				break;
			case 'fixed':
				price = jQuery("#" + id).attr('price');
				operand = parseFloat(price);
				valid = !isNaN( operand );
				break;
			case 'number':
				obj = jQuery("#" + id);
				text = obj.val();
				priceTxt = obj.attr('price');
				number = parseFloat(text);
				price = parseFloat(priceTxt);
				if (!isNaN(number) && !isNaN(price)) {
					operand = number * price;
					valid = true;
				}
				break;
			case 'checkbox':
				obj = jQuery("#" + id);
				operand = parseFloat(obj.attr('price'));
				if (!isNaN(price) && obj.is(':checked')) {
					valid = true;
				}
				break;
		}
		if (valid) {
			switch (operator) {
				case '+':
					total += operand;
					break;
				case '*':
					total *= operand;
					break;
				case '%':
					total *= ((operand / 100) + 1);
					break;
			}
		}
		//alert( "total:" + total + ", id: " + id + ",operand:" + operand + ", operator:" + operator +", valid:" + valid);
	}
	
	jQuery("#subtotal").val( total.toFixed(2) );
	if(!checkForm()) {
		warn = "(form incomplete)";
	} else {
		warn = "";
	}
	jQuery("#incomplete").html( warn );		

}

function nextStage() {
	if( !checkForm() ) {
		warnForm();
		return false;
	}
	stage = parseInt(jQuery(this).attr("stage"));
	jQuery("#stage_loading").show();
	params = {
		"price-calc-form":1,
		"formstage": (stage+1),
		"variation":jQuery( "#variation" ).val(),
		"values":JSON.stringify(getParamMap( all ))
	};
	jQuery.get( "index.php", params, function( html ) {
		jQuery("#stage-control-" + stage + " .stage-control-continue").hide();
		jQuery("#stage-control-" + stage + " .stage-control-back").show();
		jQuery("#form-stage-" + stage + " :input").attr("disabled", "disabled");

		jQuery("#main_form").append( html );
		jQuery("#control_form").css( "display", "block" );
		jQuery(":input").change( updateSubtotal );
		jQuery("#stage-continue-" + (stage+1)).click( nextStage );
		jQuery("#stage-back-" + (stage+1)).click( previousStage );
		
		jQuery(".on_change_next").change( nextStage );
	} );
	jQuery("#stage_loading").hide();
}

function previousStage() {
	stage = parseInt(jQuery(this).attr("stage"));
	jQuery(".form-stage:gt(" + stage + ")").remove();
	jQuery("#stage-control-" + (stage+1)).remove();
	jQuery("#stage-control-" + stage + " .stage-control-continue").show();
	jQuery("#stage-control-" + stage + " .stage-control-back").hide();
	jQuery("#form-stage-" + stage + " :input").removeAttr("disabled");
}

jQuery(document).ready( function() {
	jQuery(".stage-continue").click( nextStage ).removeAttr("disabled");
	jQuery(".stage-back").click( previousStage );
	jQuery("#company_mail").change( function() {
		jQuery("div#contact_form").toggle( jQuery(this).val() );
	} );
	jQuery("#calculate").click( calculate );
	jQuery("#print").click( printWindow );
	jQuery(":input").change( updateSubtotal );

} );

	
