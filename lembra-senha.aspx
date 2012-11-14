<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="lembra-senha.aspx.vb"
    Inherits="Manutencao.lembra_senha" %>

<%@ Register Assembly="MessageBox" Namespace="MessageBox" TagPrefix="cc1" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
    <title>Login - Área restrita - Rede PitStop</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
</head>
<body>
    <form id="form1" runat="server">
    <p style="margin: 0; padding: 0; font-size: 12px;">
        Preencha seu login para receber informações de acesso.</p>
    <p style="margin-top: 10px;">
        <asp:TextBox runat="server" Width="220px" Text="Digite seu email" ID="txtLogin" Style="vertical-align: middle;"
            onfocus="if(this.value=='Digite seu email')this.value=''" onblur="if(this.value=='')this.value='Digite seu email'"></asp:TextBox>
        <asp:ImageButton ID="btnOk" runat="server" ImageUrl="/App_Themes/Padrao/Imagens/btoOk.gif"
            Style="vertical-align: middle;" ValidationGroup="lembrarSenha" />
        <asp:RequiredFieldValidator ID="rfvUsuario" runat="server" ControlToValidate="txtLogin"
            ErrorMessage="Informe seu email de acesso" ValidationGroup="lembrarSenha" Display="Dynamic"
            InitialValue="Digite seu email" CssClass="validacao"></asp:RequiredFieldValidator>
        <asp:RequiredFieldValidator ID="rfvUsuario2" runat="server" ControlToValidate="txtLogin"
            ErrorMessage="Digite seu email de acesso" CssClass="validacao" ValidationGroup="lembrarSenha"
            Display="Dynamic"></asp:RequiredFieldValidator>
    </p>
    <cc1:MessageBox ID="MessageBox1" runat="server" />
    </form>
</body>
</html>
