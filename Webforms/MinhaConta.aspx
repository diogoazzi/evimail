<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="MinhaConta.aspx.vb" Inherits="WebSiteFrontEnd.MinhaConta" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:UpdatePanel ID="upMinhaConta" runat="server">
        <ContentTemplate>
            <asp:XmlDataSource ID="xml" runat="server" DataFile="~/_Xml/Arquivos.xml"></asp:XmlDataSource>
            <div id="content">
                <h2 class="title">
                    <asp:Literal ID="ltrTitulo" runat="server" /></h2>
                <asp:PlaceHolder ID="pchMainContent" runat="server" Visible="true">
                    <!-- TÍTULO DO SALDO -->
                    <div class="usrAlert">
                        <p>
                            <asp:Literal ID="ltrMensagemSaldoRestanteParte1" runat="server" />
                            <asp:Label ID="lblSaldoRestante" runat="server" />
                            <asp:Literal ID="ltrMensagemSaldoRestanteParte2" runat="server" />
                            <asp:Literal ID="ltrObservacaoCredito" runat="server" /></p>
                    </div>
                    <div id="minhaContaDetails" class="rounded_a">
                        <asp:PlaceHolder ID="pchComCredito" runat="server" Visible="true">
                            <!-- COM CRÉDITO -->
                            <p>
                                <asp:Literal ID="ltrServicoContratadoTitulo" runat="server" Text="Último serviço contratado: " />
                                <asp:Label ID="lblServicoContratado" runat="server" /></p>
                            <p>
                                <asp:Literal ID="ltrQtdEmailsEnviadosTitulo" runat="server" />
                                <asp:Label ID="lblQtdEmailsEnviados" runat="server" /></p>
                            <p>
                                <asp:Literal ID="ltrQtdRestante" runat="server" Text="Quantidade de emails para enviar: " />
                                <asp:Label ID="lblEmailRestante" runat="server" /></p>
                            <p>
                                <asp:Literal ID="ltrDataUltimaCompraTitulo" runat="server" />
                                <asp:Label ID="lblDataUltimaCompra" runat="server" /></p>
                            <p>
                                <asp:Literal ID="ltrDataExpiracaoTitulo" runat="server" />
                                <asp:Label ID="lblDataExpiracao" runat="server" /></p>
                            <p>
                                <asp:Literal ID="ltrDataRenovacao" runat="server" />
                                <asp:Label ID="lblDataRenovacao" runat="server" /></p>
                            <div class="btnContLine">
                                <asp:HyperLink ID="btnAdquirirPlanoCredito" CssClass="btnContratarServico" runat="server"
                                    NavigateUrl="ContratarServico.aspx" Visible="false" Text="Contratar Serviço" />
                            </div>
                            <asp:Panel ID="pnlRenovacao" runat="server" Visible="false">
                                <asp:LinkButton ID="btnCancelarRenovar" CssClass="btnCancelarRenovar" Text="Cancelar Renovação"
                                    runat="server"  >
                                </asp:LinkButton>
                                <asp:HyperLink ID="btnRenovar" CssClass="btnRenovar" Text="Renovar" runat="server"
                                    NavigateUrl="ContratarServico.aspx" Visible="false">
                                </asp:HyperLink>
                            </asp:Panel>
                            <asp:Panel ID="pnlCancelarRenovacao" runat="server" Visible="false">
                                <asp:Label ID="lblCancelaRenovacao" runat="server"></asp:Label>
                                <asp:ImageButton ID="btnSim" runat="server" ImageUrl="~/img/btnSim.png" AlternateText="Sim" />
                                <asp:ImageButton ID="btnNao" runat="server" ImageUrl="~/img/btnNao.png" AlternateText="Não" />
                            </asp:Panel>
                            <%-- <asp:HyperLink ID="btnContratarComCredito" CssClass="btnContratarServico" runat="server"
                                    NavigateUrl="ContratarServico.aspx" Visible="false" />--%>
                        </asp:PlaceHolder>
                        <asp:PlaceHolder ID="pchSemCredito" runat="server" Visible="false">
                            <!-- SEM CRÉDITO -->
                            <p>
                                <asp:Literal ID="ltrUltimoServicoContratadoTitulo" runat="server" Text="Último serviço contratado: " />
                                <asp:Label ID="lblUltimoServicoContratado" runat="server" /></p>
                            <p>
                                <asp:Literal ID="ltrQtdEmailsEnviadosSemCredito" runat="server" />
                                <asp:Label ID="lblQtdEmailsEnviadosSemCredito" runat="server" /></p>
                            <p>
                                <asp:Literal ID="Literal1" runat="server" Text="Quantidade de emails para enviar: " />
                                <asp:Label ID="Label1" runat="server" Text="0" /></p>
                            <p>
                                <asp:Literal ID="ltrUltimoDataCompraTitulo" runat="server" Text="Data da última compra: " />
                                <asp:Label ID="lblUltimoDataCompra" runat="server" /></p>
                            <div class="btnContLine">
                                <asp:HyperLink ID="btnContratarServico" CssClass="btnContratarServico" runat="server"
                                    NavigateUrl="ContratarServico.aspx" />
                            </div>
                        </asp:PlaceHolder>

                        <asp:PlaceHolder ID="pchCreditoEsgotado" runat="server" Visible="false">
                            <!-- PLANO CANCELADO -->
                            <p>
                                <asp:Literal ID="ltrUltimoServicoContratadoTitulo2" runat="server" Text="Último serviço contratado: " />
                                <asp:Label ID="lblUltimoServicoContratado2" runat="server" /></p>
                            <p>
                                <asp:Literal ID="Literal2" runat="server" Text="Quantidade de emails para enviar: " />
                                <asp:Label ID="Label2" runat="server" /></p>
                            <!--Text="Créditos 10 e-mails."-->
                            <p>
                                <asp:Literal ID="ltrUltimoDataCompraTitulo2" runat="server" Text="Data da última compra: " />
                                <asp:Label ID="lblUltimoDataCompra2" runat="server" /></p>
                            <!-- Text="09/12/2010"-->
                            <asp:Panel ID="pnlPlanoExpirado" runat="server" Visible="false" >
                                <asp:Panel ID="pnlDataRenovacao" runat="server">
                                    <p>
                                        <asp:Literal ID="ltrDataRenovacaoTitulo" runat="server" Text="Data da renovação: " />
                                        <asp:Label ID="lblDataRenovacaoTitulo" runat="server" CssClass="tachado" /><!-- Text="09/01/2010"-->
                                        <asp:Label ID="lblMsgNaoRenova" CssClass="msgAviso" runat="server" Text="<br />Esse serviço não será renovado automaticamente."></asp:Label>
                                    </p>
                                </asp:Panel>
                                <asp:Panel ID="pnlDataExpiracao" runat="server">
                                    <p>
                                        <asp:Literal ID="ltrDataExpiracaoTitulo2" runat="server" Text="Data da expiração: " />
                                        <asp:Label ID="lblDataExpiracaoTitulo2" runat="server" />
                                        <div class="btnContLine">
                                            <asp:HyperLink ID="btnContratarEsgotado" CssClass="btnContratarServico" Text="Renovar" runat="server"
                                                NavigateUrl="ContratarServico.aspx">
                                            </asp:HyperLink>
                                        </div>
                                    </p>
                                </asp:Panel>
                            </asp:Panel>
                            <!-- Text="09/01/2010"-->
                            <%--<asp:Panel ID="pnlRenovacaoCancelado" runat="server">
                                <asp:HyperLink ID="btnRenovarCancelado" CssClass="btnRenovar" Text="Renovar" runat="server"
                                    NavigateUrl="#">
                                </asp:HyperLink>
                            </asp:Panel>--%>
                        </asp:PlaceHolder>
                    </div>
                </asp:PlaceHolder>
                <!--/div-->
                <!--/#minhaContaDetails-->
                <asp:UpdatePanel runat="server" ID="uptPanelListaEmails">
                    <ContentTemplate>
                        <div id="minhaContaTable">
                            <asp:ListView ID="lstEmailsEnviados" runat="server">
                                <LayoutTemplate>
                                    <table class="tableStyle">
                                        <thead>
                                            <tr>
                                                <th align="center">
                                                    <%--DATA--%><asp:Literal ID="ltrDataHeader" runat="server" />
                                                </th>
                                                <th align="left">
                                                    <%--ASSUNTO--%><asp:Literal ID="ltrAssuntoHeader" runat="server" />
                                                </th>
                                                <th align="center">
                                                    <%--SALDO--%><asp:Literal ID="ltrSaldoHeader" runat="server" />
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody runat="server" id="itemPlaceholder">
                                        </tbody>
                                    </table>
                                </LayoutTemplate>
                                <ItemTemplate>
                                    <tr>
                                        <td align="center">
                                            <%--00/00/0000--%><asp:Literal ID="ltrDataValue" runat="server" />
                                        </td>
                                        <td align="left">
                                            <%--Loren Ipsum Dolor Amet Simut--%><asp:LinkButton ID="lnkBtnPdf" runat="server"
                                                OnCommand="GerarPdf" />
                                        </td>
                                        <td align="center">
                                            <%--19--%><asp:Literal ID="ltrSaldoValue" runat="server" />
                                        </td>
                                    </tr>
                                </ItemTemplate>
                                <EmptyDataTemplate>
                                    <tr>
                                        <td>
                                            <asp:Literal ID="ltrNenhumEmailEnviado" runat="server" Text="<%$ Resources:Evimail, MinhaConta_ListaEmailsEnviados_NenhumEncontrado %>" />
                                        </td>
                                    </tr>
                                </EmptyDataTemplate>
                            </asp:ListView>
                            <div class="pagination">
                                <span class="paginationMsg">
                                    <%--Mostrando 1 a 5 de 20 emails--%><asp:Literal ID="ltrMensagemPaginacao" runat="server" /></span>
                                <div class="paginationPg">
                                    <small>
                                        <%--Págs:--%><asp:Literal ID="ltrTextoPaginas" runat="server" /></small>
                                    <%--<asp:PlaceHolder ID="phPaginacao" runat="server" />--%>
                                    <asp:DataPager ID="dpgMinhaConta" runat="server" PagedControlID="lstEmailsEnviados"
                                        PageSize="5">
                                        <Fields>
                                            <asp:NumericPagerField ButtonCount="4" CurrentPageLabelCssClass="curPg" NumericButtonCssClass="numPg"
                                                ButtonType="Image" PreviousPageImageUrl="~/img/ico_pagination_left_arrow.gif"
                                                NextPageImageUrl="~/img/ico_pagination_right_arrow.gif" />
                                        </Fields>
                                    </asp:DataPager>
                                </div>
                            </div>
                            <!--/.pagination-->
                        </div>
                        <!--/#minhaContaTable-->
                    </ContentTemplate>
                </asp:UpdatePanel>
                <!--/asp:PlaceHolder-->
                <asp:PlaceHolder ID="pchMsgContent" runat="server" Visible="false">
                    <!-- SEM CREDITO BOX -->
                    <div id="Div1" class="rounded_a boxMsg">
                        <p>
                            <asp:Literal ID="ltlMsgContent" runat="server" Text="Você não possui créditos."></asp:Literal></p>
                        <div class="btnContLine">
                            <asp:LinkButton ID="lnbContratarServico" CssClass="btnContratarServico" runat="server"
                                OnClick="lnbContratarServico_Click" Text="Teste"></asp:LinkButton>
                        </div>
                    </div>
                </asp:PlaceHolder>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
