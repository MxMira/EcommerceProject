var counter = 0;
function addcontact() {
    counter++;
    var select = document.createElement('select');
    select.id = "contact" + counter;
    select.name = "contact" + counter;
    select.className = "form-control";
    select.addEventListener('change',function(){
        var id = this.id;
        var e = document.getElementById(id);
        var strUser = e.options[e.selectedIndex].value;
        checkType(strUser,counter);
    });
    var options = ['address', 'phone', 'mobile'];
    options.forEach(function (type) {
        var option = document.createElement('option');
        option.value = type;
        option.text = type;
        select.appendChild(option)
    });
    var div = document.getElementById('contact');
    div.appendChild(select);
    var input = document.createElement('input');
    input.type = 'text';
    input.id = 'input'+counter;
    input.name = 'input'+counter;
    input.className = 'form-control';
    input.placeholder = 'Address';
    div.appendChild(input);
    var p = document.createElement('p');
    p.id = 'p'+counter;
    p.name = 'p'+counter;
    p.className = 'mt-5 mb-3 text-muted';
    p.innerHTML ='remove contact ';
    p.addEventListener('click',function(){
        delelement(counter);
    });
    var span = document.createElement('span');
    span.className = 'glyphicon glyphicon-minus-sign';
    p.appendChild(span);
    div.appendChild(p);

}

function checkType(type,id){
    if(type == 'address'){
        var input = document.getElementById('input'+id);
        input.type = 'text';
        input.placeholder = 'Address';
    }else if(type == 'phone'){
        var input = document.getElementById('input'+id);
        input.type = 'number';
        input.placeholder = 'Phone';
    }else{
        var input = document.getElementById('input'+id);
        input.type = 'number';
        input.placeholder = 'Mobile';
    }
}

function delelement(id){
    console.log(id);
    var select = document.getElementById('contact'+id);
    select.remove();
    var input = document.getElementById('input'+id);
    input.remove();
    var p = document.getElementById('p'+id);
    p.remove();
}

