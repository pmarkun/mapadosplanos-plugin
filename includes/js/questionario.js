var $ = jQuery;
$(document).ready(function () {
	console.log("uga buga");
	//plano em elaboracao
	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano12]'][value='Sim']").click(function () {
		console.log("click sim");
	});

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano12]'][value='Não']").click(function () {
			console.log("click não");
	});

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano12]'][value='Não sabe']").click(function () {
		$("#wpcf_wrapper_8f399c8c619d8c8447519825b5abc73d-1").hide();
	});

});