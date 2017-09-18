Notification.requestPermission();
document.addEventListener('load',function(){
	hideClass('inbox');
	hideClass('answer');
	hideClass('help');
	hideClass('done');
	frame(document.getElementById('help'));
});
function frame(elem){
	if(elem=="answero"){
		document.getElementById('answer').setAttribute('data-frame','true');
		document.getElementById('help').setAttribute('data-frame','false');
		rightEmpty("Antworten");
	}else if(elem.getAttribute('data-frame')=="true"){
		elem.setAttribute('data-frame','false');
	}else{
		elem.setAttribute('data-frame','true');
		if(elem.id=='done'){
			document.getElementById('answer').setAttribute('data-frame','true');
			document.getElementById('help').setAttribute('data-frame','false');
			document.getElementById('inbox').setAttribute('data-frame','false');
			document.getElementById('user').setAttribute('data-frame','false');
			leftEmpty("gel&ouml;st");
			rightEmpty("Antworten");
			displayClass('done');
			hideClass("answer");
		}else if(elem.id=='user'){
			document.getElementById('inbox').setAttribute('data-frame','false');
			document.getElementById('done').setAttribute('data-frame','false');
			leftEmpty("Info");
			displayClass('user');
		}else if(elem.id=='answer'||elem.id=='inbox'){
			document.getElementById('answer').setAttribute('data-frame','true');
			document.getElementById('inbox').setAttribute('data-frame','true');
			document.getElementById('inbox').removeAttribute('data-notf');
			document.getElementById('done').setAttribute('data-frame','false');
			document.getElementById('user').setAttribute('data-frame','false');
			document.getElementById('help').setAttribute('data-frame','false');
			hideClass("answer");
			displayClass("inbox");
			leftEmpty("Nachrichten");
			rightEmpty("Antworten");
		}else if(elem.id=='help'){
			document.getElementById('answer').setAttribute('data-frame','false');
			rightEmpty("Hilfe");
			displayClass("help");
		}else if(elem.id=='logout'){
			document.getElementById('inbox').setAttribute('data-frame','false');
			document.getElementById('done').setAttribute('data-frame','false');
			document.getElementById('user').setAttribute('data-frame','false');
			document.getElementById('answer').setAttribute('data-frame','false');
			document.getElementById('help').setAttribute('data-frame','false');
			balert("<p>Du bist schon fertig. Wenn du dein Support-Terminal verlässt, werden dein Quality-Score und alle deine vorgenommenen Einstellungen gelöscht. Bist du sicher, dass du den Support beenden möchtest?</p>"
			+"Wenn nein: Danke für deine freiwillige Teilnahme am TimeTravel™ Dispatcher Project.<br>Wenn ja: Schade, aber danke für deine kurzweilige Unterstützung.<br>"
			+"Wirklich beenden?<br><button onclick=\"logout();\">ja</button>&nbsp;<button onclick=\"deBalert();document.getElementById('logout').setAttribute('data-frame','false');\">nein</button>");
		}
	}
	if(document.getElementById('inbox').getAttribute('data-frame')=='false'){
		hideClass('inbox');
		if(document.getElementById('done').getAttribute('data-frame')=='false'&&document.getElementById('user').getAttribute('data-frame')=='false'){
			leftEmpty("(leer)");
		}
	}
	if(document.getElementById('done').getAttribute('data-frame')=='false'){
		hideClass('done');
	}
	if(document.getElementById('answer').getAttribute('data-frame')=='false'){
		hideClass('answer');
		if(document.getElementById('help').getAttribute('data-frame')=='false'){
			rightEmpty("(leer)");
		}
	}
	if(document.getElementById('help').getAttribute('data-frame')=='false'){
		hideClass("help");
	}
	if(document.getElementById('user').getAttribute('data-frame')=='false'){
		hideClass("user");
	}

}
function balert(string){
	document.getElementById('msg').style.opacity=1;
	document.getElementById('msg').style.display='block';
	document.getElementById('msg').innerHTML=string;
}
function deBalert(){
	document.getElementById('msg').style.opacity=0;
	document.getElementById('msg').style.display='none';
}
function getScore(value){
	score=document.getElementById('score').style.width.replace('%','');
	if(score==''){
		score=0;
	}else{
		score=parseInt(score);
	}
	return score;
}
function scoreAdd(value){
	score=getScore()+value;
	if(score>=100){
		score=100;
		balert("<strong>Danke f&uuml;r deine freiwillige Teilnahme am TimeTravel Dispatcher Project.</strong><br><img src='icons/world.svg' id='endlogo'>"
		+"<p>Dein Quality-Score hat das Ende des Free-Plans erreicht. Du hast das echte Zeug zu einem offiziellen Latein-Supporter in der TimeTravel™ Community.</p>"
		+"<p>Bewirb dich dazu auf unsere Career-Seite, mit deiner Teilnahme-ID.  Achtung: Diese Möglichkeit wird voraussichtlich erst ab Mitte August 2190 zur Verfügung stehen. Wir benachrichtigen dich sobald es die Bewerbungsmöglichkeit in einer Beta-Version gibt.</p>"
		+"<button onclick='logout()'>Speichern und Beenden</button>");
	}
	document.getElementById('score').style.width=score+'%';
	document.getElementById('scorecnt').innerHTML=score+'%';
}
function logout(){
	document.body.style.opacity="0";
	setTimeout(function(){
		window.location.href="index.html";
	},1000);
}
function item(className,elem){
	if(elem.getAttribute('data-frame')=='true'){
		elem.setAttribute('data-frame','false');
	}else{
		elems=document.getElementsByClassName(className);
		for(var i=0;i<elems.length;i++){
			var item=elems[i];
			item.setAttribute('data-frame','false');
			if(className=='answer'){
				item.style.visibility="hidden";
				item.style.opacity=0;
			}
		}
		elem.setAttribute('data-frame','true');
		if(className=='answer'){
			elem.style.visibility="visible";
			elem.style.opacity=1;
		}
	}
}
function selected(className,elem){
	if(elem.getAttribute('data-frame')=='true'){
		hideClass('answer');
	}else{
		document.getElementById('answer').setAttribute('data-frame','true');
		document.getElementById('help').setAttribute('data-frame','false');
		hideClass('help');
	}
	message=elem.getAttribute('data-message');
	msgs=document.querySelectorAll('[data-message=\"'+message+'\"]');
	for(var i=0;i<msgs.length;i++){
		if(msgs[i].classList.contains('inbox')){
			item('inbox',msgs[i]);
		}else if(msgs[i].classList.contains('done')){
			item('done',msgs[i]);
		}else if(msgs[i].classList.contains('answer')){
			item('answer',msgs[i]);
		}
	}
}
function leftEmpty(string){
	var doc=document.getElementById("left");
	nodes=doc.childNodes;
	for(var i=0;i<nodes.length;i++){
		c=nodes[i];
		if(c.className=="empty"){
			c.innerHTML=string;
			break;
		}
	}
}
function rightEmpty(string){
	var doc=document.getElementById("right");
	nodes=doc.childNodes;
	for(var i=0;i<nodes.length;i++){
		c=nodes[i];
		if(c.className=="empty"){
			c.innerHTML=string;
			break;
		}
	}
}
function hideClass(className){
	var divsToHide=document.getElementsByClassName(className);
	for(var i=0;i<divsToHide.length;i++){
		e=divsToHide[i];
		e.style.opacity=0;
		e.style.visibility="hidden";
	}
	if(className=="inbox"){
		setTimeout(function(){
			document.getElementById('containermessage').style.display="none";
		},500);
	}else if(className=="done"){
		setTimeout(function(){
			document.getElementById('containerdone').style.display="none";
		},500);
	}
}
function displayClass(className){
	if(className=="inbox"){
		document.getElementById('containermessage').style.display="block";
	}else if(className=="done"){
		document.getElementById('containerdone').style.display="block";
	}
	var divsToShow=document.getElementsByClassName(className);
	for(var i=0;i<divsToShow.length;i++){
		e=divsToShow[i];
		e.style.opacity=1;
		e.style.visibility="visible";
	}
}
var msgID=0;
var ans=[];
function newMessage(type){
	if(typeof type==="undefined"){
		type='q';
	}
	var xhttp;
	xhttp=new XMLHttpRequest();
	xhttp.onreadystatechange=function() {
		if(this.readyState==4&&this.status==200){
			console.info(xhttp.responseText);
			var jsonObj=JSON.parse(xhttp.responseText);
			elem=document.createElement('div');
			elem.classList.add('msg');
			elem.classList.add('inbox');
			elem.innerHTML="<h3>"+jsonObj.subject+"</h3>"+jsonObj.message;
			elem.setAttribute('data-message',msgID);
			elem.setAttribute('onclick',"selected('inbox',this);");
			document.getElementById('containermessage').appendChild(elem);
			elem=document.createElement('div');
			elem.classList.add('ritem');
			elem.classList.add('answer');
			elem.setAttribute('data-message',msgID);
			sub=document.createElement('div');
			sub.classList.add('keys');
			sub.innerHTML=jsonObj.keys;
			elem.appendChild(sub);
			sub=document.createElement('div');
			sub.classList.add('widget');
			sub.innerHTML=jsonObj.widget.html;
			elem.appendChild(sub);
			sub=document.createElement('div');
			sub.classList.add('message');
			sub.innerHTML="<h3>"+jsonObj.subject+"</h3>"+jsonObj.message;
			elem.appendChild(sub);
			document.getElementById('right').appendChild(elem);
			ans[msgID]={
				answer:jsonObj.answer,
				reply:jsonObj.reply
			};
			msgID++;
			if(document.getElementById('inbox').getAttribute('data-frame')=='true'){
				displayClass('inbox');
			}else{
				document.getElementById('inbox').setAttribute('data-notf','');
			}
			e=new Notification("neue Supportnachricht",{body:"Betreff: "+escapeHtml(jsonObj.subject),
				icon:window.location.toString().replace(/[\\\/][^\\\/]*$/, '')+'/icons/time-passing.png',tag:'newmessage'});
		}
	};
	xhttp.open("GET",window.location.pathname.replace(/[\\\/][^\\\/]*$/, '')+'/data.php?r='+type, true);
	xhttp.send();
}
function check(form){
	widget=form.getAttribute('data-widget');
	if(widget=="eingabe"||widget=="yesno"){
		msg=form.parentNode.parentNode.getAttribute('data-message');
		if(form.answer.value==""){
			console.warn("empty");
		}else if(msg==null){
			return false;
		}else if(ans[msg].answer==form.answer.value){
			deleteMessage(msg);
			setTimeout(function(){
				scoreAdd(Math.floor((Math.random()*10+1)*t));
				insertAnswer(ans[msg].reply.right);
			},1000+Math.floor((Math.random()*100)-50));
		}else{
			deleteMessage(msg);
			setTimeout(function(){
				scoreAdd(Math.floor(((Math.random()*(-10))-1)*t));
				insertAnswer(ans[msg].reply.wrong,msg);
			},1000+Math.floor((Math.random()*100)-50));
		}
	}else if(widget=="leer"){
		deleteMessage(form.parentNode.parentNode.getAttribute('data-message'));
	}
	return false;
}
function insertAnswer(obj,msg){
	elem=document.createElement('div');
	elem.classList.add('msg');
	elem.classList.add('inbox');
	elem.classList.add('ans');
	elem.innerHTML="<h3>"+obj.subject+"</h3>"+obj.message;
	elem.setAttribute('data-message',msg+'r');
	elem.setAttribute('onclick',"selected('inbox',this);");
	document.getElementById('containermessage').appendChild(elem);
	elem=document.createElement('div');
	elem.classList.add('ritem');
	elem.classList.add('answer');
	elem.setAttribute('data-message',msg+'r');
	sub=document.createElement('div');
	sub.classList.add('keys');
	sub.innerHTML=obj.keys;
	elem.appendChild(sub);
	sub=document.createElement('div');
	sub.classList.add('widget');
	sub.innerHTML="<form onsubmit=\"return check(this);\" data-widget=\"leer\"><input type=\"submit\" name=\"submit\" value=\"entfernen\"/></form>";
	elem.appendChild(sub);
	sub=document.createElement('div');
	sub.classList.add('message');
	sub.innerHTML="<h3>"+obj.subject+"</h3>"+obj.message;
	elem.appendChild(sub);
	document.getElementById('right').appendChild(elem);
	if(document.getElementById('inbox').getAttribute('data-frame')=='true'){
		displayClass('inbox');
	}else{
		document.getElementById('inbox').setAttribute('data-notf','');
	}
}
function deleteMessage(msg){
	del=document.querySelectorAll("[data-message=\""+msg+"\"]");
	for(var i=0;i<del.length;i++){
		del[i].style.opacity=0;
		del[i].style.visibility="hidden";
		del[i].setAttribute("data-frame","false");
		if(del[i].classList.contains('inbox')){
			document.getElementById('containerdone').appendChild(del[i]);
			del[i].classList.remove('inbox');
			del[i].classList.add('done');
			del[i].setAttribute("onclick","selected('done',this);");
		}else if(del[i].classList.contains('answer')){
			f=del[i].getElementsByTagName('form')[0];
			f.removeAttribute('data-message');
			try{
				f.submit.remove();
			}catch(err){

			}
			elem=f.getElementsByTagName('input');
			for(var fi=0;fi<elem.length;fi++){
				elem[fi].setAttribute('disabled','off');
			}
		}
	}
}
function escapeHtml(html){
	var e=document.createElement('div');
	e.innerHTML=html;
	return e.childNodes.length===0?"":e.childNodes[0].nodeValue;
}
(function loop(){
	setTimeout(function(){
		newMessage();
		if(getScore()<100){
			loop();
		}
	},Math.round(Math.random()*40000)+1000);
}());
