jQuery(document).ready(function () {
    
    jQuery(document).on('loaded', '#product-tab-content-ModuleProductpersonalisation', function(){
		if (jQuery("#product-tab-content-ModuleProductpersonalisation").is(":visible") == true) {
			jQuery('.imgareaselect-outer').show();
			jQuery('.imgareaselect-selection').parent().show();
			jQuery('.imgareaselect-handle').parent().show();
			var imghArea = setImgArea();
		}
		else
		{
			jQuery('.imgareaselect-outer').hide();
			jQuery('.imgareaselect-selection').parent().hide();
			jQuery('.imgareaselect-handle').parent().hide();
		}
	});

	jQuery(document).on('click', '.list-group-item',  function(){
		if(jQuery(this).attr('id') == 'link-ModuleProductpersonalisation')
		{
			jQuery('.imgareaselect-outer').show();
			jQuery('.imgareaselect-selection').parent().show();
			jQuery('.imgareaselect-handle').parent().show();
			setImgArea();
		}
		else
		{
			jQuery('.imgareaselect-outer').hide();
			jQuery('.imgareaselect-selection').parent().hide();
			jQuery('.imgareaselect-handle').parent().hide();
		}
	});
	
	setImgArea();
	
	jQuery(document).on('click', '#aspectRatioButton',  function(){
		if(jQuery('#aspectRatio').val() != '')
		{
			setImgArea();
			showSuccessMessage('Aspect Ratio has been applied successfully. Please save the product after selecting the area.');
		}
	});

/*$("#link-ModuleCustomizedarea").click(function(){

     $.ajax({
				type: 'POST',
				headers: { "cache-control": "no-cache" },
				url: 'http://localhost:8080/makeshop/modules/customizedarea/ajax.php' + '?product_id='+productId+'&rand=' + new Date().getTime(),
				async: true,
				cache: false,
                                success: function(jsonData){
				
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                            }
				
			});
        
        return false;
    
    
});
*/

});
function preview(img, selection,_8) {
	if (!selection.width || !selection.height)
        return;
    
    var scaleX = 100 / selection.width;
    var scaleY = 100 / selection.height;

    jQuery('#preview img').css({
        width: Math.round(scaleX * 300),
        height: Math.round(scaleY * 300),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1)
    });
	
	// var w = selection.width;
	// var h = selection.height;
	// var r = gcd (w, h);
	// var aspect = (w/r)+":"+(h/r);
	
    _8.parents('#tabb').find('#x1').val(selection.x1);
    _8.parents('#tabb').find('#y1').val(selection.y1);
    _8.parents('#tabb').find('#x2').val(selection.x2);
    _8.parents('#tabb').find('#y2').val(selection.y2);
    _8.parents('#tabb').find('#w').val(selection.width);
    _8.parents('#tabb').find('#h').val(selection.height);
	//jQuery('#aspectRatio').val(aspect);    
}

function setImgArea(){
	
	productId = $('#id_product').val();
	lth = $('.product-tab #tabb').length;

	var options = {},x=0;
	options.fadeSpeed = 200;
	options.handles = true;
	options.onSelectChange = preview;
	for (x = 0; x < lth; x++) {
		options.aspectRatio = $('.tab_'+x).find('#aspectRatio').val();
		if(customized_area != undefined)
		{
			if(customized_area.customised_values != undefined && customized_area.customised_values.length > 0);
			{
					options.x1 = $('.tab_'+x).find('#x1').val();
					options.y1 = $('.tab_'+x).find('#y1').val();
					options.x2 = $('.tab_'+x).find('#x2').val();
					options.y2 = $('.tab_'+x).find('#y2').val();
			}
		}
		jQuery('img.photo_'+x).imgAreaSelect(options);
	};
	
}

function gcd (a, b) {
	return (b == 0) ? a : gcd (b, a%b);
}

function addNewSection()
{
	var x , current = $('.product-tab #tabb').length, p = current-1;
	if(!$('.tab_'+p).length )
		alert('Please refresh the page!');
	x = changeValues($('#tabb').clone(),current);
	x.insertAfter($('.tab_'+p));
	$('<hr>').insertAfter($('.tab_'+p));
	jQuery('.imgareaselect-outer').show();
	jQuery('.imgareaselect-selection').parent().show();
	jQuery('.imgareaselect-handle').parent().show();
	var imghArea = setImgArea();
	$('.tab_' + current + ' .imgchange').each(function(){
        $(this).on({
            'click': function(){
                $(this).parents('#tabb').find('#photo').attr('src', $(this).parent().find('img').attr('src'));
                $(window).resize();
            }
        });
    });
    $('input[name="total_custom_tabs"]').val(current+1);
	return false;
}

function changeValues(x,current)
{
	x.attr('class','tab_'+current);
	x.find('.imgchange').each(function(){
		$(this).attr('name',"id_image_"+current);
	});
	x.find('#photo').attr('class','photo_'+current);
	x.find('#deleteTab').attr('data-val',current);
	x.find('#x1').attr('name','p_x1_'+current);
	x.find('#w').attr('name','p_width_'+current);
	x.find('select#customization_type').attr('name','customization_type_'+current);
	x.find('input#placeholder').attr('name','placeholder_'+current);
	x.find('input#character_limit').attr('name','character_limit_'+current);
	x.find('#y1').attr('name','p_y1_'+current);
	x.find('#h').attr('name','p_height_'+current);
	x.find('#x2').attr('name','p_x2_'+current);
	x.find('#aspectRatio').attr('name','p_aspectRatio_'+current);
	x.find('#y2').attr('name','p_y2_'+current);
	return x;
}

function removeThisTab(tthis)
{
	var x = $('.imgareaselect-selection').eq(tthis.data('val')).parent('div');
	for (var i = 0; i <= 3; i++) {
		x.next('.imgareaselect-outer').remove();
	}
	x.remove();
	var tab = tthis.parents('#tabb');
	tab.prev('hr').remove();
	tab.remove();
	var tabs = $('.product-tab #tabb'), lth = tabs.length,c = 0;
	tabs.each(function(){
		changeValues($(this),c);
		c++;
	});
	$('input[name="total_custom_tabs"]').val(c);
	jQuery('.imgareaselect-outer').show();
	jQuery('.imgareaselect-selection').parent().show();
	jQuery('.imgareaselect-handle').parent().show();
	var imghArea = setImgArea();
}

function toggleOtherFields(tthis)
{
	console.log(tthis);
	var id = tthis.val(), par = tthis.parents('#tabb'),plac = par.find('#placeholder').parent().parent(), char = par.find('#character_limit').parent().parent();
	if(id > 0) {
		plac.removeClass('hidden');
		if(id = 2)
			char.removeClass('hidden');
	} else {
		plac.addClass('hidden');
	}

}

