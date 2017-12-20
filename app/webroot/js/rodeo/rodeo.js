//valijdación para formato de fecha
jQuery.validator.addMethod("mydate", function(value, element) { 
	return this.optional(element) || /^\d\d?\/\d\d\/\d\d\d\d/.test(value); 
}, "Especifique la fecha en el siguiente formato dd/mm/aaaa. Ej: 31/01/2016");


//*******************
//clase utilizada para manejar los valores de los inputs  que utilizan la librería autoNumeric
var autoNumericManager=function(selector,valorInicial,minValue0,maxValue0){
	var selector=selector;
	var minValue;
	var maxValue;

	if(minValue0==undefined){
		minValue=-999999999.99;
	}else{
		minValue=minValue0;
	}
	if(maxValue0==undefined){
		maxValue=999999999999.99;
	}else{
		maxValue=maxValue0;
	}
	var opcionesMontos = {aSep: '.', aDec: ',', mDec: '0' , mRound: 'A', wEmpty: 'empty', lZero: 'deny',vMin:minValue,vMax:maxValue};
	$(selector).autoNumeric('init',opcionesMontos);
	if(valorInicial!=undefined)
		$(selector).autoNumeric('set',valorInicial);
	return{
		selector:selector,
		read: function(){ number=parseFloat($(selector).autoNumeric('get'));
						if(isNaN(number)){
							return 0;
						}else{
							return number;
						}
						},
		write: function( value){
			if(value>=minValue&&value<=maxValue){
				$(selector).autoNumeric('set',value);
			}
		}
	}
	
};

//Funcion para resetear el autoNumeric antes de hacer el submit del formulario
function resetAutonumeric(formulario){
	//Es importante que la cadena ' input' este con el espacio
	//ya que JQuery necesita para poder buscar correctamente el input
	//del formulario
    $(formulario+' input').each(function(i){
        var self = $(this);
        try{
            var v = self.autoNumeric('get');
            self.autoNumeric('destroy');
            self.val(v);
        }catch(err){
            console.log("Not an autonumeric field: " + self.attr("name"));
        }
    });
}
function mostrarMensaje(tipo, titulo, mensaje){

	switch(tipo){
		case 'success':
			tipo = 'rgba(115, 158, 115,0.85)';
			break;
		case 'error':
			tipo = 'rgba(196, 106, 105, 0.85)';
			break;
		case 'info':
			tipo = 'rgba(50, 118, 177, 0.85)';
			break;
		case 'warning':
			tipo = 'rgba(199, 145, 33, 0.85)';
			break;
	}


	//tipo puede tener los valores "error", "ok"
	$.smallBox({
		title : "<strong>"+titulo+"</strong>",
		content : mensaje,
		sound: false,
		color : tipo,
		iconSmall : "fa fa-exclamation-circle fa-2x fadeInRight animated",
		timeout : 10000
	});	
}


function isValidDate(date){
    var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(date);
    if (matches == null) return false;
    var d = matches[1];
    var m = matches[2] - 1;
    var y = matches[3];
    var composedDate = new Date(y, m, d);
    return composedDate.getDate() == d &&
            composedDate.getMonth() == m &&
            composedDate.getFullYear() == y;
}
