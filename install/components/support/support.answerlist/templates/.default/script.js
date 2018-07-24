window.addEventListener('new_answer', function(e) {
    tor = {};
    tor['id'] = e.detail;
    jsAjaxUtil.PostData('/bitrix/components/support/support.answerlist/ajax.php', tor, yPutData.bind(null, e.detail));
});

function yPutData(detail, data)
{
dge = document.getElementsByClassName('which_question');

for (var i=0; i<dge.length; i++) {
    if (dge[i].value == detail)
	{
	
	dge[i].parentElement.outerHTML = data;	
	}
}

}
