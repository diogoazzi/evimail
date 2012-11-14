$(function () {
    // define o posicionamento do #footer de acordo com o tamanho da window
    function footerPosition() {
        if ($('body').height() < $(window).height()) {
            $('#footer').addClass('customFooter');
        } else {
            $('#footer').removeClass('customFooter');
        }
    }
    footerPosition();

    $(window).resize(function () {
        footerPosition();
    });
    // end


    // #menuUsrLogado
    $('#menuUsrLogado li:last-child span').css('border', 'none');
    $('#menuUsrLogado li:last-child a').css('border', 'none');

    $('#menuUsrLogado li.selected').each(function () {
        $(this).prev('li').find('span').css('border', 'none');
    });

    // striped table        
    $('.tableStyle').each(function () {
        $('tbody tr:odd', this).addClass('striped');
    });

    // rounded
    jQuery.each(jQuery.browser, function (b, val) {
        // se for o IE6 não executa o codigo abaixo
        if (b != "msie" && jQuery.browser.version.substr(0, 3) != "6.0") {
            $('.rounded_a').prepend('<span class="rd_tl"></span><span class="rd_tr"></span>');
            $('.rounded_a').append('<span class="rd_bl"></span><span class="rd_br"></span>');
        }
    });

    // btnSaibaMais
  /* $('.openBoxTip').click(function (e) {
        e.preventDefault();
        var position = $(this).position();
        var height = $(this).outerHeight(true);
        var marginLeft = $(this).css('marginLeft');
        margin = parseInt(marginLeft, 10);

        $(this).parent().find('.boxTip').css({
            'top': position.top + height + 3,
            'left': position.left + margin + 10
        }).toggle();
    });
    $('.closeBoxTip').click(function (e) { e.preventDefault(); $(this).parent('.boxTip').hide(); });*/
    
    // RollOver do Credito Uvaia
    $('#formaPagamentoLeft ol li span.aspNetDisabled strong').hover(function (e) {
        e.preventDefault();
        var position = $(this).parents('li').position();
        var height = $(this).parents('li').innerHeight();
        var marginLeft = $(this).css('marginLeft');
        margin = parseInt(marginLeft, 10);

        $(this).parents('fieldset').find('.boxTip').css({
            'top': position.top + height - 20,
            'left': position.left + margin + 26
        }).show();
    }, function () {
        $(this).parents('fieldset').find('.boxTip').hide();
    });
    $('.closeBoxTip').click(function (e) { e.preventDefault(); $(this).parent('.boxTip').hide(); });

});

// Função que permite digitar apenas números
function DigSomenteNumeros(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 17 || (charCode > 31 && (charCode < 48 || charCode > 57))) {
        return false;
    }
    if (!evt.ctrlKey) {
        return true;
    }
    return false;
}

// Função que completa uma string com n caracteres (pad) a direita
String.prototype.padLeft = function (n, pad) {
    t = '';
    if (n > this.length) {
        for (i = 0; i < n - this.length; i++) {
            t += pad;
        }
    }
    return t + this;
}

// Função para formatar um telefone
function MascaraTel(campo) {
    var valor = campo.value.replace('-', '');
    var tam = valor.length;

    valor = valor.padLeft(8, '');

    if (tam > 4)
        campo.value = valor.substring(0, 4) + '-' + valor.substring(4, 8);
}

// Função para formatar um CEP
function MascaraCEP(campo) {
    var valor = campo.value.replace('-', '');
    var tam = valor.length;

    valor = valor.padLeft(8, '');

    if (tam > 5)
        campo.value = valor.substring(0, 5) + '-' + valor.substring(5, 8);
}

// Função para formatar uma data
function MascaraData(campo) {
    var valor = campo.value.replace('/', '').replace('/', '');
    var tam = valor.length;

    valor = valor.padLeft(8, '');

    if (tam > 4)
        campo.value = valor.substring(0, 2) + '/' + valor.substring(2, 4) + '/' + valor.substring(4, 8);
    else if (tam > 2)
        campo.value = valor.substring(0, 2) + '/' + valor.substring(2, 4);
}

// Função para formatar uma data
function MascaraDataValidadeCartao(campo) {
    var valor = campo.value.replace('/', '').replace('/', '');
    var tam = valor.length;

    valor = valor.padLeft(6, '');

    if (tam > 2)
        campo.value = valor.substring(0, 2) + '/' + valor.substring(2, 6);
}

// Função para formatar um CNPJ
function MascaraCNPJ(campo) {
    var valor = campo.value.replace('/', '').replace('.', '').replace('.', '').replace('-', '');
    var tam = valor.length;

    valor = valor.padLeft(14, '');

    if (tam > 12)
        campo.value = valor.substring(0, 2) + '.' + valor.substring(2, 5) + '.' + valor.substring(5, 8) + '/' + valor.substring(8, 12) + '-' + valor.substring(12, 14);
    else if (tam > 8)
        campo.value = valor.substring(0, 2) + '.' + valor.substring(2, 5) + '.' + valor.substring(5, 8) + '/' + valor.substring(8, 12);
    else if (tam > 5)
        campo.value = valor.substring(0, 2) + '.' + valor.substring(2, 5) + '.' + valor.substring(5, 8);
    else if (tam > 2)
        campo.value = valor.substring(0, 2) + '.' + valor.substring(2, 5);
}

// Função para formatar um CPF
function MascaraCPF(campo) {
    var valor = campo.value.replace('.', '').replace('.', '').replace('-', '');
    var tam = valor.length;

    valor = valor.padLeft(11, '');

    if (tam > 9)
        campo.value = valor.substring(0, 3) + '.' + valor.substring(3, 6) + '.' + valor.substring(6, 9) + '-' + valor.substring(9, 11);
    else if (tam > 6)
        campo.value = valor.substring(0, 3) + '.' + valor.substring(3, 6) + '.' + valor.substring(6, 9);
    else if (tam > 3)
        campo.value = valor.substring(0, 3) + '.' + valor.substring(3, 6);
}

//	Função para remover a formatação de um CPF ou CNPJ
function RemoverFormatacao_CPF_CNPJ(pValor) {
    return pValor.replace(/-/g, '').replace(/_/g, '').replace(/\./g, '').replace('/', '')
}

// Função de Saida das Validações
function ValidarPagina(validationgroup) {
    var cont = Math.random();
    if (typeof (Page_ClientValidate) == 'function') {
        Page_ClientValidate(validationgroup);
    }
    if (!Page_IsValid) {
        var controle = null;
        for (var i = 0; i < Page_Validators.length; i++) {
            if (!Page_Validators[i].isvalid) {
                $('#' + Page_Validators[i].controltovalidate).addClass("erro-campo")
                controle = Page_Validators[i].controltovalidate;
            } else {
                if (Page_Validators[i].controltovalidate != controle) {
                    $('#' + Page_Validators[i].controltovalidate).removeClass("erro-campo");
                }
            }
        }
        return false;
    }
    return true;
}

$(function () {
    //Classe dos TextBox de Alterar Dados
    $('.alteraDado input:text, .cadastro input:text').addClass('txtBox');

    //Elimina Borda nos elementos multiplos de três no tipo de pagamento
    $('.bandeiraCartao li:nth-child(3n)').css('border', 'none');
});


