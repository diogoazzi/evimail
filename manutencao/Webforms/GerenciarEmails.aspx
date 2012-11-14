<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master" CodeBehind="GerenciarEmails.aspx.vb" Inherits="WebSiteFrontEnd.geraEmailAdicional" %>
<asp:Content ID="ContenteHead" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
<script type="text/javascript" language="javascript">
    function fnCustomValidator(source, args) {
        args.IsValid = true;
    };
</script>
</asp:Content>
<asp:Content ID="ContenteBody" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
<div id="content"> 
    <h2 class="title"><asp:Literal ID="ltlTitulo" Text="Gerenciar emails adicionais" runat="server"></asp:Literal></h2>
    <div class="body">
        <asp:UpdatePanel runat="server" ID="UpdatePanelEmailAdicional">
            <ContentTemplate>
                <p><asp:Label ID="lblNumEmailAdd" runat="server" /></p>
                <fieldset>
                    <div class="bordaTop"></div>
                        <div>
                            <p class="info"><asp:Literal ID="ltlBodyInfo" Text="Você pode cadastrar até 3 emails adicionais" runat="server"></asp:Literal></p>
                            <p class="emailAdd">
                                <asp:Label ID="lblEmailTitular" Text="Email Titular: " runat="server" AssociatedControlID="ltlEmailTitular" />
                                <asp:Literal ID="ltlEmailTitular" runat="server" />
                            </p>
                            <asp:ListView runat="server" ID="ListViewEmails" DataKeyNames="CodUsuarioEmail">
                                <ItemTemplate>
                                    <div class="emailAdd">
                                        <p>
                                            <asp:Literal runat="server" ID="ltlEmail" /> 
                                            <asp:Literal runat="server" ID="ltlEnderecoEmail" />
                                        </p>
                                        <asp:LinkButton runat="server" ID="lnkRemover" CssClass="remove" CommandName="Remover" />
                                         <asp:Panel ID="pnlRemover" runat="server" Visible="false">                       
                                           <br /><br /><br /> Deseja realmente remover este email?
                                           <div class="btn_sn">
                                            <asp:ImageButton ID="btnSim" runat="server" ImageUrl="~/img/btnSim.png" AlternateText="Sim" CommandName="RemoverSim" />
                                           
                                            <asp:ImageButton ID="btnNao" runat="server" ImageUrl="~/img/btnNao.png" AlternateText="Não" CommandName="RemoverNao"  />
                                            </div>
                                        </asp:Panel>
                                    </div>
                                </ItemTemplate>
                            </asp:ListView>
                            <asp:Panel runat="server" ID="pnlEmailAdicional" class="emailAdd">
                                <p>
                                    <%--<asp:ValidationSummary ID="vsCadastro" runat="server" DisplayMode="SingleParagraph" ValidationGroup="Cadastro" />--%>
                                </p>
                                <p>
                                    <asp:Label runat="server" ID="lblEmailAdicional" AssociatedControlID="txtEmailAdicional" />
                                    <asp:TextBox runat="server" ID="txtEmailAdicional" CssClass="txtBox" ValidationGroup="Cadastro"></asp:TextBox>
                                   <%-- <asp:RequiredFieldValidator ID="rfvEmail" runat="server" ControlToValidate="txtEmailAdicional" Display="None"
                                     ValidationGroup="Cadastro" ErrorMessage="Digite um e-mail válido!" />
                                    <asp:RegularExpressionValidator ID="revEmail" runat="server" ControlToValidate="txtEmailAdicional" Text="*" 
                                    ValidationExpression="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" 
                                    ValidationGroup="Cadastro" Display="None" ErrorMessage="Digite um e-mail válido!" />--%>
                                </p>
                                <asp:LinkButton runat="server" ID="lnkCadastrar" CssClass="button" Text="<span>CADASTRAR</span>" OnClientClick="return true;" 
                                ValidationGroup="Cadastro" />
                                <asp:CustomValidator ID="ctvGerenciarEmails" runat="server" Display="None" ValidationGroup="Cadastro"
                                ClientValidationFunction="fnCustomValidator" />
                            </asp:Panel>
                        </div>
                    <div class="bordaBottom"></div>
                </fieldset>
            </ContentTemplate>
        </asp:UpdatePanel>
    </div>
</div>
</asp:Content>