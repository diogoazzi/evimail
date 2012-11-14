<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="ConfirmarEmail.aspx.vb" Inherits="WebSiteFrontEnd.ConfirmaEmail" %>

<%@ Register Assembly="AspXtremeCaptcha" Namespace="Cforge.Web.UI.WebControls" TagPrefix="aspX" %>
<asp:Content ID="ContentHead" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
<script type="text/javascript" >
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
</asp:Content>
<asp:Content ID="ContentBody" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:UpdatePanel ID="upConfirmarEmail" runat="server" UpdateMode="Conditional" ChildrenAsTriggers="false">
        <Triggers>
            <asp:AsyncPostBackTrigger ControlID="lnkEnviarCopia" EventName="Click" />
            <asp:AsyncPostBackTrigger ControlID="lnkVisualizarEmail" EventName="Click" />
            <asp:AsyncPostBackTrigger ControlID="lnkEsqueciSenha" EventName="Click" />
            <asp:AsyncPostBackTrigger ControlID="cblConfirmaEmail" EventName="SelectedIndexChanged" />
            <asp:AsyncPostBackTrigger ControlID="btnLogin" EventName="Click" />
            <asp:AsyncPostBackTrigger ControlID="lnkConfirmar" EventName="Click" />
        </Triggers>
        <ContentTemplate>
            <div id="content">
                <h2 class="title">
                    <asp:Literal ID="ltrTitulo" runat="server" />
                </h2>
                <div class="head">
                    <p>
                        <asp:Literal ID="ltrMensagemEmailRecebido" runat="server" />
                        <%--<asp:Literal ID="ltlHeadFrase1" runat="server" Text="Você recebeu o email"></asp:Literal> 
                        "<asp:Literal ID="ltlAssunto" runat="server" Text="Loren Ipsum Dolor"></asp:Literal>" 
                        <asp:Literal ID="ltlHeadFrase2" runat="server" Text="no endereço eletronico"></asp:Literal>
                        <asp:Literal ID="ltlEmail" runat="server" Text="email@minhacasa.com.br"></asp:Literal>--%>
                    </p>
                    <p>
                        <asp:PlaceHolder ID="phEnviarCopia" runat="server" Visible="false">
                            <asp:LinkButton ID="lnkEnviarCopia" CssClass="emailClose" runat="server" style="height:15px"/>
                        </asp:PlaceHolder>
                        <asp:PlaceHolder ID="phVisualizarEmail" runat="server" Visible="false">
                            <asp:LinkButton ID="lnkVisualizarEmail" CssClass="emailOpen" runat="server" style="height:15px"/>
                        </asp:PlaceHolder>
                    </p>
                </div>
                <div class="body">
                    <asp:PlaceHolder ID="phLogin" runat="server" Visible="false">
                        <div class="content content_login">
                                <fieldset class="f_login">
                                <h2 class="fonte700">
                                        <asp:Literal ID="ltrTituloLogin" runat="server" /></h2>
                                    <ul class="fields">
                                        <li>
                                            <asp:Label runat="server" ID="lblIdentificacao" AssociatedControlID="txtIdentificacao" />
                                            <div class="fieldbox">
                                                <asp:TextBox runat="server" ID="txtIdentificacao" CssClass="textbox" MaxLength="255"/>
                                            </div>
                                            <asp:RequiredFieldValidator ID="rfvLogin" runat="server" Display="None" ValidationGroup="login"
                                                ControlToValidate="txtIdentificacao" />
                                        </li>
                                        <li>
                                            <asp:Label ID="lblSenha" runat="server" AssociatedControlID="txtSenha" />
                                            <div class="fieldbox">
                                                <asp:TextBox runat="server" ID="txtSenha" TextMode="Password" CssClass="textbox" MaxLength="10"/>
                                            </div>
                                            <asp:RequiredFieldValidator ID="rfvSenha" runat="server" Display="None" ValidationGroup="login"
                                                ControlToValidate="txtSenha" />
                                            <p>
                                                <%--<a href="../Lightbox/EsqueciSenha.aspx" class="esqueciSenha">Esqueci minha senha</a>--%>
                                                <asp:LinkButton ID="lnkEsqueciSenha" runat="server" />
                                            </p>
                                        </li>
                                        <li class="buttons">
                                            <asp:LinkButton runat="server" ID="btnLogin" ValidationGroup="login" CssClass="btn_ok" />
                                        </li>
                                        <asp:ValidationSummary runat="server" ID="ValidationLogin" ShowMessageBox="true"
                                            ShowSummary="false" ValidationGroup="login" />
                                    </ul>
                                </fieldset>
                            
                        </div> 
                    </asp:PlaceHolder>
                    <asp:PlaceHolder ID="phConfirmar" runat="server" Visible="false">
                        <asp:ValidationSummary ID="vsConfirmarEmail" runat="server" ValidationGroup="ConfirmarEmail" />
                        <p>
                            <asp:Literal ID="ltrMensagemConfirmacao" runat="server" /></p>
                        <fieldset>
                            <div class="bordaTop">
                            </div>
                            <div>
                                <asp:CheckBoxList ID="cblConfirmaEmail" runat="server" RepeatLayout="UnorderedList" AutoPostBack="true" />
                                <%--<asp:CheckBox ID="chkConfirmarEmail" runat="server" AutoPostBack="true" />
                                <br />
                                <asp:CheckBox ID="chkConfirmarAnexos" runat="server" />--%>
                                <asp:PlaceHolder ID="phCaptcha" runat="server" Visible="false">
                                    <div class="captchaBox">
                                        <div>
                                            <p>
                                                <asp:Label ID="lblCodigoCaptcha" runat="server" AssociatedControlID="txtCodigoCaptcha" />
                                                <asp:TextBox ID="txtCodigoCaptcha" CssClass="txtBox" runat="server" MaxLength="5" />
                                            </p>
                                        </div>
                                        <div>
                                            <aspX:XtremeCaptcha ID="xctCaptchaBox" runat="server" />
                                        </div>
                                    </div>
                                </asp:PlaceHolder>
                                <p>
                                    <asp:CustomValidator ID="ctvConfirmarEmail" runat="server" Display="None" ValidationGroup="ConfirmarEmail" />
                                    <asp:LinkButton ID="lnkConfirmar" CssClass="button" runat="server" ValidationGroup="ConfirmarEmail" /></p>
                            </div>
                            <div class="bordaBottom">
                            </div>
                        </fieldset>
                    </asp:PlaceHolder>
                </div>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
