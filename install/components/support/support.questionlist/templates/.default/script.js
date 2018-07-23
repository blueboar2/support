window.addEventListener('new_question', function(e) {
    jsAjaxUtil.PostData('/bitrix/components/support/support.questionlist/ajax.php', "", xPutData);
});

function xPutData(data)
{
dge = document.getElementsByClassName('sup_questionlist');

for (var i=0; i<dge.length; i++) {
    dge[i].outerHTML = data;
}

}
