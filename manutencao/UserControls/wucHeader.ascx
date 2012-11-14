<%@ Control Language="vb" AutoEventWireup="false" CodeBehind="wucHeader.ascx.vb" Inherits="WebSiteFrontEnd.wucHead" ClientIDMode="Static" %>
<asp:Panel ID="header" runat="server" CssClass="headerNaoLogado">
    <div id="headerCont">
        <h1 id="logo" runat="server"><a href="../Webforms/Default.aspx">Evimail Evidência</a></h1>
        <asp:Menu ID="menuHeader" runat="server" IncludeStyleBlock="False" SkipLinkText="">
            <Items>
                <asp:MenuItem Value="Home" NavigateUrl="~/Webforms/Default.aspx" />
                <asp:MenuItem Value="Quem Somos" NavigateUrl="~/Webforms/QuemSomos.aspx" />
                <asp:MenuItem Value="Perguntas Frequentes" NavigateUrl="~/Webforms/PerguntasFrequentes.aspx" />
                <asp:MenuItem Value="Fale Conosco" NavigateUrl="~/Webforms/FaleConosco.aspx" />
            </Items>
        </asp:Menu>
        <asp:Panel ID="pnlNaoLogado" runat="server" Visible="false">
            <div class="left">
                <span><asp:Literal runat="server" ID="ltlTituloBotaoLogin"></asp:Literal></span>
                <asp:HyperLink ID="lnkLogar" runat="server" NavigateUrl="~/Webforms/Login.aspx" />
            </div>
            <div class="right">
                <span><asp:Literal runat="server" ID="ltlTituloBotaoCadastrar"></asp:Literal></span>
                <asp:HyperLink ID="lnkCadastrar" runat="server" NavigateUrl="~/Webforms/Cadastro.aspx" />
            </div>
        </asp:Panel>
        <asp:Panel ID="pnlLogado" runat="server" Visible="false">
            <div id="divLogadoCont">
                <asp:LinkButton ID="lnkSair" runat="server" />
                <p class="firstChild">Olá,&nbsp;<asp:Literal ID="ltrUsuario" runat="server" /></p>
                <p><asp:Literal ID="ltrCredito" runat="server" /></p>
            </div>
        </asp:Panel>
    </div>
    <!--/#headerCont-->
    <div id="menuUsrLogado" runat="server" visible="false">
        <ul id="ulsrLogado" runat="server">
            <li id="menuUsrLogado_Conta" runat="server"><a href="MinhaConta.aspx"><span>Minha Conta</span></a></li>
            <li id="menuUsrLogado_Dados" runat="server"><a href="AlteraDado.aspx"><span>Alterar Dados</span></a></li>
            <li id="menuUsrLogado_Emails" runat="server"><!-- class="selected"--><a href="GerenciarEmails.aspx"><span>Gerenciar Emails Adicionais</span></a></li>
            <li id="menuUsrLogado_Contratar" runat="server"><a href="ContratarServico.aspx"><span>Contratar um Serviço</span></a></li>
            <li id="menuUsrLogado_Historico" runat="server"><a href="ConsultarHistorico.aspx"><span>Consultar Histórico de Emails</span></a></li>
        </ul>
    </div>
</asp:Panel>