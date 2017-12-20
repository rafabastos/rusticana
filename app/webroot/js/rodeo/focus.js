/*
Al ser mostrado un modal  se pone en foco el primero 'input' que tiene;
*/



$('.modal').on('shown.bs.modal', function (e) {//cuando se muestra algún modal
	$(this).children().find('input[type!=hidden]:first').focus();
	});