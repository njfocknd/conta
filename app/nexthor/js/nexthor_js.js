
function ajax_dynamic_div(tipo, ajax_page, params, div_resp, modo)
	{
	if(modo===undefined)
		{
		modo=false;
		}
	$(div_resp).html("<img src='nexthor/image/loading.gif' align='center'>");
	$.ajax({type: tipo,
			url: ajax_page,
			data: params,
			async:false,
			dataType: "html",
			success: function(html){$(div_resp).html(html);}
			}); 
	}
jQuery.ajaxSetup({'beforeSend' : function(xhr) {xhr.overrideMimeType('charset=utf-8'); }});
