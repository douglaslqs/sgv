$('#table-data').DataTable({
	//'paging'      : true,
	//'lengthChange': false,
	//'searching'   : true,
	//'ordering'    : true,
	//'info'        : true,
	//'autoWidth'   : false
});
$("#table-data tr").css('cursor', 'pointer');

var current_mark;
$('#table-data tbody').on('click', 'tr', function () {
	$("#modal-load").modal('show');
	$("#modal-title").html("Editar");
	$("#form-data").attr('operation', 'update');
	$("#btn-save").text("Salvar alterações");
	var mark = $(this).find('td').eq(0).text();
	if (mark !== "") {
		$("#modal-default").modal('show');
		$.ajax({
			url: "marks/get",
			type: "POST",
			data: {name : mark},
			dataType: "json"
		}).done(function(dataReturn) {
			if (!$.isEmptyObject(dataReturn.data)) {
				var data = dataReturn.data[0];
				$("#inp-name").val(data.name);
				current_mark = data.name;
				if (data.active === "1") {
					$("#chk-active").prop('checked', true);
				} else {
					$("#chk-active").prop('checked', false);
				}
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
			$("#modal-load").modal('hide');
		}).fail(function(jqXHR, textStatus) {
			console.log(jqXHR);
			console.log(textStatus);
			$("#modal-load").modal('hide');
		  	alert( "Request failed: " + textStatus );
		});
	} else {
		$("#modal-load").modal('hide');
		alert("Valor não encontrado!");
	}
});

$("#btn-register").click(function(e) {
	e.preventDefault();
	$("#modal-title").html("Cadastrar");
	$("#form-data").attr('operation', 'add');
	$("#btn-save").text("Salvar");
	$("#inp-name").val("");
	$("#chk-active").prop("checked", false);
	$("#modal-default").modal("show");
});

$("#form-data").validator();
$("#form-data").on("submit", function(e) {
	//Se o validador não impedir o evento do form
	if ($(this).find('.has-error').length===0) {
		var active = 0;
		if ($("#chk-active").is(':checked')) {
			active = 1;
		}
		$("#modal-load").modal('show');
		var new_mark = $("#inp-name").val();
		var operation = $(this).attr('operation');
		if (operation === 'update') {
			var data = {new_name: new_mark, name: current_mark, new_active: active};
		} else {
			var data = {name: new_mark, active: active};
		}
		$.ajax({
			url: "marks/"+operation,
			type: "POST",
			data: data,
			dataType: "json"
		}).done(function(dataReturn) {
				console.log(dataReturn);
			if (!$.isEmptyObject(dataReturn.response)) {
				alert(dataReturn.response.message)
				if (dataReturn.response.code === 0) {
					$("#modal-default").modal('hide');
					location.reload();
				}
			} else {
				alert("Retorno inesperado!");
			}
			$("#modal-load").modal('hide');
		}).fail(function(jqXHR, textStatus) {
			console.log(jqXHR);
			console.log(textStatus);
			$("#modal-load").modal('hide');
		  	alert("Request failed: " + textStatus );
		});
	}
});
