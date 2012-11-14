<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="Login.aspx.vb" Inherits="WebSiteFrontEnd.Login" %>

<asp:Content runat="server" ID="ContentHead" ContentPlaceHolderID="ContentPlaceHolder_Head">
    <script type="text/javascript">
        //Submit on enter LinkButton
        function DefaultButtonKeyPress(evt, thisElementName) {
            if (evt.which || evt.keyCode) {
                if ((evt.which == 13) || (evt.keyCode == 13)) {
                    location = document.getElementById(thisElementName).href;
                    return false;
                }
            }
            else {
                return true;
            }
        }
    </script>
    <script type="text/javascript" language="javascript">
        function fnCustomValidator(source, args) {
            args.IsValid = true;
        };
    </script>
</asp:Content>
<asp:Content ID="ContentBody" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:UpdatePanel ID="upLogin" runat="server">
        <ContentTemplate>
            <div class="content content_login">
                <div class="inner">
                    <fieldset class="f_login">
                        <h2 class="fonte700">
                            <asp:Literal ID="ltrTitulo" runat="server" /></h2>
                        <ul class="fields">
                            <li>
                                <asp:Label runat="server" ID="lblIdentificacao" AssociatedControlID="txtIdentificacao" />
                                <div class="fieldbox">
                                    <asp:TextBox runat="server" ID="txtIdentificacao" CssClass="textbox" MaxLength="50"/>
                                </div>
                            </li>
                            <li>
                                <asp:Label ID="lblSenha" runat="server" AssociatedControlID="txtSenha" />
                                <div class="fieldbox">
                                    <asp:TextBox runat="server" ID="txtSenha" TextMode="Password" CssClass="textbox" MaxLength="10" />
                                </div>
                                <p>
                                    <asp:LinkButton ID="lnkEsqueciSenha" runat="server" />
                                </p>
                            </li>
                            <li class="buttons">
                                <asp:LinkButton runat="server" ID="btnLogin" ValidationGroup="Login" CssClass="btn_ok" />
                            </li>
                        </ul>
                    </fieldset>
                    <asp:CustomValidator ID="ctvLogin" runat="server" Display="None" ValidationGroup="Login"
                        ClientValidationFunction="fnCustomValidator" />
                </div>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
