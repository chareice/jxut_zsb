function $$(id){
	return document.getElementById(id);
}

function set(){
	var $$password = $$("password");
	var $$password_confirm = $$("password_confirm");
	if($$password_confirm.value != $$password.value){
	$$user_password.setCustomValidity("�����������벻һ�£�����������");}
}