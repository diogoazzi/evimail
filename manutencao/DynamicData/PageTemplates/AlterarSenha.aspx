<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/Site.master"
    CodeBehind="AlterarSenha.aspx.vb" Inherits="Manutencao.AlterarSenha" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

<script type="text/javascript">


    function validaTamanho(sender) {
        var senha = sender.val();
        var tamanho = senha.length;
        var entreMinMax = ((tamanho >= 6) && (tamanho <= 8));

        if (entreMinMax) {
            $("#errorSenha").text("");
            return 0;
        } else {
            $("#errorSenha").text("A senha deve ter entre 6 e 8 caracteres.");
            return 1;
        }
    }

    function comparaSenhas(field1, field2) {
        if (field1.val() == field2.val()) {
            $("#errorConfirma").empty();
            return 0;
        } else {
            $("#errorConfirma").text("As senhas digitadas não coincidem.")
            return 1;
        }
    }

    function validaSenhas() {
        var errorCount = 0;
        var senha = $("#ctl00_ContentPlaceHolder1_txtSenha");
        var confirma = $("#ctl00_ContentPlaceHolder1_txtNovaSenha");

        errorCount += validaTamanho(senha);
        errorCount += comparaSenhas(senha, confirma);

        if (errorCount > 0)
            return false;
        else
            return true;

    }

    $(document).ready(function () {

        $("#ctl00_ContentPlaceHolder1_btnAlterarSenha").click(function () {
            return validaSenhas();            
        })

    })
</script>
    <h2>
        Alterar Senha
    </h2>
    <div class="field4">
        <span>Digite sua nova senha:</span>
        <asp:TextBox TextMode="Password" ID="txtSenha" runat="server" MaxLength="8"></asp:TextBox>
        <span id="errorSenha" class="errorPlaceholder"></span>
    </div>
    <div class="field4">
        <span>Confirme sua nova senha:</span>
        <asp:TextBox TextMode="Password" ID="txtNovaSenha" runat="server" MaxLength="8"></asp:TextBox>
        <span id="errorConfirma" class="errorPlaceholder"></span>
     </div>
    <asp:Button ID="btnAlterarSenha" runat="server" Text="Salvar" CssClass="botao_link" />
</asp:Content>
