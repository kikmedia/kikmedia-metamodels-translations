
AjaxRequest.togglePublishCheckbox = function(el, id, table)
{
	el.blur();
	var img = null;
	var image = $(el).getFirst('img');
	var publish = (image.src.indexOf('invisible') != -1);
	var div = el.getParent('div');

	// Send request
	new Request({'url':el.href, onSuccess: function() {
		if (publish) {
			image.src = image.src.replace('invisible.gif', 'visible.gif');
		} else {
			image.src = image.src.replace('visible.gif', 'invisible.gif');
		}
	 }}).get();

	return false;
};
