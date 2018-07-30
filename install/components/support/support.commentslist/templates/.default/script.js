window.addEventListener('new_comment', function(e) {
    tor = {};
    dd = e.detail.split('#');
    tor['id_ans'] = dd[0];
    tor['id_que'] = dd[1];
    jsAjaxUtil.PostData('/bitrix/components/support/support.commentslist/ajax.php', tor, zPutData.bind(null, e.detail));
});

function randomString(length) {
    var chars="0123456789abcdef";
    var str='';
    for (var i=0; i<length; i++) {
	str+=chars[Math.floor(Math.random() * chars.length)];
    }
    return str;
}

function zPutData(detail, data)
{
dge = document.getElementsByClassName('which_answer');
    dd = detail.split('#');
    tor['id_ans'] = dd[0];
    tor['id_que'] = dd[1];

for (var i=0; i<dge.length; i++) {
    if (dge[i].value == tor['id_ans'])
	{
	hass = "com_"+randomString(32);
	data = data.replace(/com_[a-f0-9]{32}/g,hass);
	dge[i].parentElement.outerHTML = data;	
	}
}

}
