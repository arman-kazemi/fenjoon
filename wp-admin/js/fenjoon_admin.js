function hasClass( el, clss ) {
	return el.className && new RegExp( "(^|\\s)" + clss + "(\\s|$)" ).test( el.className );
}

function persianToEnglish( value ){
	var newValue="";
	for( var i=0; i < value.length; i++ ){
		var ch = value.charCodeAt( i );
		if( ch >= 1776 && ch <= 1785 ){
			var newChar = ch - 1728;
			newValue = newValue + String.fromCharCode( newChar );
		}else if( ch >= 1632 && ch <= 1641 ){
			var newChar = ch - 1584;
			newValue = newValue + String.fromCharCode( newChar );
		}else{
			newValue = newValue + String.fromCharCode( ch );
		}
	}
	return newValue;
}

function get_string( classname ){
	var checkboxes = document.getElementsByClassName( classname );
	var string = '';
	var array = new Array();
	for( var j=0; j<checkboxes.length; j++ ){
		if( checkboxes[j].checked ) array.push( checkboxes[j].value );
	}
	string = array.join('+');
	return string;
}

function get_string_dropdown( classname ){
	var dropdowns = document.getElementsByClassName( classname );
	var string_dropdown = '';
	var array = new Array();
	for( var j=0; j<dropdowns.length; j++ ){
		var e = dropdowns[j];
		var selectedIndex = e.selectedIndex;
		var strUser = e.options[selectedIndex].value;
		array.push( e.getAttribute('post')+'-'+strUser );
	}
	string_dropdown = array.join('+');
	return string_dropdown;
}

window.onload = function(){
	var checkboxes = document.getElementsByClassName('checkbox');
	for( var i=0; i<checkboxes.length; i++ ){
		checkboxes[i].onclick = function(){
			string = get_string( 'checkbox' );
			document.getElementsByName('string')[0].setAttribute('value', string);
		}
	}

	//Instalment
	amount = document.getElementById( 'amount' );
	day = document.getElementById( 'day' );
	month = document.getElementById( 'month' );
	year = document.getElementById( 'year' );
	passed = document.getElementById( 'passed' );
	concern = document.getElementById( 'concern' );
	var instalment = document.getElementsByClassName('instalment');
	for( var i=0; i<instalment.length; i++ ){
		instalment[i].onclick = function(){
			id = this.getElementsByClassName( 'id' )[0].innerText;
			if( hasClass( this, 'editing' ) ){
				this.classList.remove( 'editing' );
				document.getElementsByName('edit_instalment')[0].setAttribute('value', '');
			}else{
				for( var j=0; j<instalment.length; j++ ){
					instalment[j].classList.remove( 'editing' );
				}
				this.classList.add( 'editing' );
				document.getElementsByName('edit_instalment')[0].setAttribute('value', id);
			}
			str = this.getElementsByClassName( 'amount' )[0].innerText;
			amount.value = str.replace( /,/g, '' );
			due = this.getElementsByClassName( 'due' )[0].innerText;
			due_array = persianToEnglish( due ).split( '/' );
			year.value = due_array[0];
			month.value = due_array[1];
			day.value = due_array[2];
			p = this.getElementsByClassName( 'passed' )[0];
			passed.value = p.getAttribute( 'value' );
			c = this.getElementsByClassName( 'concern' )[0];
			concern.value = c.getAttribute( 'value' );
		}
	}

	var delete_instalments = document.getElementsByClassName('delete_instalments');
	for( var i=0; i<delete_instalments.length; i++ ){
		delete_instalments[i].onclick = function(){
			string = get_string( 'delete_instalments' );
			document.getElementsByName('delete_instalments')[0].setAttribute('value', string);
		}
	}

	//Payment
	pay = document.getElementById( 'pay' );
	pday = document.getElementById( 'pday' );
	pmonth = document.getElementById( 'pmonth' );
	pyear = document.getElementById( 'pyear' );
	approved = document.getElementById( 'approved' );
	pursuit = document.getElementById( 'pursuit' );
	note = document.getElementById( 'note' );
	var payment = document.getElementsByClassName('payment');
	for( var i=0; i<payment.length; i++ ){
		payment[i].onclick = function(){
			id = this.getElementsByClassName( 'id' )[0].innerText;
			if( hasClass( this, 'editing' ) ){
				this.classList.remove( 'editing' );
				document.getElementsByName('edit_payment')[0].setAttribute('value', '' );
			}else{
				for( var j=0; j<payment.length; j++ ){
					payment[j].classList.remove( 'editing' );
				}
				this.classList.add( 'editing' );
				document.getElementsByName('edit_payment')[0].setAttribute('value', id);
			}
			str = this.getElementsByClassName( 'pay' )[0].innerText;
			pay.value = str.replace( /,/g, '' );
			date = this.getElementsByClassName( 'date' )[0].innerText;
			date_array = persianToEnglish( date ).split( '/' );
			pyear.value = date_array[0];
			pmonth.value = date_array[1];
			pday.value = date_array[2];
			a = this.getElementsByClassName( 'approved' )[0];
			approved.value = a.getAttribute( 'value' );
			pursuit.value = this.getElementsByClassName( 'pursuit' )[0].innerText;
			note.value = this.getElementsByClassName( 'note' )[0].innerText;
		}
	}

	var delete_payments = document.getElementsByClassName('delete_payments');
	for( var i=0; i<delete_payments.length; i++ ){
		delete_payments[i].onclick = function(){
			string = get_string( 'delete_payments' );
			document.getElementsByName('delete_payments')[0].setAttribute('value', string);
		}
	}

	var checkboxes_done = document.getElementsByClassName('checkbox_done');
	for( var i=0; i<checkboxes_done.length; i++ ){
		checkboxes_done[i].onclick = function(){
			string_done = get_string( 'checkbox_done' );
			document.getElementsByName('string_done')[0].setAttribute('value', string_done);
		}
	}

	var dropdowns = document.getElementsByClassName('dropdown');
	for( var i=0; i<dropdowns.length; i++ ){
		dropdowns[i].onchange = function(){
			string_dropdown = get_string_dropdown( 'dropdown' );
			document.getElementsByName('string_dropdown')[0].setAttribute('value', string_dropdown);
		}
	}
}
