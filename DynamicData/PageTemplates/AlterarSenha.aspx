<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/Site.master"
    CodeBehind="AlterarSenha.aspx.vb" Inherits="Manutencao.AlterarSenha" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <h2>
        Alterar Senha</h2>
    <div class="field4">
        <span>Digite sua nova senha:</span>
        <asp:TextBox TextMode="Password" ID="txtSenha" runat="server"></asp:TextBox>
        <asp:RequiredFieldValidator ID="rqfSenha" runat="server" ControlToValidate="txtSenha"
            Text="*" ErrorMessage="Informe a nova senha"></asp:RequiredFieldValidator>
    </div>
    <div class="field4">
    <span>Confirme sua nova senha:</span>
    <asp:TextBox TextMode="Password" ID="txtNovaSenha" runat="server"></asp:TextBox>
    <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ControlToValidate="txtNovaSenha"
        Text="*" ErrorMessage="Confirme a nova senha"></asp:RequiredFieldValidator>
    <asp:CompareValidator ID="cmpSenha" runat="server" ControlToValidate="txtNovaSenha"
        ControlToCompare="txtSenha" Operator="Equal" Text="*" ErrorMessage="Confirmação inválida. Digite novamente a senha"></asp:CompareValidator>
    </div>
    <asp:Button ID="btnAlterarSenha" runat="server" Text="Salvar" CssClass="botao_link" />
    <asp:ValidationSummary ID="sumario" runat="server" EnableClientScript="true" ShowMessageBox="true"
        ShowSummary="false" />
</asp:Content>
