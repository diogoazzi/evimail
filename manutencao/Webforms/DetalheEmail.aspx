<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="DetalheEmail.aspx.vb" Inherits="WebSiteFrontEnd.DetalheEmail" %>

<%@ Register Src="../UserControls/wucDetalhesEmail.ascx" TagName="wucDetalhesEmail"
    TagPrefix="uc1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <div id="content">
        <div class="head">
          <%--Consultar Histórico de Emails--%>
          <%--  <h3 class="title">
              <asp:Literal ID="ltrTituloMenu" runat="server" /></h3>--%>
            <h2 class="title">
                <%--Detalhes do Email--%><asp:Literal ID="ltrTituloPagina" runat="server" /></h2>
            <p class="title">
                <asp:HyperLink ID="lnkVoltar" NavigateUrl="~/Webforms/ConsultarHistorico.aspx"  runat="server" /></p>
        </div>
        <div class="body">
            <div>
                <p class="assunto">
                    <asp:Label ID="lblTituloAssunto" runat="server" />
                    <asp:Literal ID="ltrTextoAssunto" runat="server" />
                </p>
                <asp:ListView ID="lsvDestinatarios" runat="server">
                    <LayoutTemplate>
                        <table class="tableStyle">
                            <tr>
                                <th rowspan="2">
                                    <asp:Literal ID="ltrEmailHeader" runat="server" />
                                </th>
                                <th colspan="3">
                                    <asp:Literal ID="ltrRecebimentoHeader" runat="server" />
                                </th>
                                <th rowspan="2">
                                    <asp:Literal ID="ltrDataConfirmacaoHeader" runat="server" />
                                </th>
                            </tr>
                            <tr class="subTitle">
                                <th>
                                    <asp:Literal ID="ltrStatusHeader" runat="server" />
                                </th>
                                <th>
                                    <asp:Literal ID="ltrLeituraConteudoHeader" runat="server" />
                                </th>
                                <th>
                                    <asp:Literal ID="ltrLeituraAnexoHeader" runat="server" />
                                </th>
                            </tr>
                            <tr>
                                <td runat="server" id="itemPlaceholder">
                                </td>
                            </tr>
                        </table>
                    </LayoutTemplate>
                    <ItemTemplate>
                        <tr>
                            <td>
                                <asp:Literal ID="ltrEmailValue" runat="server" />
                            </td>
                            <td>
                                <asp:Literal ID="ltrStatusValue" runat="server" />
                            </td>
                            <td>
                                <%--CssClass='<%# Eval("conteudo")%>'--%>
                                <asp:Label ID="lblLeituraConteudoValue" runat="server" />
                            </td>
                            <td>
                                <%--CssClass='<%# Eval("anexos")%>'--%>
                                <asp:Label ID="lblLeituraAnexoValue" runat="server" />
                            </td>
                            <td>
                                <asp:Literal ID="ltrDataConfirmacaoValue" runat="server" />
                            </td>
                        </tr>
                    </ItemTemplate>
                </asp:ListView>
                <p class="legendDetalhe">
                    <span>
                        <asp:Literal ID="ltrPendente" runat="server" />
                    </span><span>
                        <asp:Literal ID="ltrConfirmado" runat="server" />
                    </span>
                </p>
            </div>
            <uc1:wucDetalhesEmail ID="ucDetalhesEmail" runat="server" />
        </div>
    </div>
</asp:Content>
