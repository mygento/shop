document.observe('dom:loaded', changetoplink);


var showlogin = false;
var showcreate = false;
var showloginerreur = false;
var showcreateerreur = false;
var showload = false;
var showmessage = false;
var showforgot = false;
var showforgoterreur = false;
var url_de_base = '';

var G_AJAX_allow = 0;
var G_AJAX_alloweffect = 0;
var G_AJAX_vitesseeffect = 0;
var duree_sec = 5;

function stringsize(a)
{
	i = 0;
	
	i = a.toString().length;
	/*while(a[i])
	{
		i++; 
		if(i > 100) return 0;
	}*/
	
	return i;
}

function compteurajaxlogin()
{
    compteur_ajaxlogin_div=document.getElementById('compteur_ajaxlogin_div');
    sec=duree_sec;
    if(sec<=0)
    {
		showmessage = true;
		affichage_divmessage();
    }
    else
    {
        compteur_ajaxlogin_div.innerHTML="<span style='color:grey;'>"+sec+"sec</span>";
    }
    duree_sec=duree_sec-1;
    window.setTimeout("compteurajaxlogin()",999);
}

function changetoplink()
{


	try{
		G_AJAX_allow = $('ajax_login_base_url').readAttribute('allow_ajaxlogin');
		G_AJAX_alloweffect = $('ajax_login_base_url').readAttribute('allow_effect');
		G_AJAX_vitesseeffect = $('ajax_login_base_url').readAttribute('vitesse_effect');
		
		/*if(G_AJAX_allow == 1)
		{
			a = $$("a[title='Log In']")[0];
			a.href = '#';
			a.writeAttribute('onClick', 'affichage_divlogin();');
		}*/
		
		showlogin = false;
		showcreate = false;
		showloginerreur = false;
		showcreateerreur = false;
		showload = false;
		showmessage = false;
		showforgot = false;
		showforgoterreur = false;
		
		url_de_base = $('ajax_login_base_url').readAttribute('base_url');
    }catch(e){}
}

function testemail(a) 
{
	if((a.indexOf('@',0)==-1) || (a.indexOf('.',0)==-1)) 
		return true;
	else
		return false;
}

function affichage_divlogin()
{
	if(showlogin)
	{
		ajaxloginfadeout("divajaxlogin");
		showlogin = false;
	}
	else
	{
		showlogin = true;
		ajaxloginfadein("divajaxlogin");
	}
}

function close_divlogin()
{
	if(showlogin)
	{
		ajaxloginfadeout("divajaxlogin");
		showlogin = false;
	}
}

function affichage_divcreate()
{
	if(showcreate)
	{
		ajaxloginfadeout("divajaxcreate");
		showcreate = false;
	}
	else
	{
		showcreate = true;
		ajaxloginfadein("divajaxcreate");
	}
}

function close_divcreate()
{
	if(showcreate)
	{
		ajaxloginfadeout("divajaxcreate");
		showcreate = false;
	}
}

function affichage_divforgot()
{
	if(showforgot)
	{
		ajaxloginfadeout("divajaxforgot"); 
		showforgot = false;
	}
	else
	{
		showforgot = true;
		ajaxloginfadein("divajaxforgot");
	}
}

function close_divforgot()
{
	if(showforgot)
	{
		ajaxloginfadeout("divajaxforgot"); 
		showforgot = false;
	}
}

function affichage_divforgoterreur()
{
	if(showforgoterreur){$("divajaxforgoterreur").hide(); showforgoterreur = false;}
	else{$("divajaxforgoterreur").show(); showforgoterreur = true;}
}

function affichage_divloginerreur()
{
	if(showloginerreur){$("divajaxloginerreur").hide(); showloginerreur = false;}
	else{$("divajaxloginerreur").show(); showloginerreur = true;}
}

function affichage_divcreateerreur()
{
	if(showcreateerreur){$("divajaxcreateerreur").hide(); showcreateerreur = false;}
	else{$("divajaxcreateerreur").show(); showcreateerreur = true;}
}

