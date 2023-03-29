$("#PhoneInput").mask("+375 (99) 999-99-99");

function ContentMaker(request, zone, mask){
    $.post('./index.php', request).then(function(response){
        document.getElementById(zone).innerHTML = response;
        mask();
    })
}

window.addEventListener('click', function(event){

    if (event.target.name == '0') {
        let request = {
            mode : event.target.closest('.btn-check').name,
            number : event.target.closest('.btn-check').id,
        }
        let mask = () => {$(document).ready(function(){
            var items = $("[id='PhoneInput']");
            items.mask("+375 (99) 999-99-99");
        });}
        ContentMaker(request, 'input', mask);
    };

    if (event.target.name == '1') {
        let request = {
            mode : event.target.closest('.btn-check').name,
            number : event.target.closest('.btn-check').id,
        }
        ContentMaker(request, 'input');
    };

    if (event.target.name == 'pages') {
        let request = {
            page : event.target.closest('.btn-check').id,
        }
        $.post('./index.php', request).then( function(response){
            let content = JSON.parse(response);
            document.getElementById('input').innerHTML = content[0];
            document.getElementById('checkbox').innerHTML = content[1]
        });
    };

    if(event.target.id == 'generate') {
        if(this.document.getElementById('1').name = '0'){
            $(document).ready(function(){
                var items = $("[id='PhoneInput']");
                let data = [];
                for(let el of items){
                    data.push(el.value);
                }
                let request = {
                    'page': 'code',
                    'type': '0',
                    'data': data,
                    'name': document.getElementById('NameInput').value,
                };
                $.post('./index.php', request).then(function(response){
                    document.getElementById('code').innerHTML = response;
                });
            });
        }

        if(this.document.getElementById('1').name = '1'){
            $(document).ready(function(){
                var items = $("[id='EmailInput']");
                let data = [];
                for(let el of items){
                    data.push(el.value);
                }
                let request = {
                    'page': 'code',
                    'type': '1',
                    'data': data,
                    'name': document.getElementById('NameInput').value,
                };
                $.post('./index.php', request).then(function(response){
                    document.getElementById('code').innerHTML = response;
                });
            });
        }
            
    };
});