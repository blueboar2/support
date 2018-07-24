function ajax_new_answer(hash)
{
var tosend = new Array();
tosend['name'] = document.getElementById('name_'+hash).value;
tosend['email'] = document.getElementById('email_'+hash).value;
tosend['tarea'] = document.getElementById('tarea_'+hash).value;
tosend['qu'] = document.getElementById('qu_'+hash).value;
tosend['hash'] = hash;
jsAjaxUtil.PostData('/bitrix/components/support/support.answeradd/ajax.php', tosend, aPutData);
}

function aPutData(data)
{

sdata = data.split(':');

dge = document.getElementById('status_'+sdata[1]);
dge.style.display = "block";
dge.style.width = "60%";

if (sdata[0] == "OK")
    {
    dge.innerHTML = "Ваш ответ был добавлен, спасибо!";
    dge.style.background = "lightgreen";
    
    var newans = new CustomEvent("new_answer", { 'detail': sdata[2] } );
    window.dispatchEvent(newans);

    }
    else
    {
    dge.value = "Что-то пошло не так! Возможно вопроса, на который вы хотите ответить не существует, возможно он неактивен, а может быть, к нему нельзя добавлять ответы.";
    dge.style.background = "red";
    }

setTimeout(return_to_none.bind(null, sdata[1]), 5000);
}

function return_to_none(hash)
{
document.getElementById('status_'+hash).style.display = "none";
}
