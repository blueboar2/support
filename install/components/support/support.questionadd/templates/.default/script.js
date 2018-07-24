function ajax_new_question(hash)
{
var tosend = new Array();
tosend['name'] = document.getElementById('name_'+hash).value;
tosend['email'] = document.getElementById('email_'+hash).value;
tosend['tarea'] = document.getElementById('tarea_'+hash).value;
tosend['hash'] = hash;
jsAjaxUtil.PostData('/bitrix/components/support/support.questionadd/ajax.php', tosend, PutData);
}

function PutData(data)
{


sdata = data.split(':');

dge = document.getElementById('status_'+sdata[1]);
dge.style.display = "block";
dge.style.width = "60%";

if (sdata[0] == "OK")
    {
    dge.innerHTML = "Ваш вопрос был добавлен, спасибо!";
    dge.style.background = "lightgreen";
    
    var newques = new CustomEvent("new_question");
    window.dispatchEvent(newques);

    }
    else
    {
    dge.value = "Что-то пошло не так!";
    dge.style.background = "red";
    }

setTimeout(return_to_none.bind(null, sdata[1]), 5000);
}

function return_to_none(hash)
{
document.getElementById('status_'+hash).style.display = "none";
}