function affichage_divload()
{
	if(showload)
	{
		ajaxloginfadeout("divajaxload"); 
		showload = false;
	}
	else
	{
		showload = true;
		ajaxloginfadein("divajaxload");
	}
}

function affichage_divmessage()
{
	if(showmessage)
	{
		ajaxloginfadeout("divajaxmessage"); 
		showmessage = false;
	}
	else
	{
		showmessage = true;
		ajaxloginfadein("divajaxmessage");
	}
}

function affichage_div()
{
	affichage_divlogin();
	affichage_divcreate();
	affichage_divloginerreur();
	affichage_divcreateerreur();
	affichage_divload();
	affichage_divmessage();
	affichage_divforgot();
	affichage_divforgoterreur();
}

function ajaxloginfadeout(id)
{
	if(G_AJAX_alloweffect == 1)
	{
		Effect.Fade(id, {afterFinish:function(){
		$(id).hide();
		},duration:1.0, from:1.0, to:0.0});
	}
	else
	{
		$(id).hide();
	}
} 

function ajaxloginfadein(id)
{
	if(G_AJAX_alloweffect == 1)
	{
		Effect.Appear(id, {duration:0.5, from:0.0, to:1.0});
	}
} 

function ajaxlogin()
{
	pass__ = $("ajaxpass").value;
	email__ = $("ajaxemail").value;

	if(testemail(email__))
	{
		message_erreur = 'Неправильная эл. почта.<br>'; test1 = true;
		/* Invalid email address */
		
		showlogin = false;
		showcreate = true;
		showloginerreur = false;
		showcreateerreur = true;
		showload = true;
		showmessage = true;
		showforgot = true;
		showforgoterreur = true;					
		
		affichage_div();

		$('divajaxloginerreur').update(message_erreur);
		
		return 0;	
	}

	showload = false;
	affichage_divload();
	
	showlogin = true;
	affichage_divlogin();
	
	url_ajax = url_de_base+"customer/account/loginPost/";
	new Ajax.Request(url_ajax, {
		method: 'post',
  		parameters: {'login[password]': pass__, 'login[username]': email__},
   		onSuccess: function(transport){
   		
   			 if(transport.responseText.match('<ajaxlogintag tag="4"/>'))
   			 {
				showlogin = true;
				showcreate = true;
				showloginerreur = true;
				showcreateerreur = true;
				showload = true;
				showmessage = false;
				showforgot = true;
				showforgoterreur = true;
				
				affichage_div();

				/*a = $$("a[title=Log In]")[0];
				a.href = url_de_base+'customer/account/logout/';
				a.title = 'Log Out';
				a.update('Log Out');
				a.writeAttribute('onClick', '');
				$('icon_user').show();
				$('login').hide();

				$('divajaxmessage').update('<div onclick="affichage_divmessage();" class="ajaxlogin-quit-buttun" style="float:right;" title="Quit"></div>'
				+'You\'re logged'
				+'<div id="compteur_ajaxlogin_div"></div>');
				duree_sec = 3;
				compteurajaxlogin();*/
				setTimeout("window.location.reload()",0);
   			 }
   			 else
   			 {
				showlogin = false;
				showcreate = true;
				showloginerreur = false;
				showcreateerreur = true;
				showload = true;
				showmessage = true;
				showforgot = true;
				showforgoterreur = true;				
				
				affichage_div();
				
				message_erreur = 'Неправильные введенные данные.<br>';
				/* Invalid login or password */

				$('divajaxcreateerreur').update(message_erreur);
   			 }
    }
    });
}

