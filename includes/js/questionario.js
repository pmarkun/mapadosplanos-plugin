var $ = jQuery;
$(document).ready(function () {
	console.log("uga buga");
	//Etapa
	$("#questionario-tem-plano").hide();
	$("#questionario-plan-em-elaboracao").hide();
	$("#questionario-nao-tem-plano").hide();
	var etapa = $("#etapa input[name='wpcf[qs_etapa01]'][checked='checked']").attr('value');

	if (etapa == 'Sim') {
		$("#questionario-tem-plano").show();
	}
	else if (etapa == 'Elaboração') {
		$("#questionario-plano-em-elaboracao").show();
	}
	else if (etapa == 'Não') {
		$("#questionario-nao-tem-plano").show();
	}

	$("#etapa input[name='wpcf[qs_etapa01]'][value='Sim']").click(function () {
		$("#questionario-tem-plano").show();
		$("#questionario-plano-em-elaboracao").hide();
		$("#questionario-nao-tem-plano").hide();
	})
	$("#etapa input[name='wpcf[qs_etapa01]'][value='Elaboração']").click(function () {
		$("#questionario-tem-plano").hide();
		$("#questionario-plano-em-elaboracao").show();
		$("#questionario-nao-tem-plano").hide();

	})
	$("#etapa input[name='wpcf[qs_etapa01]'][value='Não']").click(function () {
		$("#questionario-tem-plano").hide();
		$("#questionario-plano-em-elaboracao").hide();
		$("#questionario-nao-tem-plano").show();
	})

	//plano em elaboracao qs_plano09
	$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano10-']").hide();
	$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano11-']").hide();

	if ($("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano09]'][value='Sim']").attr("checked") == "checked") {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano10-']").show();
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano11-']").show();
	}

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano09]'][value='Sim']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano10-']").show();
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano11-']").show();
	});

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano09]'][value='Não']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano10-']").hide();
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano11-']").hide();
	});

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano09]'][value='Não sabe']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano10-']").hide();
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano11-']").hide();
	});


	//plano em elaboracao qs_plano12
	$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano13-']").hide();
	$("#questionario-plano-em-elaboracao [id^='wpcf-textfield-qs_plano13_other-']").hide();

	if ($("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano12]'][value='Sim']").attr("checked") == "checked") {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano13-']").show();
		$("#questionario-plano-em-elaboracao [id^='wpcf-textfield-qs_plano13_other-']").show();
	}

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano12]'][value='Sim']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano13-']").show();
		$("#questionario-plano-em-elaboracao [id^='wpcf-textfield-qs_plano13_other-']").show();
	});

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano12]'][value='Não']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano13-']").hide();
		$("#questionario-plano-em-elaboracao [id^='wpcf-textfield-qs_plano13_other-']").hide();	
	});

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano12]'][value='Não sabe']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-checkboxes-qs_plano13-']").hide();
		$("#questionario-plano-em-elaboracao [id^='wpcf-textfield-qs_plano13_other-']").hide();	
	});


	//plano em elaboracao wpcf[qs_plano21]
	
	$("#questionario-plano-em-elaboracao [id^='wpcf-textarea-qs_plano22-']").hide();
	
	if ($("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano21]'][value='Sim, somente de crianças']").attr("checked") == "checked") {
		$("#questionario-plano-em-elaboracao [id^='wpcf-textarea-qs_plano22-']").show();
	}
	if ($("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano21]'][value='Sim, somente de adolescentes']").attr("checked") == "checked") {
		$("#questionario-plano-em-elaboracao [id^='wpcf-textarea-qs_plano22-']").show();
	}
	if ($("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano21]'][value='Sim, dos dois segmentos']").attr("checked") == "checked") {
		$("#questionario-plano-em-elaboracao [id^='wpcf-textarea-qs_plano22-']").show();
	}

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano21]'][value^='Sim']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-textarea-qs_plano22-']").show();
	});

	$("#questionario-plano-em-elaboracao input[name='wpcf[qs_plano21]'][value='Não']").click(function () {
		$("#questionario-plano-em-elaboracao [id^='wpcf-textarea-qs_plano22-']").hide();
	});



	//plano em elaboracao qs_plano09
	$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano10-']").hide();
	$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano11-']").hide();

	if ($("#questionario-tem-plano input[name='wpcf[qs_plano09]'][value='Sim']").attr("checked") == "checked") {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano10-']").show();
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano11-']").show();
	}

	$("#questionario-tem-plano input[name='wpcf[qs_plano09]'][value='Sim']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano10-']").show();
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano11-']").show();
	});

	$("#questionario-tem-plano input[name='wpcf[qs_plano09]'][value='Não']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano10-']").hide();
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano11-']").hide();
	});

	$("#questionario-tem-plano input[name='wpcf[qs_plano09]'][value='Não sabe']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano10-']").hide();
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano11-']").hide();
	});

	//tem plano qs_plano12
	$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano13-']").hide();
	$("#questionario-tem-plano [id^='wpcf-textfield-qs_plano13_other-']").hide();

	if ($("#questionario-tem-plano input[name='wpcf[qs_plano12]'][value='Sim']").attr("checked") == "checked") {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano13-']").show();
		$("#questionario-tem-plano [id^='wpcf-textfield-qs_plano13_other-']").show();
	}

	$("#questionario-tem-plano input[name='wpcf[qs_plano12]'][value='Sim']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano13-']").show();
		$("#questionario-tem-plano [id^='wpcf-textfield-qs_plano13_other-']").show();
	});

	$("#questionario-tem-plano input[name='wpcf[qs_plano12]'][value='Não']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano13-']").hide();
		$("#questionario-tem-plano [id^='wpcf-textfield-qs_plano13_other-']").hide();	
	});

	$("#questionario-tem-plano input[name='wpcf[qs_plano12]'][value='Não sabe']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-checkboxes-qs_plano13-']").hide();
		$("#questionario-tem-plano [id^='wpcf-textfield-qs_plano13_other-']").hide();	
	});


	//plano em elaboracao wpcf[qs_plano21]
	
	$("#questionario-tem-plano [id^='wpcf-textarea-qs_plano22-']").hide();
	
	if ($("#questionario-tem-plano input[name='wpcf[qs_plano21]'][value='Sim, somente de crianças']").attr("checked") == "checked") {
		$("#questionario-tem-plano [id^='wpcf-textarea-qs_plano22-']").show();
	}
	if ($("#questionario-tem-plano input[name='wpcf[qs_plano21]'][value='Sim, somente de adolescentes']").attr("checked") == "checked") {
		$("#questionario-tem-plano [id^='wpcf-textarea-qs_plano22-']").show();
	}
	if ($("#questionario-tem-plano input[name='wpcf[qs_plano21]'][value='Sim, dos dois segmentos']").attr("checked") == "checked") {
		$("#questionario-tem-plano [id^='wpcf-textarea-qs_plano22-']").show();
	}

	$("#questionario-tem-plano input[name='wpcf[qs_plano21]'][value^='Sim']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-textarea-qs_plano22-']").show();
	});

	$("#questionario-tem-plano input[name='wpcf[qs_plano21]'][value='Não']").click(function () {
		$("#questionario-tem-plano [id^='wpcf-textarea-qs_plano22-']").hide();
	});

});