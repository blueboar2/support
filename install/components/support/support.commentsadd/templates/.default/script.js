function ajax_new_comment(hash)
{
var tosend = new Array();
tosend['name'] = document.getElementById('name_'+hash).value;
tosend['email'] = document.getElementById('email_'+hash).value;
tosend['tarea'] = document.getElementById('tarea_'+hash).value;
tosend['qu'] = document.getElementById('qu_'+hash).value;
tosend['an'] = document.getElementById('an_'+hash).value;
tosend['hash'] = hash;
jsAjaxUtil.PostData('/bitrix/components/support/support.commentsadd/ajax.php', tosend, bPutData);
}

function bPutData(data)
{

sdata = data.split(':');

dge = document.getElementById('status_'+sdata[1]);
dge.style.display = "block";
dge.style.width = "60%";

if (sdata[0] == "OK")
    {
    dge.innerHTML = "Ваш комментарий был добавлен, спасибо!";
    dge.style.background = "lightgreen";
    
    var newans = new CustomEvent("new_comment", { 'detail': sdata[2] } );
    window.dispatchEvent(newans);

    }
    else
    {
    dge.value = "Что-то пошло не так! Возможно ответа, к которому вы хотите добавить комментарий не существует, возможно вопрос неактивен, а может быть, к нему нельзя добавлять ответы и комментарии.";
    dge.style.background = "red";
    }

setTimeout(return_to_none.bind(null, sdata[1]), 5000);
}

function return_to_none(hash)
{
document.getElementById('status_'+hash).style.display = "none";
}
