jQuery(document).ready(function($) {
    $(".clickableRow").click(function() { window.document.location = $(this).attr("href"); });
    $(".clickableRow").css('cursor', 'pointer');
});



$('#sig_fichasocialbundle_persona_rut').Rut({ format_on: 'keyup' });
$('#sig_fichasocialbundle_encuestadorfichasocial_rut').Rut({ format_on: 'keyup' });

$('#sig_fichasocialbundle_persona_primer_nombre').keyup(function(evt){ var txt = $(this).val(); $(this).val(txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase()); });
$('#sig_fichasocialbundle_persona_segundo_nombre').keyup(function(evt){ var txt = $(this).val(); $(this).val(txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase()); });
$('#sig_fichasocialbundle_persona_primer_apellido').keyup(function(evt){ var txt = $(this).val(); $(this).val(txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase()); });
$('#sig_fichasocialbundle_persona_segundo_apellido').keyup(function(evt){ var txt = $(this).val(); $(this).val(txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase()); });

//$(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); }));
//var base_url = window.location.origin;
/*
function submitForm(formId) {
    var form = document.getElementById(formId);
    form.noValidate = true;
    form.onsubmit = validateForm;
    //form.submit();
}*/

//$('#sig_fichasocialbundle_propiedad_calle_id').autocompleterPropiedad({url_search: base_url.concat("/calles/search"), url_get:  base_url.concat("/calles/get")});
//$('#sig_fichasocialbundle_persona_calle').autocompleterDomicilio({url_search: base_url.concat("/propiedades/search"), url_get:  base_url.concat("/propiedades/get"), col: 'calle'});
//$('#sig_fichasocialbundle_persona_numero').autocompleterDomicilio({url_search: base_url.concat("/propiedades/search"), url_get:  base_url.concat("/propiedades/get"), col: 'numero'});
//$('#sig_fichasocialbundle_persona_complemento').autocompleterDomicilio({url_search: base_url.concat("/propiedades/search"), url_get:  base_url.concat("/propiedades/get"), col: 'complemento'});
