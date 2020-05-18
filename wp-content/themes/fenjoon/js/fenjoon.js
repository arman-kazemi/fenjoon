function onload_enter_submit(){
	var forms = document.getElementsByTagName( 'form' );
	for( var i=0; i < forms.length; i++ ){
		forms[i].onkeydown = function(){
			if( window.event.keyCode == '13' ){
				form_id = this.id;
				fjn_submit( form_id );
			}
		}
	}
}

function hasClass( el, clss ) {
	return el.className && new RegExp( "(^|\\s)" + clss + "(\\s|$)" ).test( el.className );
}

function onload_menubox(){
	menu_box = document.getElementById( 'menu_box' );
	top_menu = document.getElementById( 'top_menu' );
	menu_box.onclick = function(){
		if( hasClass( top_menu, 'mhidden' ) ){
			top_menu.classList.remove( 'mhidden' );
		}else{
			top_menu.classList.add( 'mhidden' );
		}
	}
}

function onload_msg_reporting(){
	var alerts = document.getElementById('alerts');
	if( alerts ){
		var alert = alerts.getElementsByClassName('alert');
		setTimeout( function() {
			var interval = setInterval( function(){
				alerts.removeChild( alert[0] );
				if ( !alert.length ){
					clearInterval( interval )
				}
			}, 3000 );
		}, 5000 );
	}
}

function fjn_submit( form_id ){
	form = document.getElementById( form_id );
	action = form.getAttribute( 'action' );
	action = action.replace( 'submit/', '' );
	form.setAttribute( 'action', action );
	form.submit();
}