function ajaxcreate()
{
	password__ = $("ajaxpassword").value;				password_empty = false;
	confirmation__ = $("ajaxconfirmation").value;		confirmation_empty = false;
	is_subscribed__ = $("ajaxis_subscribed").value;
	email__ = $("ajaxemail_address").value;				email_empty = false;
	lastname__ = $("ajaxlastname").value;				lastname__empty = false;
	firstname__ = $("ajaxfirstname").value;				firstname_empty = false;
	
	if(password__ == '') password_empty = true;
	if(confirmation__ == '') confirmation_empty = true;
	if(email__ == '') email_empty = true;
	if(lastname__ == '') lastname__empty = true;
	if(firstname__ == '') firstname_empty = true;
	
	if(password_empty || 
	confirmation_empty || 
	email_empty || 
	lastname__empty || 
	firstname_empty)
	{
		showlogin = true;
		showcreate = false;
		showloginerreur = true;
		showcreateerreur = false;
		showload = true;
		showmessage = true;
		showforgot = true;
		showforgoterreur = true;				
		
		affichage_div();
	
		$("ajaxpassword").writeAttribute('style', 'border:1px solid grey;');
		$("ajaxconfirmation").writeAttribute('style', 'border:1px solid grey;');
		$("ajaxemail_address").writeAttribute('style', 'border:1px solid grey;');
		$("ajaxlastname").writeAttribute('style', 'border:1px solid grey;');
		$("ajaxfirstname").writeAttribute('style', 'border:1px solid grey;');	
		
		if(password_empty) $("ajaxpassword").writeAttribute('style', 'border:1px solid red;');
		if(confirmation_empty) $("ajaxconfirmation").writeAttribute('style', 'border:1px solid red;');
		if(email_empty) $("ajaxemail_address").writeAttribute('style', 'border:1px solid red;');
		if(lastname__empty) $("ajaxlastname").writeAttribute('style', 'border:1px solid red;');
		if(firstname_empty) $("ajaxfirstname").writeAttribute('style', 'border:1px solid red;');

		return false;
	}
	
	message_erreur = ''; test1 = false; test2 = false;
	if(password__ != confirmation__)
	{
		message_erreur = message_erreur + 'Проверьте Ваш пароль <br>'; test1 = true;
		/* Please make sure your passwords match. */
		showlogin = true;
		showcreate = false;
		showloginerreur = true;
		showcreateerreur = false;
		showload = true;
		showmessage = true;
		showforgot = true;
		showforgoterreur = true;				
		
		affichage_div();

		$('divajaxcreateerreur').update(message_erreur);
		
		return 0;		
	}
	
	if(testemail(email__))
	{
		message_erreur = message_erreur + 'Неправильная эл. почта..<br>'; test1 = true;
		/* Invalid email address */
		showlogin = true;
		showcreate = false;
		showloginerreur = true;
		showcreateerreur = false;
		showload = true;
		showmessage = true;
		showforgot = true;
		showforgoterreur = true;				
		
		affichage_div();

		$('divajaxcreateerreur').update(message_erreur);
		
		return 0;	
	}
	
	if(stringsize(password__) < 6)
	{
		message_erreur = message_erreur + 'Пароль должен быть не менее 6 символов<br>'; test2 = true;
		/* Password minimal length must be more 6 */
		showlogin = true;
		showcreate = false;
		showloginerreur = true;
		showcreateerreur = false;
		showload = true;
		showmessage = true;
		showforgot = true;
		showforgoterreur = true;				
		
		affichage_div();

		$('divajaxcreateerreur').update(message_erreur);
		
		return 0;		
	}
	
	showload = false;
	affichage_divload();
	
	showcreate = true;
	affichage_divcreate();
	
	url_ajax = url_de_base+"customer/account/createpost/";
	new Ajax.Request(url_ajax, {
		method: 'post',
  		parameters: {'password': password__, 'confirmation': confirmation__, 'is_subscribed': is_subscribed__, 'email': email__, 'lastname': lastname__, 'firstname': firstname__},
   		onSuccess: function(transport){
   			 if(transport.responseText.match('<ajaxlogintag tag="4"/>'))
   			 {
				showlogin = true;
				showcreate = true;
				showloginerreur = true;
				showcreateerreur = true;
				showload = true;
				showmessage = false;
				showforgot = true;
				showforgoterreur = true;				
				
				affichage_div();

				/*a = $$("a[title=Log In]")[0];
				a.href = url_de_base+'customer/account/logout/';
				a.title = 'Log Out';
				a.update('Log Out');
				a.writeAttribute('onClick', '');*/
				
				$('divajaxmessage').update('<div onclick="affichage_divmessage();" class="ajaxlogin-quit-buttun" style="float:right;" title="Quit"></div>'
				+'Спасибо за регистрацию<br>'
				+'Вы можете перейти в <a href="'+url_de_base+'customer/account/">Мой кабинет</a>.'				
				+'<div id="compteur_ajaxlogin_div"></div>');
				compteurajaxlogin();
				setTimeout("window.location.reload()",0);
				/* +'Thank you for registering<br>'
				+'You can go to your <a href="'+url_de_base+'customer/account/">Dashboard</a>.'	*/
				
   			 }
   			 else
   			 {
				showlogin = true;
				showcreate = false;
				showloginerreur = true;
				showcreateerreur = false;
				showload = true;
				showmessage = true;
				showforgot = true;
				showforgoterreur = true;				
				
				affichage_div();
				

				message_erreur = message_erreur + 'Указанная эл. почта уже используется<br>';
				/* Customer email already exists */

				
				$('divajaxcreateerreur').update(message_erreur);
   			 }
    }
    });
}


