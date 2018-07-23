function ajax_new_question(e)
{
var tosend = new Array();
tosend['name'] = document.getElementById('name').value;
tosend['email'] = document.getElementById('email').value;
tosend['tarea'] = document.getElementById('tarea').value;
jsAjaxUtil.PostData('/bitrix/components/support/support.questionadd/ajax.php', tosend, PutData);
}

function PutData(data)
{
dge = document.getElementById('status');

dge.style.display = "block";
dge.style.width = "60%";

if (data == "OK")
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

setTimeout(return_to_none, 5000);
}

function return_to_none()
{
document.getElementById('status').style.display = "none";
}