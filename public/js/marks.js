$(document).ready(function() {
	//$('#table-data').DataTable()
	$('#table-data').DataTable({
		//'paging'      : true,
		//'lengthChange': false,
		//'searching'   : true,
		//'ordering'    : true,
		//'info'        : true,
		//'autoWidth'   : false
	})
});
$("#table-data tr").css('cursor', 'pointer');

$('#table-data tbody').on('click', 'tr', function () {
	$("#modal-div-loading").show();
	$("#modal-div-form").hide();
	$("#modal-title").html("Editar");
	$("#btn-save").text("Salvar alterações");
	var mark = $(this).find('td').eq(0).text();
	if (mark !== "") {
		$("#modal-default").modal('show');
		$.ajax({
			url: "/marks/get",
			type: "POST",
			data: {name : mark},
			dataType: "json"
		}).done(function(dataReturn) {
			if (!$.isEmptyObject(dataReturn.data)) {
				var data = dataReturn.data[0];
				$("#inp-name").val(data.name);
				if (data.active === "1") {
					$("#chk-active").prop('checked', true);
				} else {
					$("#chk-active").prop('checked', false);
				}
				$("#modal-div-form").show();
			} else {
				if (!$.isEmptyObject(dataReturn.result)) {
					if (dataReturn.result.code === 0) {
						alert("Nenhum dado encontrado!");
					} else {
						alert("Algo deu errado! Contate o suporte! CODE ERROR: "+dataReturn.result.code);
					}
				} else {
					alert("Retorno inesperado!");
				}
			}
			$("#modal-div-loading").hide();
		}).fail(function(jqXHR, textStatus) {
			console.log(jqXHR);
			console.log(textStatus);
		  	alert( "Request failed: " + textStatus );
		});
	} else {
		alert("Valor não encontrado!");
	}
	});

	$("#btn-register").click(function(event) {
		event.preventDefault();
		$("#modal-div-loading").hide();
		$("#modal-title").html("Cadastrar");
	$("#btn-save").text("Salvar");
	$("#inp-name").val("");
	$("#chk-active").prop("checked", false);
		$("#modal-default").modal("show");
	});
