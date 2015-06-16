function Ajax(){
	this.params = new String();
	this.headers = null;
	this.callback = null;
	this.xmlHttp = this.getInstance();
}

Ajax.prototype.getInstance = function(){
	return (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
}

Ajax.prototype.setRequestHeader = function(senderHeader){
	this.headers = senderHeader;
}

Ajax.prototype.addHeaders = function(){
	for (i in this.headers){
		this.xmlHttp.setRequestHeader(i, this.headers[i]);
	}
}

Ajax.prototype.addParam = function(name, value){
	this.params += name + '=' + encodeURI(value) + '&';
}

Ajax.prototype.addCallback = function(callback){
	this.callback = callback;
}

Ajax.prototype.parseUrlParams = function(method, url){
	if (method.toUpperCase() != 'POST'){
		url += '?' + this.params;
		this.params = null;
	}
	
	return url;
}

Ajax.prototype.parseResponseProperty = function(){
	if (this.xmlHttp.getResponseHeader('Content-Type') == 'text/xml'){
		return 'XML';
	}
	
	return 'Text';
}

Ajax.prototype.getRequest = function(method, url, asinFlag){
	this.xmlHttp.open(method, this.parseUrlParams(method, url), asinFlag);
	this.addHeaders();
	
	var self = this;
	this.xmlHttp.onreadystatechange = function(){self.getData.call(self)};
	this.xmlHttp.send(this.params);
}

Ajax.prototype.getData = function(){
	if (this.xmlHttp.readyState == 4 && this.xmlHttp.status == 200){
		if (this.callback){
			this.callback.call(this, this.xmlHttp['response' + this.parseResponseProperty()]);
		}
	}
}
