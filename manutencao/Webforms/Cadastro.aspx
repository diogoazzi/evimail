<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="Cadastro.aspx.vb" Inherits="WebSiteFrontEnd.Cadastro" %>

<asp:Content ID="ContentHead" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
    <script type="text/javascript" language="javascript">
        function fnCustomValidator(source, args) {
            args.IsValid = true;
        };
    </script>
</asp:Content>
<asp:Content ID="ContentBody" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <div id="content">
        <h2 class="title">
            <asp:Label ID="lblTitulo" runat="server" /></h2>
        <p class="campoObrig">
            <asp:Literal ID="ltrMensagemCamposObrigatorios" runat="server" /></p>
        <div class="formRounded_a rounded_a">
            <asp:UpdatePanel ID="upCadastroCima" runat="server" ChildrenAsTriggers="false" UpdateMode="Conditional">
                <Triggers>
                    <asp:AsyncPostBackTrigger ControlID="rblTipoPessoa" EventName="SelectedIndexChanged" />
                    <asp:AsyncPostBackTrigger ControlID="lnkCriarConta" EventName="Click" />
                </Triggers>
                <ContentTemplate>
                    <fieldset>
                        <!-- Campo Eu sou -->
                        <p>
                            <asp:Label ID="lblEuSou" runat="server" AssociatedControlID="rblTipoPessoa" />
                            <asp:RadioButtonList ID="rblTipoPessoa" runat="server" AutoPostBack="true" RepeatLayout="Flow"
                                RepeatDirection="Horizontal" />
                        </p>
                        <!-- Campo Nome -->
                        <p class="floatLeft">
                            <asp:Label ID="lblNome" runat="server" AssociatedControlID="txtNome" />
                            <asp:TextBox ID="txtNome" runat="server" MaxLength="50" CssClass="txtBox widthG" />
                        </p>
                        <!-- Campo Email -->
                        <p class="floatLeft">
                            <asp:Label ID="lblEmail" runat="server" AssociatedControlID="txtEmail" />
                            <asp:TextBox ID="txtEmail" runat="server" MaxLength="50" CssClass="txtBox widthG" />
                        </p>
                        <!-- Campo CPF -->
                        <asp:PlaceHolder ID="phCPF" runat="server" Visible="false">
                            <div class="boxEuSou">
                                <p>
                                    <asp:Label ID="lblCPF" runat="server" AssociatedControlID="txtCPF" />
                                    <asp:TextBox ID="txtCPF" CssClass="txtBox" runat="server" MaxLength="14" />
                                    <asp:Label ID="lblCPFObservacao" CssClass="legendForm" runat="server" />
                                </p>
                                <p>
                                    <asp:Label ID="lblSexo" runat="server" AssociatedControlID="rblSexo" />
                                    <asp:RadioButtonList ID="rblSexo" runat="server" RepeatLayout="Flow" RepeatDirection="Horizontal" />
                                </p>
                            </div>
                            <div>
                                <!-- Campo Data de nascimento -->
                                <p>
                                    <asp:Label ID="lblDataNascimento" runat="server" AssociatedControlID="txtDataNascimento" />
                                    <asp:TextBox ID="txtDataNascimento" runat="server" MaxLength="10" CssClass="txtBox" />
                                </p>
                            </div>
                        </asp:PlaceHolder>
                        <!-- Campo CNPJ -->
                        <asp:PlaceHolder ID="phCNPJ" runat="server" Visible="false">
                            <div class="boxEuSou">
                                <p>
                                    <asp:Label ID="lblCNPJ" runat="server" AssociatedControlID="txtCNPJ" />
                                    <asp:TextBox ID="txtCNPJ" CssClass="txtBox" runat="server" MaxLength="18" />
                                    <asp:Label ID="lblCNPJObservacao" CssClass="legendForm" runat="server" />
                                </p>
                                <p>
                                    <asp:Label ID="lblRazaoSocial" runat="server" AssociatedControlID="txtRazaoSocial" />
                                    <asp:TextBox ID="txtRazaoSocial" CssClass="txtBox widthG" runat="server" MaxLength="255" />
                                </p>
                            </div>
                        </asp:PlaceHolder>
                    </fieldset>
                    <fieldset>
                        <!-- Campo País -->
                        <p class="floatLeft">
                            <asp:Label ID="lblPais" runat="server" AssociatedControlID="ddlPais" />
                            <asp:DropDownList ID="ddlPais" runat="server" />
                        </p>
                        <!-- Campo CEP -->
                        <p class="floatLeft">
                            <asp:Label ID="lblCEP" runat="server" AssociatedControlID="txtCEP" />
                            <asp:TextBox ID="txtCEP" runat="server" MaxLength="9" CssClass="widthM txtBox" />
                            <span class="legendForm">
                                <asp:HyperLink ID="lnkCEPCorreios" runat="server" CssClass="legendForm" NavigateUrl="http://www.buscacep.correios.com.br/servicos/dnec/index.do"
                                    Target="_blank" />
                            </span>
                        </p>
                        <div class="clear">
                        </div>
                        <!-- Campo Cidade -->
                        <p class="floatLeft clear">
                            <asp:Label ID="lblCidade" runat="server" AssociatedControlID="txtCidade" />
                            <asp:TextBox ID="txtCidade" CssClass="txtBox widthG" runat="server" MaxLength="50" />
                        </p>
                        <!-- Campo UF -->
                        <p class="floatLeft">
                            <asp:Label ID="lblUF" runat="server" AssociatedControlID="ddlUF" />
                            <asp:DropDownList ID="ddlUF" runat="server" />
                        </p>
                        <!-- Campo Logradouro -->
                        <p class="floatLeft">
                            <asp:Label ID="lblLogradouro" runat="server" AssociatedControlID="txtLogradouro" />
                            <asp:TextBox ID="txtLogradouro" CssClass="txtBox widthG" runat="server" MaxLength="255" />
                        </p>
                        <!-- Campo Número -->
                        <p class="floatLeft">
                            <asp:Label ID="lblNumero" runat="server" AssociatedControlID="txtNumero" />
                            <asp:TextBox ID="txtNumero" CssClass="txtBox widthPP" runat="server" MaxLength="10" />
                        </p>
                        <!-- Campo Complemento -->
                        <p class="floatLeft">
                            <asp:Label ID="lblComplemento" runat="server" AssociatedControlID="txtComplemento" />
                            <asp:TextBox ID="txtComplemento" CssClass="txtBox widthG" runat="server" MaxLength="50" />
                        </p>
                        <!-- Campo Bairro -->
                        <p class="floatLeft">
                            <asp:Label ID="lblBairro" runat="server" AssociatedControlID="txtBairro" />
                            <asp:TextBox ID="txtBairro" CssClass="txtBox widthM" runat="server" MaxLength="50" />
                        </p>
                        <!-- Campo Telefone celular -->
                        <dl>
                            <dt>
                                <asp:Label ID="lblTelefoneCelular" runat="server" AssociatedControlID="txtTelefoneCelularDDD" /></dt>
                            <dd>
                                <asp:Label ID="lblTelefoneCelularDDD" runat="server" AssociatedControlID="txtTelefoneCelularDDD" />
                                <asp:TextBox ID="txtTelefoneCelularDDD" CssClass="txtBox widthPP" runat="server"
                                    MaxLength="2" />
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneCelularNumero" runat="server" AssociatedControlID="txtTelefoneCelularNumero" />
                                <asp:TextBox ID="txtTelefoneCelularNumero" CssClass="txtBox" runat="server" MaxLength="9" />
                                <asp:Label ID="lblTelefoneCelularObservacao" CssClass="legendForm" runat="server" />
                            </dd>
                        </dl>
                        <!-- Campo Telefone Residencial -->
                        <dl>
                            <dt>
                                <asp:Label ID="lblTelefoneResidencial" runat="server" AssociatedControlID="txtTelefoneResidencialDDD" /></dt>
                            <dd>
                                <asp:Label ID="lblTelefoneResidencialDDD" runat="server" AssociatedControlID="txtTelefoneResidencialDDD" />
                                <asp:TextBox ID="txtTelefoneResidencialDDD" CssClass="txtBox widthPP" runat="server"
                                    MaxLength="2" />
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneResidencialNumero" runat="server" AssociatedControlID="txtTelefoneResidencialNumero" />
                                <asp:TextBox ID="txtTelefoneResidencialNumero" CssClass="txtBox" runat="server" MaxLength="9" />
                                <asp:Label ID="lblTelefoneResidencialObservacao" CssClass="legendForm" runat="server" />
                            </dd>
                        </dl>
                        <!-- Campo Telefone Comercial -->
                        <dl>
                            <dt>
                                <asp:Label ID="lblTelefoneComercial" runat="server" AssociatedControlID="txtTelefoneComercialDDD" /></dt>
                            <dd>
                                <asp:Label ID="lblTelefoneComercialDDD" runat="server" AssociatedControlID="txtTelefoneComercialDDD" />
                                <asp:TextBox ID="txtTelefoneComercialDDD" CssClass="txtBox widthPP" runat="server"
                                    MaxLength="2" />
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneComercialNumero" runat="server" AssociatedControlID="txtTelefoneComercialNumero" />
                                <asp:TextBox ID="txtTelefoneComercialNumero" CssClass="txtBox" runat="server" MaxLength="9" />
                            </dd>
                            <dd>
                                <asp:Label ID="lblTelefoneComercialRamal" runat="server" AssociatedControlID="txtTelefoneComercialRamal" />
                                <asp:TextBox ID="txtTelefoneComercialRamal" CssClass="txtBox widthPP" runat="server"
                                    MaxLength="2" />
                                <asp:Label ID="lblTelefoneComercialObservacao" CssClass="legendForm" runat="server" />
                            </dd>
                        </dl>
                    </fieldset>
                </ContentTemplate>
            </asp:UpdatePanel>
            <fieldset class="final">
                <!-- Campo Nome de usuário -->
                <p>
                    <asp:Label ID="lblNomeUsuario" runat="server" AssociatedControlID="txtNomeUsuario" />
                    <asp:TextBox ID="txtNomeUsuario" runat="server" CssClass="txtBox widthMM" MaxLength="10" />
                    <asp:Label ID="lblNomeUsuarioObservacao" runat="server" CssClass="legendForm" />
                </p>
                <p class="floatLeft">
                    <asp:Label ID="lblSenha" runat="server" AssociatedControlID="txtSenha" />
                    <asp:TextBox ID="txtSenha" runat="server" CssClass="txtBox" TextMode="Password" MaxLength="10" />
                    <asp:Label ID="lblSenhaObservacao" runat="server" CssClass="legendForm" />
                </p>
                <!-- Campo Confirme a senha -->
                <p class="floatLeft">
                    <asp:Label ID="lblConfirmeSenha" runat="server" AssociatedControlID="txtConfirmeSenha" />
                    <asp:TextBox ID="txtConfirmeSenha" runat="server" CssClass="txtBox widthMM" TextMode="Password"
                        MaxLength="10" />
                </p>
            </fieldset>
            <!-- Campo Senha -->
            <!-- Termo e Condições -->
            <br />
            <asp:UpdatePanel ID="uppnlCondicoes" runat="server" UpdateMode="Conditional">
                <Triggers>
                    <asp:AsyncPostBackTrigger ControlID="chkTermoCondicoes" EventName="CheckedChanged" />
                </Triggers>
                <ContentTemplate>
                    <asp:TextBox runat="server" ID="txtTermosCondicoes" Rows="4" Columns="110" CssClass="boxWdt"
                        TextMode="MultiLine" ReadOnly="true" />
                    <p class="termoCondicao">
                        <asp:CheckBox ID="chkTermoCondicoes" runat="server" AutoPostBack="true"  />
                    </p>
                    <p class="line">
                    </p>
                    <p class="botoes">
                        <asp:LinkButton ID="lnkCriarConta" CssClass="button" runat="server" 
                            ValidationGroup="Cadastro" CausesValidation="true" AutoPostBack="true" />
                    </p>
                </ContentTemplate>
            </asp:UpdatePanel>
            <asp:CustomValidator ID="ctvCadastro" runat="server" Display="None" ValidationGroup="Cadastro"
                ClientValidationFunction="fnCustomValidator" />
        </div>
    </div>
</asp:Content>
