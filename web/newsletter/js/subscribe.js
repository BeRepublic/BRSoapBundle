function create(htmlStr) {
    var frag = document.createDocumentFragment(),
        temp = document.createElement('div');
    temp.innerHTML = htmlStr;
    while (temp.firstChild) {
        frag.appendChild(temp.firstChild);
    }
    return frag;
}


function appSubscribe() {

	var fragment = create('<div><h5>Subscripció: </h5><form><input type="text" name="email"><button>enviar</button></form></div>');
	// You can use native DOM methods to insert the fragment:
	document.body.insertBefore(fragment, document.body.childNodes[0]);

};