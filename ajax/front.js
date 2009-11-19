/**
 * front-end page javascript code
 * Performs form validation and send AJAX requests to server
 * Uses jQuery library
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

var ttpc_memory = new Object;

function validate_unequal_reference( left, right, msg ) {
	var leftval = jQuery("#"+left).val();
	var rightval = jQuery("#"+right).val();
	if (leftval != rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_unequal_value( left, right, msg ) {
	var leftval = jQuery("#"+left).val();
	if (leftval != right) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_greater_reference( left, right, msg ) {
	var leftval = parseFloat(jQuery("#"+left).val());
	var rightval = parseFloat(jQuery("#"+right).val());
	if (leftval > rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_greater_value( left, right, msg ) {
	var leftval = parseFloat(jQuery("#"+left).val());
	if (leftval > parseFloat(right)) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_less_reference( left, right, msg ) {
	var leftval = parseFloat(jQuery("#"+left).val());
	var rightval = parseFloat(jQuery("#"+right).val());
	if (leftval < rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_less_value( left, right, msg ) {
	var leftval = parseFloat(jQuery("#"+left).val());
	if (leftval < parseFloat(right)) {
		alert(msg);
		return false;
	}
	return true;
}

function validate_equal_reference( left, right, msg ) {
	var leftval = jQuery("#"+left).val();
	var rightval = jQuery("#"+right).val();
	if (leftval == rightval) {
		alert(msg);
		return false;
	}
	return true;
}
function validate_equal_value( left, right, msg ) {
	var leftval = jQuery("#"+left).val();
	if (leftval == right) {
		alert(msg);
		return false;
	}
	return true;
}

function ttpc_number_format( number ) {
	return ttpc_currency + 
		phpjs_number_format( number, ttpc_decimals, ttpc_point, ttpc_thousands ) +
		ttpc_currencypost;
}

/* From: http://phpjs.org/functions/number_format */
function phpjs_number_format( number, decimals, dec_point, thousands_sep) {
    var n = number, prec = decimals;

    var toFixedFix = function (n,prec) {
        var k = Math.pow(10,prec);
        return (Math.round(n*k)/k).toString();
    };

    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = toFixedFix(Math.abs(n), prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    var decPos = s.indexOf(dec);
    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
    }
    else if (prec >= 1 && decPos === -1) {
        s += dec+new Array(prec).join(0)+'0';
    }
    return s;
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
	var param, map = new Object;

	for( var idx=0; idx<values.length; idx++ ) {
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
	var all_with_contact = ttpc_all.slice().concat( ttpc_contact );
	jQuery.get( "index.php", getParamMap( all_with_contact ), responseAjax );
}

function checkForm( checkMail ) {
	var required = ttpc_obligatory.slice();
	
	// if email selected, then add contact info as required
	if( checkMail & (ttpc_contact_force || jQuery("#company_mail").is(":checked")) ) {
		required = required.concat( contact_obligatory );
	} 
	
	var ok = true;
	for( var idx=0; idx<required.length; idx++ ) {
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

function ttpc_calculate() {
	if( !validate_extra() )
		return false;
	if( !checkForm( true ) ) {
		warnForm();
		return false;
	} else {
		sendAjax();
		return false;
	}
}	

function printWindow() {
	var all_with_contact = ttpc_all.slice().concat( ttpc_contact );

	if( !validate_extra() )
		return false;

	if( !checkForm( false ) ) {
		warnForm();
		return false;
	}
	var values='';
	for( var idx=0; idx<ttpc_all.length; idx++ ) {
		var id = all_with_contact[idx];
		var value = jQuery("#" + id).val();
		values += "&" + encodeURI(id) + '=' + encodeURI(value);
	}
	window.open('index.php?price-calc-ajax=1&print=1'+values,'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=1,location=1');
}

function ttpc_updateSubtotal() {
	var i, id, operator, operand, valid, price, total = 0;
	var obj, text, priceTxt, number;

	ttpc_memory = [];
	for( var i=0; i<formula_ids.length; i++ ) {
		id = formula_ids[i];
		operator = formula_operators[i];
		operand = 0;
		if (operator == 'C') {
			total = 0
		} else if (operator == '=') {
			ttpc_memory[id] = total;
		} else if (operator == 'f') {
			total = ttpc_custom_formula( total, id, ttpc_memory );
		} else {
			valid = false;
			if (id.charAt(0) == '@') {
				operand = ttpc_memory[id.substring(1)];
				valid = !isNaN(operand);
			} else {
				switch (ttpc_types[id]) {
					case 'select':
						price = jQuery("#" + id + " option:selected").attr('price');
						operand = parseFloat(price);
						valid = !isNaN(operand);
						break;
					case 'fixed':
						price = jQuery("#" + id).attr('price');
						operand = parseFloat(price);
						valid = !isNaN(operand);
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
		}
		//alert( "total:" + total + ", id: " + id + ",operand:" + operand + ", operator:" + operator +", valid:" + valid);
	}
	ttpc_memory['total'] = total;
	var value;
	if( subtotal_variable ) {
		value = ttpc_memory[subtotal_variable];
	} else {
		value = total;
	}
	if (!isNaN(value)) {
		subtotalTxt = ttpc_number_format( value );
		jQuery("#subtotal").val(subtotalTxt);
		jQuery("#subtotalspan").text(subtotalTxt);
	}
	
	for( var id in ttpc_results ) {
		variable = ttpc_results[id];
		if( variable in ttpc_memory ) {
			value = ttpc_memory[variable];
			jQuery("#" + id).text( ttpc_number_format( value ));
		}
	}

	var warn;
	if(!checkForm( false )) {
		warn = "(form incomplete)";
	} else {
		warn = "";
	}
	jQuery("#incomplete").html( warn );		

}

function ttpc_nextStage(){
	var stage = parseInt(jQuery(this).attr("stage"));
	if(!stage)
		stage = 0;

	ttpc_updateSubtotal();

	if( !validate_extra() )
		return false;

	if( !ttpc_customNextStage( stage ) )
		return false;

	stage++;

	if (!checkForm( false )) {
		warnForm();
		return false;
	}
	
	if( ttpc_preloadstages )
		ttpc_updateStages(stage);
	else
		ttpc_loadStage(stage);
}

function ttpc_previousStage() {
	var stage = parseInt(jQuery(this).attr("stage"));
	
	ttpc_updateStages( stage );
}

function ttpc_updateStages( stage ) {
	ttpc_updateTabs( stage );
	ttpc_updateControl( stage );
	ttpc_updateForms( stage );
	ttpc_updateSubtotal();
}

function ttpc_updateForms( stage ) {
	var idx = stage;
	jQuery(".form-stage:eq(" + idx + ")").show();
	if (ttpc_multitab) {
		jQuery(".form-stage:lt(" + idx + ")").hide();
	} else {
		if(!(stage==1 && jQuery('#variation').hasClass('stage-continue-direct')))
			jQuery("#form-stage-" + (stage-1) + " :input").attr("disabled", "disabled");
		jQuery("#form-stage-" + stage + " :input").removeAttr("disabled");
	}
	if (ttpc_preloadstages) 
		jQuery(".form-stage:gt(" + idx + ")").hide();
	else 
		jQuery(".form-stage:gt(" + idx + ")").remove();
	if (!ttpc_preloadstages) {
		jQuery(":input").change(ttpc_updateSubtotal);
		jQuery(".on_change_next").change(ttpc_nextStage);
		ttpc_enterTabbing();
	}

	if( stage == ttpc_stages ) {
		jQuery("#control_form").show();
	} else {
		jQuery("#control_form").hide();
	}
}

function ttpc_updateControl( stage ) {
	jQuery("#stage-control-" + stage + " .stage-control-continue").show();
	jQuery("#stage-control-" + stage + " .stage-control-back").hide();

	jQuery("#stage-control-" + (stage-1) + " .stage-control-continue").hide();
	jQuery("#stage-control-" + (stage-1) + " .stage-control-back").show();
	jQuery("#stage-control-" + (stage-2) + " .stage-control-back").hide();

	if (ttpc_preloadstages) {
		jQuery("#stage-control-" + (stage + 1) + " .stage-control-continue").hide();
		jQuery("#stage-control-" + (stage + 1) + " .stage-control-back").hide();
	} else {
		jQuery("#stage-control-" + (stage + 1)).remove();
	}
	jQuery("#stage-control-" + stage + " .stage-control-continue input").click( ttpc_nextStage );
	jQuery("#stage-control-" + stage + " .stage-control-back input").click( ttpc_previousStage );
}

function ttpc_loadStage( stage ) {
	var params = {
		"price-calc-form":1,
		"formstage": stage,
		"variation":jQuery( "#variation" ).val(),
		"values":JSON.stringify(getParamMap( ttpc_all ))
	};
	jQuery("#form-stage-" + stage).remove();
	jQuery("#stage_loading").show();
	jQuery.get( "index.php", params, function( html ) {

		jQuery("#main_form").append( html );
		
		jQuery("#response").empty();
		ttpc_updateStages( stage );
		jQuery("#stage_loading").hide();
	} );

}

function ttpc_updateTabs( stage ) {
	if( !ttpc_multitab )
		return;

	jQuery(".price-calc-tab:eq(" + (stage-1) + ")").addClass('current');
	jQuery(".price-calc-tab:gt(" + (stage-1) + ")").removeClass('current').removeClass('active');
	jQuery(".price-calc-tab:lt(" + (stage-1) + ")").removeClass('current').addClass('active');
}

/* use return key for switching among input elements */
function ttpc_enterTabbing() {
	if(!ttpc_useentertabbing)
		return;
	jQuery("input:text").keydown(function(e){
		if (e.keyCode == 13) {
			var inputs = jQuery('#price_calc input:text');
			var index = inputs.index(jQuery(this));
			var focus;
			if( index >= inputs.length - 1 )
				focus = 0;
			else
				focus = index + 1;
			inputs.eq( focus ).focus();
		
			jQuery(this).trigger('change');
			return false;
		}
		return true;
	});
}

jQuery(document).ready( function() {
	jQuery(".stage-continue").click( ttpc_nextStage ).removeAttr("disabled");
	jQuery("#variation.stage-continue-direct").change( ttpc_nextStage );
	jQuery(".stage-back").click( ttpc_previousStage );
	jQuery("#company_mail").change( function() {
		jQuery("div#contact_form").toggle( jQuery(this).val() );
	} );
	jQuery("#calculate").click( ttpc_calculate );
	jQuery("#print").click( printWindow );
	jQuery(":input").change( ttpc_updateSubtotal );
	ttpc_updateSubtotal();
	ttpc_enterTabbing();

} );

	
