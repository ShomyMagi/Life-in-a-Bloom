$(document).ready(function(){
    var postoji;
    element = document.getElementById('postoji');
    if(element != null)
    {
        postoji = element.value;
    }
    else
    {
        postoji = null;
    }
    $.ajax({
        type: 'GET',
        url: baseUrl + '/ajax/show',
        success: function(data, xhr){
            console.log(data);
            console.log(xhr);
            if(postoji == 0)
            {
                showAnketa(data);
            }
            else
            {
                $('#aboutAnketa').html(prikaziOdgovore());
            }
        }, 
        error: function(xhr, status, error){
                console.log(xhr);
                console.log(status);
                console.log(error);
        }
    });
});

function prikaziOdgovore() {
    $.ajax({
        type: 'GET',
        url: baseUrl + 'ajax/show',
        success : function(podaci){
            var odgHtml = `<label class="form-check-label">`+podaci[0].pitanje+`</label>`;
            $.each(podaci, function(key, value){
                odgHtml +=`<div class="form-check">
                    <label class="form-check-label"> `+value.odgovor+`: </label>
                    <label class="form-check-label"> `+value.br_glasova+`</label>
                </div>`;
            });
            $('#aboutAnketa').html(odgHtml);
        },
        error: function(greske){
                console.log(greske);
        }
    });
}

function showAnketa(data){
    var postsHtml = "";
    postsHtml+=`<form action="" method="">`;
    postsHtml+=`<label class="form-check-label">`+data[0].pitanje+`</label><input type='hidden' value='`+data[0].idAnketa+`' id='idAnketa'></input>`;
    $.each(data, function(key, value){
        postsHtml +=`<div class="form-check">
            <input class="form-check-input" type="radio" name="mojRadio" value="`+value.idOdgovor+`">
            <label class="form-check-label">`+value.odgovor+`</label>
        </div>`;
    });
    postsHtml+=`<div class="form-check">
        <button type="button" class="btn btn-primary btn-sm" onclick="glasanje();">VOTE</button>
    </div>`;
    postsHtml+=`</form>`;
    $('#aboutAnketa').html(postsHtml);
}

function glasanje()
{
    var idUser = document.getElementById('idUser').value;
    var idAnketa = document.getElementById('idAnketa').value;
    var idOdgovor = $('input[name=mojRadio]:checked').val();
    if(document.getElementsByName('mojRadio')[0].checked || document.getElementsByName('mojRadio')[1].checked)
    {
        $.ajax({
            type: 'POST',
            url: baseUrl+'glasovi/insert',
            data: {
                _token: token,
                id_user: idUser,
                id_anketa: idAnketa,
                id_odgovor: idOdgovor
            },
            success: function(data, xhr){
                console.log(data);
                $('#feedback').html('You voted successfully!');
                $('#aboutAnketa').html(prikaziOdgovore());
            },
            error: function(xhr, status, error){
                console.log(error);
                $('#aboutAnketa').html(prikaziOdgovore());
            }
        });
         console.log(baseUrl+'glasovi/insert');
         console.log(token);
         console.log(idAnketa + ' '+ idUser + ' ' + idOdgovor);
    }
    else
    {
        $('#feedback').html('You must choose something!');
    }
    
}