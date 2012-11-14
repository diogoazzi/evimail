<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="AlterarSenha.aspx.vb"
    Inherits="WebSiteFrontEnd.AlterarSenha" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <script src="../js/cufon/cufon.js" type="text/javascript"></script>
    <script src="../js/cufon/Helvetica_Neue_500_700.font.js" type="text/javascript"></script>
    <script src="../js/cufon-fonts.js" type="text/javascript"></script>
    <script src="../js/base.js" type="text/javascript"></script>
</head>
<style type="text/css">
html,body{ overflow:hidden; }
</style>
<body>
    <form id="form1" runat="server">
    <div class="altSenha">
        
        <div class="alterForm">
            <%--<asp:ScriptManager ID="ScriptManagerAlterarSenha" runat="server" EnablePartialRendering="true" />
            <asp:UpdatePanel ID="upAlterarSenha" runat="server" UpdateMode="Conditional" ChildrenAsTriggers="false">
                <Triggers>
                    <asp:AsyncPostBackTrigger ControlID="lnkAlterarSenha" EventName="Click" />
                </Triggers>
                <ContentTemplate>--%>
                    <p>
                        <asp:Label ID="lblNovaSenha" runat="server" AssociatedControlID="txtNovaSenha" />
                        <asp:TextBox ID="txtNovaSenha" runat="server" CssClass="txtBox" TextMode="Password"
                            MaxLength="10" />
                        <asp:Label ID="lblNovaSenhaObservacao" runat="server" CssClass="legendForm" />
                        <asp:RequiredFieldValidator ID="rfvNovaSenha" runat="server" ControlToValidate="txtNovaSenha"
                            Display="None" ValidationGroup="AlterarSenha" />
                        <asp:RegularExpressionValidator ID="revNovaSenha" runat="server" ControlToValidate="txtNovaSenha"
                            Display="None" ValidationGroup="AlterarSenha" ValidationExpression="[A-Za-z0-9]{6,10}" />
                    </p>
                    <!-- Campo Confirme a senha -->
                    <p>
                        <asp:Label ID="lblConfirmeNovaSenha" runat="server" AssociatedControlID="txtConfirmeNovaSenha" />
                        <asp:TextBox ID="txtConfirmeNovaSenha" runat="server" CssClass="txtBox" TextMode="Password" MaxLength="10" />
                        <asp:RequiredFieldValidator ID="rfvConfirmeNovaSenha" runat="server" ControlToValidate="txtConfirmeNovaSenha" Display="None" ValidationGroup="AlterarSenha" />
                        <asp:CompareValidator ID="cpvConfirmeNovaSenha" runat="server" ControlToValidate="txtConfirmeNovaSenha" ControlToCompare="txtNovaSenha" Display="None" ValidationGroup="AlterarSenha" Operator="Equal" />
                    </p>
                    <p class="bordaAltSenha">
                        <asp:CustomValidator ID="ctvAlterarSenha" runat="server" Display="None" ValidationGroup="AlterarSenha" />
                        <asp:LinkButton ID="lnkAlterarSenha" runat="server" CssClass="button" ValidationGroup="AlterarSenha" />

                        <asp:ValidationSummary ID="vsAlterarSenha" CssClass="sumario" runat="server" DisplayMode="List" ValidationGroup="AlterarSenha" />
                    </p>
                <%--</ContentTemplate>
            </asp:UpdatePanel>--%>
        </div>
    </div>
    </form>
</body>
</html>
