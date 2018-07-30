window.addEventListener('new_answer', function(e) {
    tor = {};
    tor['id'] = e.detail;
    jsAjaxUtil.PostData('/bitrix/components/support/support.answerlist/ajax.php', tor, yPutData.bind(null, e.detail));
});

function randomString(length) {
    var chars="0123456789abcdef";
    var str='';
    for (var i=0; i<length; i++) {
	str+=chars[Math.floor(Math.random() * chars.length)];
    }
    return str;
}

function yPutData(detail, data)
{
dge = document.getElementsByClassName('which_question');

for (var i=0; i<dge.length; i++) {
    if (dge[i].value == detail)
	{
	hass = "ans_"+randomString(32);
	data = data.replace(/ans_[a-f0-9]{32}/g,hass);
	dge[i].parentElement.outerHTML = data;	
	}
}

}
