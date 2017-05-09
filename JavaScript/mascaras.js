jQuery(function($){
	$.mask.definitions['h']='[012]';
	$.mask.definitions['m']='[012345]';
	$(".hora").mask("h9:m9");
	$(".placa").mask("aaa-9999");
	$(".data").mask("99/99/9999");
});