function ajaxforgot()
{
	email__ = $("ajaxemail_address_forgot").value;				email_empty = false;

	if(email__ == '') email_empty = true;
	
	if(email_empty)
	{
		showlogin = true;
		showcreate = true;
		showloginerreur = true;
		showcreateerreur = false;
		showload = true;
		showmessage = true;
		showforgot = false;
		showforgoterreur = false;				
		
		affichage_div();
		
		if(email_empty) $("ajaxemail_address_forgot").writeAttribute('style', 'border:1px solid red;');
		
		return false;
	}

	if(testemail(email__))
	{
		message_erreur = 'Неправильная эл. почта.<br>'; test1 = true;
		
		/* Invalid email address. */
		
		showlogin = true;
		showcreate = true;
		showloginerreur = true;
		showcreateerreur = true;
		showload = true;
		showmessage = true;
		showforgot = false;
		showforgoterreur = false;					
		
		affichage_div();

		$('divajaxforgoterreur').update(message_erreur);
		
		return 0;	
	}

	showload = false;
	affichage_divload();
	
	showcreate = true;
	affichage_divforgot();
	
	url_ajax = url_de_base+"customer/account/forgotpasswordpost/";	
	new Ajax.Request(url_ajax, {
		method: 'post',
  		parameters: {'email': email__},
   		onSuccess: function(transport){

// ITEAMO . LOGIN FORM CORRECTION <<< 
   			 // if(transport.responseText.match('<ajaxlogintag tag="5"/>'))
   			 if(transport.responseText.match('success-msg'))
// >>> ITEAMO . LOGIN FORM CORRECTION   			 
   			 {

   		// ITEAMO . TEST <<<
       // alert('YES' + transport.responseText);
      // >>> ITEAMO . TEST
   			 
				showlogin = true;
				showcreate = true;
				showloginerreur = true;
				showcreateerreur = true;
				showload = true;
				showmessage = false;
				showforgot = true;
				showforgoterreur = true;				

				affichage_div();

				$('divajaxmessage').update('<div onclick="affichage_divmessage();" class="ajaxlogin-quit-buttun" style="float:right;" title="Quit"></div>'
				+'Новый пароль отправлен'				
				+'<div id="compteur_ajaxlogin_div"></div>');
				duree_sec = 5;
				compteurajaxlogin();
				/* +'A new password was sent'	*/
   			 }
   			 else
   			 {
				showlogin = true;
				showcreate = true;
				showloginerreur = true;
				showcreateerreur = true;
				showload = true;
				showmessage = true;
				showforgot = false;
				showforgoterreur = false;				
				
				affichage_div();
   		// ITEAMO . TEST <<<
       // alert('NONO' + transport.responseText);
      // >>> ITEAMO . TEST

				
				// ITEAMO . LOGIN FORM CORRECTION <<< 
          $('divajaxforgoterreur').update('Указанная эл. почта не зарегистрирована!');
        // >>> ITEAMO . LOGIN FORM CORRECTION
         
				/* Customer email already exists */
   			 }
    }
    });
}
