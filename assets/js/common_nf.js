function ValidateEmail(mail){  
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)){  
			return (true)  
		}  
			alert("You have entered an invalid email address!")  
			return (false)  
	}
function isNormalInteger(str) {
	return /^\+?(0|[1-9]\d*)$/.test(str);
}

function trimAll(sString){
	while (sString.substring(0,1) == ' '){
		sString = sString.substring(1, sString.length);
	}
	while (sString.substring(sString.length-1, sString.length) == ' '){
		sString = sString.substring(0,sString.length-1);
	}
	return sString;
}