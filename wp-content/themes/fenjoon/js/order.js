function exchangeClass( element, firstClass, secondClass ){
	if( element==null || element.classList==null ) return;
	if( hasClass( element, firstClass ) ) {
		element.classList.add( secondClass ); // += (' ' + toAdd);
		element.classList.remove( firstClass );
	}else{
		element.classList.add( firstClass ); // += (' ' + toAdd);
		element.classList.remove( secondClass );
	}
}

function closestParentByClassName( el, clss ){
	while( !hasClass( el, clss ) ){
		el = el.parentNode;
		if( !el ){
			return null;
		}
	}
	return el;
}

function update_post_type( man_hour_fee ){
	var post_types = document.getElementsByClassName( 'post_type' );
	if( post_types ){
		for( var i=0; i < post_types.length; i++ ){
			var pt_checked = post_types[i].getElementsByClassName( 'checkbox checked' );
			sum = 0;
			for( var j=0; j < pt_checked.length; j++ ){
				if( pt_checked[j].getAttribute( 'workforce' ) ){
					workforce = pt_checked[j].getAttribute( 'workforce' );
				}else{
					workforce = 0;
				};
				sum = sum + parseInt( workforce, 10 );
			}
			your_pt_price = post_types[i].getElementsByClassName( 'your_pt_price' )[0];
			your_pt_price.innerHTML = sum * man_hour_fee;
		}
	}
}

function update( man_hour_fee, daily_man_power, checkbox ){
	if( checkbox ){
		var section = closestParentByClassName( checkbox, 'section' );
		if( section ){
			id = checkbox.getAttribute( 'value' );
			children = section.getElementsByClassName( 'children' + id );
			if( children ){
				coselection = section.getElementsByClassName( 'coselection children' + id );
				if( hasClass( checkbox, 'checked' ) ){
					for( var j=0; j < coselection.length; j++ ){
						coselection[j].classList.add( 'checked' );
						coselection[j].classList.remove( 'unchecked' );
					}
				}else{
					for( var j=0; j < children.length; j++ ){
						children[j].classList.add( 'unchecked' );
						children[j].classList.remove( 'checked' );
					}
				}
			}
			var visible = section.getElementsByClassName( 'description visible' )[0];
			exchangeClass( visible, 'hidden', 'visible' );
		}
		var description = checkbox.getElementsByClassName( 'description' )[0];
		exchangeClass( description, 'hidden', 'visible' );
	}
	update_post_type( man_hour_fee );
	var total_price = document.getElementById( 'total_price' );
	var total_time = document.getElementById( 'total_time' );
	var checked = document.getElementsByClassName( 'checkbox checked' );
	var string = '';
	var array = new Array();
	var sum = 0;
	for( var j=0; j < checked.length; j++ ){
		if( !hasClass( checked[j], 'option' ) ) continue;
		if( checked[j].getAttribute( 'workforce' ) ){
			workforce = checked[j].getAttribute( 'workforce' );
		}else{
			workforce = 0;
		};
		array.push( checked[j].value );
		sum = sum + parseInt( workforce, 10 );
	}
	string = array.join( '+' );
	document.getElementsByName( 'string' )[0].setAttribute( 'value', string );
	price = sum * man_hour_fee
	time = Math.ceil( sum / daily_man_power );
	total_price.innerHTML = price;
	total_time.innerHTML = time;
}

function switch_radio( radio ){
	var section = closestParentByClassName( radio, 'section' );
	if( section ){
		var siblings = section.getElementsByClassName( 'radio' );
		if( siblings ){
			for( var j=0; j < siblings.length; j++ ){
				siblings[j].classList.remove( 'checked' );
				siblings[j].classList.add( 'unchecked' );
			}
		}
		var visible = section.getElementsByClassName( 'description visible' )[0];
		exchangeClass( visible, 'hidden', 'visible' );
		radio.classList.remove( 'unchecked' );
		radio.classList.add( 'checked' );
		var hidden = radio.getElementsByClassName( 'description hidden' )[0];
		exchangeClass( hidden, 'hidden', 'visible' );
	}
}

function onload_order(){
	var daily_man_power = document.getElementById( 'daily_man_power' ).value;
	var man_hour_fee = document.getElementById( 'man_hour_fee' ).value;
	var checkboxes = document.getElementsByClassName( 'option checkbox' );
	var post_types = document.getElementsByClassName( 'post_type' );
	update( man_hour_fee, daily_man_power );
	for( var i=0; i < checkboxes.length; i++ ){
		if( hasClass( checkboxes[i], 'started' ) ) continue;
		checkboxes[i].onclick = function(){
			exchangeClass( this, 'checked', 'unchecked' );
			update( man_hour_fee, daily_man_power, this );
		}
	}

	var radios = document.getElementsByClassName( 'option radio' );
	for( var i=0; i < radios.length; i++ ){
		radios[i].onclick = function(){
			switch_radio( this );
			if( this.hasAttribute( 'preselection' ) ){
				preselection_str = this.getAttribute( 'preselection' );
				preselection_array = preselection_str.split( '+' );
				if( preselection_array ){
					for( var j=0; j < checkboxes.length; j++ ){
						if( hasClass( checkboxes[j], 'checked') ){
							checkboxes[j].classList.remove( 'checked' );
							checkboxes[j].classList.add( 'unchecked' );
						}
					}
					for( var j=0; j < preselection_array.length; j++ ){
						preselection = document.getElementById( 'option' + preselection_array[j] )
						preselection.classList.remove( 'unchecked' );
						preselection.classList.add( 'checked' );
					}
				}
			}
			update( man_hour_fee, daily_man_power );
		}
	}
}