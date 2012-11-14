<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="alteraDado.aspx.vb" MasterPageFile="~/MasterPage/Master.Master"
    Inherits="WebSiteFrontEnd.AlteraDado" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
<script type="text/javascript" language="javascript">
    function fnCustomValidator(source, args) {
        args.IsValid = true;
    };
</script>
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <div id="content">
        <h2 class="title">
            <asp:Label ID="lblTitulo" runat="server" /></h2>
        <p class="campoObrig">
            <asp:Literal ID="ltrMensagemCamposObrigatorios" runat="server" /></p>
        <div class="formRounded_a rounded_a">
            <asp:UpdatePanel ID="upAlteracaoDados" runat="server" ChildrenAsTriggers="false"
                UpdateMode="Conditional">
                <Triggers>
                    <asp:AsyncPostBackTrigger ControlID="lnkAlterarSenha" EventName="Click" />
                    <asp:AsyncPostBackTrigger ControlID="lnkSalvarAlteracao" EventName="Click" />
                </Triggers>
                <ContentTemplate>
                    <fieldset>

                        <p class="floatLeft">
                            <asp:Label ID="lblNome" runat="server" AssociatedControlID="txtNome" />
                            <asp:TextBox ID="txtNome" runat="server" CssClass="txtBox widthG" MaxLength="50" />
                            <%--<asp:RequiredFieldValidator ID="rfvNome" runat="server" ControlToValidate="txtNome"
                                Display="None" ValidationGroup="AlterarDados" />--%>
                        </p>

                        <p class="floatLeft">
                            <asp:Label ID="lblEmail" runat="server" AssociatedControlID="txtEmail" />
                            <asp:TextBox ID="txtEmail" runat="server" CssClass="txtBox widthG" MaxLength="255" />
                            <%--<asp:RequiredFieldValidator ID="rfvEmail" runat="server" ControlToValidate="txtEmail"
                                Display="None" ValidationGroup="AlterarDados" />--%>
                            <%--<asp:RegularExpressionValidator ID="revEmail" runat="server" ControlToValidate="txtEmail"
                                Text="*" ValidationExpression="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$"
                                ValidationGroup="AlterarDados" Display="None" />--%>
                        </p>
                        <p class="clear">
                            <asp:RadioButtonList ID="rblTipoPessoa" runat="server" Enabled="false" RepeatLayout="Flow"
                                RepeatDirection="Horizontal" />
                            <asp:TextBox ID="txtCPFCNPJ" CssClass="txtBox widthG" runat="server" Enabled="false" />
                            <asp:PlaceHolder ID="phCPF" runat="server" Visible="false">
                                <div class="boxEuSou">
                                    <p>
                                        <asp:Label ID="lblSexo" runat="server" AssociatedControlID="rblSexo" />
                                        <asp:RadioButtonList ID="rblSexo" CssClass="radioSex" runat="server" RepeatLayout="Flow" RepeatDirection="Horizontal" />
                                        <%--<asp:RequiredFieldValidator ID="rfvSexo" runat="server" ControlToValidate="rblSexo"
                                            Display="None" ValidationGroup="Cadastro" />--%>
                                    </p>
                                    <p>
                                        <asp:Label ID="lblDataNascimento" runat="server" AssociatedControlID="txtDataNascimento" />
                                        <asp:TextBox ID="txtDataNascimento" runat="server" Text="99/99/9999" Enabled="false" />
                                        <%--<asp:Label ID="lblDataNascimentoObservacao" runat="server" CssClass="legendForm" />--%>
                                    </p>
                                </div>
                            </asp:PlaceHolder>
                            <asp:PlaceHolder ID="phCNPJ" runat="server" Visible="false">
                                <div class="boxEuSou">
                                    <p>
                                        <asp:Label ID="lblRazaoSocial" runat="server" AssociatedControlID="txtRazaoSocial" />
                                        <asp:TextBox ID="txtRazaoSocial" CssClass="txtBox widthG" runat="server" MaxLength="255"
                                            Enabled="false" />
                                    </p>
                                </div>
                            </asp:PlaceHolder>
                        </p>
                    </fieldset>
                    <fieldset>
                        <p class="floatLeft">
                            <asp:Label ID="lblPais" runat="server" AssociatedControlID="ddlPais" />
                            <asp:DropDownList ID="ddlPais" runat="server" />
                            <%--<asp:RequiredFieldValidator ID="rfvPais" runat="server" ControlToValidate="ddlPais"
                                Display="None" ValidationGroup="AlterarDados" InitialValue="0" />--%>
                        </p>
                        <p class="floatLeft">
                            <asp:Label ID="lblCEP" runat="server" AssociatedControlID="txtCEP" />
                            <asp:TextBox ID="txtCEP" runat="server" CssClass="widthM txtBox" MaxLength="9" />
                            <span class="legendForm">
                                <asp:HyperLink ID="lnkCEPCorreios" runat="server" CssClass="legendForm" NavigateUrl="http://www.buscacep.correios.com.br/servicos/dnec/index.do"
                                    Target="_blank" />
                            </span>
                            <%--<asp:RequiredFieldValidator ID="rfvCEP" runat="server" ControlToValidate="txtCEP"
                                Display="None" ValidationGroup="AlterarDados" />--%>
                            <%--<asp:RegularExpressionValidator ID="revCEP" runat="server" ControlToValidate="txtCEP"
                                Display="None" ValidationGroup="AlterarDados" ValidationExpression="[0-9]{5}-[0-9]{3}" />--%>
                        </p>
                        <p class="clear floatLeft">
                            <asp:Label ID="lblCidade" runat="server" AssociatedControlID="txtCidade" />
                            <asp:TextBox ID="txtCidade" runat="server" CssClass="widthG txtBox" MaxLength="50" />
                            <%--<asp:RequiredFieldValidator ID="rfvCidade" runat="server" ControlToValidate="txtCidade"
                                Display="None" ValidationGroup="AlterarDados" />--%>
                        </p>
                        <p class="floatLeft">
                            <asp:Label ID="lblUF" runat="server" AssociatedControlID="ddlUF" />
                            <asp:DropDownList ID="ddlUF" runat="server" />
                            <%--<asp:RequiredFieldValidator ID="rfvUF" runat="server" ControlToValidate="ddlUF" Display="None"
                                ValidationGroup="AlterarDados" InitialValue="0" />--%>
                        </p>
                        <p class="clear">
                            <asp:Label ID="lblLogradouro" runat="server" AssociatedControlID="txtLogradouro" />
                            <asp:TextBox ID="txtLogradouro" runat="server" CssClass="txtBox widthG" MaxLength="255" />
                            <%--<asp:RequiredFieldValidator ID="rfvLogradouro" runat="server" ControlToValidate="txtLogradouro"
                                Display="None" ValidationGroup="AlterarDados" />--%>
                        </p>
                        <p class="floatLeft">
                            <asp:Label ID="lblNumero" runat="server" AssociatedControlID="txtNumero" />
                            <asp:TextBox ID="txtNumero" runat="server" CssClass="txtBox widthPP" MaxLength="10" />
                            <%--<asp:RequiredFieldValidator ID="rfvNumero" runat="server" ControlToValidate="txtNumero"
                                Display="None" ValidationGroup="AlterarDados" />--%>
                        </p>
                        <p class="floatLeft">
                            <asp:Label ID="lblComplemento" runat="server" AssociatedControlID="txtComplemento" />
                            <asp:TextBox ID="txtComplemento" runat="server" CssClass="txtBox widthP" MaxLength="50" />
                        </p>
                        <p class="floatLeft">
                            <asp:Label ID="lblBairro" runat="server" AssociatedControlID="txtBairro" />
                            <asp:TextBox ID="txtBairro" CssClass="txtBox widthM" runat="server" MaxLength="50" />
                            <%--<asp:RequiredFieldValidator ID="rfvBairro" runat="server" ControlToValidate="txtBairro"
                                Display="None" ValidationGroup="AlterarDados" />--%>
                        </p>
                        <dl>
                            <dt>
                                <asp:Label ID="lblTelefoneCelular" runat="server" AssociatedControlID="txtTelefoneCelularDDD" /></dt>
                            <dd>
                                <asp:Label ID="lblTelefoneCelularDDD" runat="server" AssociatedControlID="txtTelefoneCelularDDD" />
                                <asp:TextBox ID="txtTelefoneCelularDDD" runat="server" CssClass="txtBox widthPP" MaxLength="2" />
                                <%--<asp:RequiredFieldValidator ID="rfvTelefoneCelularDDD" runat="server" ControlToValidate="txtTelefoneCelularDDD"
                                    Display="None" ValidationGroup="AlterarDados" />
                                <asp:RegularExpressionValidator ID="revTelefoneCelularDDD" runat="server" ControlToValidate="txtTelefoneCelularDDD"
                                    Display="None" ValidationGroup="AlterarDados" ValidationExpression="\d{2,5}" />--%>
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneCelularNumero" runat="server" AssociatedControlID="txtTelefoneCelularNumero" />
                                <asp:TextBox ID="txtTelefoneCelularNumero" runat="server" CssClass="txtBox widthG" MaxLength="9" style="width:60px"/>
                                <asp:Label ID="lblTelefoneCelularObservacao" runat="server" CssClass="legendForm" />
                                <%--<asp:RequiredFieldValidator ID="rfvTelefoneCelularNumero" runat="server" ControlToValidate="txtTelefoneCelularNumero"
                                    Display="None" ValidationGroup="AlterarDados" />
                                <asp:RegularExpressionValidator ID="revTelefoneCelularNumero" runat="server" ControlToValidate="txtTelefoneCelularNumero"
                                    Display="None" ValidationGroup="AlterarDados" ValidationExpression="[0-9]{4}\-[0-9]{4}" />--%>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <asp:Label ID="lblTelefoneResidencial" runat="server" AssociatedControlID="txtTelefoneResidencialDDD" /></dt>
                            <dd>
                                <asp:Label ID="lblTelefoneResidencialDDD" runat="server" AssociatedControlID="txtTelefoneResidencialDDD" />
                                <asp:TextBox ID="txtTelefoneResidencialDDD" runat="server" CssClass="txtBox widthPP" MaxLength="2" />
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneResidencialNumero" runat="server" AssociatedControlID="txtTelefoneResidencialNumero" />
                                <asp:TextBox ID="txtTelefoneResidencialNumero" runat="server" CssClass="txtBox widthG" MaxLength="9" style="width:60px"/>
                                <asp:Label ID="lblTelefoneResidencialObservacao" runat="server" CssClass="legendForm" />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <asp:Label ID="lblTelfoneComercial" runat="server" AssociatedControlID="txtTelefoneComercialDDD" /></dt>
                            <dd>
                                <asp:Label ID="lblTelefoneComercialDDD" runat="server" AssociatedControlID="txtTelefoneComercialDDD" />
                                <asp:TextBox ID="txtTelefoneComercialDDD" runat="server" CssClass="txtBox widthPP" MaxLength="2" />
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneComercialNumero" runat="server" AssociatedControlID="txtTelefoneComercialNumero" />
                                <asp:TextBox ID="txtTelefoneComercialNumero" runat="server" CssClass="txtBox widthG" MaxLength="9" style="width:60px"/>
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneComercialRamal" runat="server" AssociatedControlID="txtTelefoneComercialRamal" />
                                <asp:TextBox ID="txtTelefoneComercialRamal" runat="server" CssClass="txtBox widthPP" MaxLength="5" />
                                <asp:Label ID="lblTelefoneComercialObservacao" runat="server" CssClass="legendForm" />
                            </dd>
                        </dl>
                    </fieldset>
                    <fieldset class="final">
                        <p>
                            <asp:Label ID="lblNomeUsuario" runat="server" AssociatedControlID="txtNomeUsuario" />
                            <asp:TextBox ID="txtNomeUsuario" runat="server" CssClass="txtBox widthM" Enabled="false" />
                            <asp:LinkButton ID="lnkAlterarSenha" CssClass="acionaLightBox" runat="server" />
                        </p>
                    </fieldset>
                    <p class="botoes">
                        <asp:LinkButton ID="lnkSalvarAlteracao" runat="server" CssClass="button" ValidationGroup="AlterarDados" /></p>
                        <asp:CustomValidator ID="ctvAlterarDados" runat="server" Display="None" ValidationGroup="AlterarDados" 
                         ClientValidationFunction="fnCustomValidator"/>
                </ContentTemplate>
            </asp:UpdatePanel>
        </div>
    </div>
</asp:Content>
