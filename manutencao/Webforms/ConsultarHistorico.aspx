<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="ConsultarHistorico.aspx.vb" Inherits="WebSiteFrontEnd.ConsultarHistorico" %>

<%@ Register Assembly="AjaxControlToolkit" Namespace="AjaxControlToolkit" TagPrefix="ajaxToolkit" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
    <link rel="stylesheet" href="../css/lib/jquery-ui-datepicker.css" />
    <script type="text/javascript" src="../js/lib/jquery.ui.core.js"></script>
    <script type="text/javascript" src="../js/lib/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="../js/lib/jquery.ui.datepicker-pt-BR.js"></script>
    <script type="text/javascript">
        $(function () {
            var dates = $('#ContentPlaceHolder1_txtDataIni, #ContentPlaceHolder1_txtDataFim').datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                onSelect: function (selectedDate) {
                    var option = this.id == 'ContentPlaceHolder1_txtDataIni' ? 'minDate' : 'maxDate';
                    var instance = $(this).data('datepicker');
                    var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                    dates.not(this).datepicker('option', option, date);
                }
            });

            $('.calendar').click(function () {
                $(this).prev('.textbox').focus();
            });
        });

        function linhaSelecionada(linha, selecionado) {
            //var tabela = document.getElementById(idTabela);
            var linha = tabela.getgetElementsByTagName("tr");


        }
        
        function checkDate(sender, args) {
            if (sender._selectedDate > new Date()) {
                alert("Você não pode selecionar uma data futura!");
                sender._selectedDate = new Date();
                // seleciona a data atual novamente
                sender._textbox.set_Value(sender._selectedDate.format(sender._format))
            }
        }

        function checkDateTxtBox(sender) {

            var txtdate = sender.val()

            var typedDate = new Date(txtdate)
            var today = new Date()

            if (typedDate > today) {

                var day = today.getDate()
                if (day < 10) { day = "0" + day }

                var month = eval(today.getMonth() + 1)
                if (month < 10) { month = "0" + month }

                var year = today.getFullYear()

                var newTxtDate = day + "/" + month + "/" + year

                sender.val(newTxtDate)

            }
        }

        $(document).ready(function () {
            $(".txtDataIni, .txtDataFim").blur(function () {
                checkDateTxtBox($(this));
            })
        })

    </script>
    <style type="text/css">
        /*selecionado*/
        .linhaHistoricoSelecionada
        {
            background-color: #f6f8fa !important;
        }
        /*desSelecionado*/
        .linhaHistoricoDesSelecionada
        {
            background-color: #ffffff !important;
        }
    </style>
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:XmlDataSource ID="xml" runat="server" DataFile="~/_Xml/Arquivos.xml"></asp:XmlDataSource>
    <div id="content">
        <h2 class="title">
            Consultar Histórico de Emails</h2>
        <div id="procurarEmail">
            <h5 class="title_1">
                Procurar e-mail:</h5>
            <div class="rounded_a">
                <asp:ValidationSummary runat="server" ID="vldsmyHistorico" DisplayMode="List" ValidationGroup="Historico" />
                <fieldset>
                    <div class="campoHistorico">
                        <asp:Label runat="server" ID="lblDirecao" AssociatedControlID="ddlDirecao" CssClass="lblTextbox"
                            Text="Direção"></asp:Label>
                        <asp:DropDownList runat="server" ID="ddlDirecao">
                            <asp:ListItem Value="0" Text="Indiferente"></asp:ListItem>
                            <asp:ListItem Value="1" Text="Enviado"></asp:ListItem>
                            <asp:ListItem Value="2" Text="Recebido"></asp:ListItem>
                        </asp:DropDownList>
                    </div>
                    <div class="campoHistorico">
                        <asp:Label ID="lblAssunto" AssociatedControlID="txtAssunto" runat="server" CssClass="lblTextbox">Assunto:</asp:Label>
                        <asp:TextBox ID="txtAssunto" runat="server" CssClass="textbox" MaxLength="40"></asp:TextBox>
                    </div>
                    <div class="campoHistorico">
                        <asp:Panel runat="server" ID="pnlRemetente" Visible="true">
                            <asp:Label ID="lblRemetente" AssociatedControlID="txtRemetente" runat="server" CssClass="lblTextbox">Remetente:</asp:Label>
                            <asp:TextBox ID="txtRemetente" runat="server" CssClass="textbox" MaxLength="40"></asp:TextBox>
                        </asp:Panel>
                    </div>
                    <div class="campoHistorico">
                        <asp:Label ID="lblDestinatario" AssociatedControlID="txtDestinatario" runat="server"
                            CssClass="lblTextbox" >Destinatário:</asp:Label>
                        <asp:TextBox ID="txtDestinatario" runat="server" CssClass="textbox" MaxLength="40"></asp:TextBox>
                    </div>
                    <div class="campoHistorico">
                        <asp:Label runat="server" ID="lblAnexos" AssociatedControlID="ddlAnexos" CssClass="lblTextbox"
                            Text="Anexos"></asp:Label>
                        <asp:DropDownList runat="server" ID="ddlAnexos">
                            <asp:ListItem Value="0" Text="Indiferente"></asp:ListItem>
                            <asp:ListItem Value="1" Text="Sem Anexos"></asp:ListItem>
                            <asp:ListItem Value="2" Text="Com Anexos"></asp:ListItem>
                        </asp:DropDownList>
                    </div>
                    <div class="campoHistorico">
                        <asp:Label ID="lblStatus" AssociatedControlID="ddlStatus" runat="server" CssClass="lblTextbox">Status:</asp:Label>
                        <asp:DropDownList runat="server" ID="ddlStatus">
                            <asp:ListItem Value="0" Text="Indiferente"></asp:ListItem>
                            <asp:ListItem Value="1" Text="Pendente"></asp:ListItem>
                            <asp:ListItem Value="2" Text="Recebido"></asp:ListItem>
                            <asp:ListItem Value="3" Text="Confirmado - Conteúdo"></asp:ListItem>
                            <asp:ListItem Value="4" Text="Confirmado - Anexos"></asp:ListItem>
                            <asp:ListItem Value="5" Text="Confirmado - Conteúdo e Anexos"></asp:ListItem>
                        </asp:DropDownList>
                    </div>
                    <div>
                        <asp:Label runat="server" ID="lblDataIni" CssClass="lblTextbox" AssociatedControlID="txtDataInicial">Período de:</asp:Label>
                        <asp:TextBox runat="server" ID="txtDataInicial" CssClass="textbox txtDataIni"></asp:TextBox>
                        <asp:LinkButton ID="calendar_ini" ToolTip="Calendário" runat="server" CausesValidation="False"> 
                            <img src="../img/ico_calendar.gif" width="32" height="28" alt="Calendário" style="margin:0 9px 0 0; vertical-align:bottom; " />                             
                        </asp:LinkButton>
                        <ajaxToolkit:CalendarExtender ID="CalendarExtender1" runat="server" FirstDayOfWeek="Sunday"
                            TargetControlID="txtDataInicial" PopupButtonID="calendar_ini" Format="dd/MM/yyyy"
                            PopupPosition="Right" OnClientDateSelectionChanged="checkDate" />
                        <asp:RegularExpressionValidator ID="RegularExpressionValidator1" runat="server" ErrorMessage="Data inválida"
                            ControlToValidate="txtDataInicial" ValidationExpression="([0][1-9]|[1|2][0-9]|[3][0|1])[/]([0][1-9]|[1][0-2])[/]([0-9]{4})">
                        </asp:RegularExpressionValidator>
                        <asp:Label runat="server" ID="lblDataFim" AssociatedControlID="txtDataFinal">a</asp:Label>
                        <asp:TextBox runat="server" ID="txtDataFinal" CssClass="textbox txtDataFim"></asp:TextBox>
                        <asp:LinkButton ID="calendar_fim" ToolTip="Calendário" runat="server" CausesValidation="False">   
                            <img src="../img/ico_calendar.gif" width="32" height="28" alt="Calendário" style="margin:0 9px 0 0; vertical-align:bottom; " />                        
                        </asp:LinkButton>
                        <ajaxToolkit:CalendarExtender ID="CalendarExtender2" runat="server" FirstDayOfWeek="Sunday"
                            TargetControlID="txtDataFinal" PopupButtonID="calendar_fim" Format="dd/MM/yyyy"
                            PopupPosition="Right" OnClientDateSelectionChanged="checkDate" />
                        <asp:RegularExpressionValidator ID="RegularExpressionValidator2" runat="server" ErrorMessage="Data inválida"
                            ControlToValidate="txtDataFinal" ValidationExpression="([0][1-9]|[1|2][0-9]|[3][0|1])[/]([0][1-9]|[1][0-2])[/]([0-9]{4})">
                        </asp:RegularExpressionValidator>
                    </div>
                    <div class="btnContLine">
                        <asp:Label ID="lblErro" runat="server"></asp:Label>
                        <asp:LinkButton ID="btnProcurar" runat="server" CssClass="btnProcurar">Procurar</asp:LinkButton>
                    </div>
                </fieldset>
            </div>
        </div>
        <!--/#procurarEmail-->
        <div style="text-align: center;">
            <asp:Literal ID="ltrSemResultados" runat="server" Text=""></asp:Literal>
        </div>
        <div class="row">
            <%'DataSourceID="xml"%>
            <asp:ListView ID="lstHistorico" runat="server">
                <LayoutTemplate>
                    <table class="tableStyle">
                        <thead>
                            <tr>
                                <th align="center">
                                    DATA
                                </th>
                                <th align="left">
                                    Remetente
                                </th>
                                <th align="left">
                                    Destinatário
                                </th>
                                <th align="left">
                                    Assunto
                                </th>
                                <th align="center">
                                    Anexos
                                </th>
                                <th align="center">
                                    PDF
                                </th>
                                <th align="center">
                                    Entregue
                                </th>
                                <th align="center">
                                    Conteúdo
                                </th>
                                <th align="center">
                                    Anexos
                                </th>
                                <th align="center">
                                    Enviado/ recebido
                                </th>
                            </tr>
                        </thead>
                        <tbody runat="server" id="itemPlaceholder">
                        </tbody>
                    </table>
                </LayoutTemplate>
                <ItemTemplate>
                    <tr class="tableStyle">
                        <%--<tr class="linhaHistoricoDesSelecionada" onmouseover="this.className='linhaHistoricoSelecionada'" onmouseout="this.className='linhaHistoricoDesSelecionada'">--%>
                        <td align="center">
                            <asp:Literal runat="server" ID="ltlItemDataEnvio" />
                        </td>
                        <td align="left">
                            <asp:Literal runat="server" ID="ltlItemRemetente" />
                        </td>
                        <td align="left">
                            <asp:Literal runat="server" ID="ltlItemDestinatario" />
                        </td>
                        <td align="left">
                            <asp:HyperLink runat="server" ID="lnkItemAssunto"></asp:HyperLink>
                        </td>
                        <td align="center">
                            <asp:Image runat="server" ID="imgItemComAnexo" />
                        </td>
                        <td align="center">
                            <asp:ImageButton runat="server" ID="btnPdf" OnCommand="GerarPdf" />
                        </td>
                        <td align="center">
                            <asp:Image runat="server" ID="imgItemEntregue" />
                        </td>
                        <td align="center">
                            <asp:Image runat="server" ID="imgItemConteudo" />
                        </td>
                        <td align="center">
                            <asp:Image runat="server" ID="imgItemAnexos" />
                        </td>
                        <td align="center">
                            <asp:Literal runat="server" ID="ltlItemDirecao" />
                        </td>
                    </tr>
                </ItemTemplate>
                <EmptyItemTemplate>
                    <tr>
                        <td colspan="9">
                            <asp:Literal runat="server" ID="ltlHistoricoVazio" Text="Nenhum e-mail encontrado!"></asp:Literal>
                        </td>
                    </tr>
                </EmptyItemTemplate>
            </asp:ListView>
            <div class="pagination">
                <span class="paginationMsg">
                    <asp:Literal ID="ltrMensagemPaginacao" runat="server" />
                    <asp:Panel ID="pnlLegenda" runat="server" Visible="false" CssClass="legendaConfirmacao">
                        <img src="../img/ico_nao.gif" alt="Confirmação Pendente" />
                        <asp:Literal ID="ltrLegendaPendente" runat="server" Text="Confirmação Pendente"></asp:Literal>
                        <span class="imagem_icoSim">
                            <img src="../img/ico_sim.gif" alt="Confirmado" />
                            <asp:Literal ID="ltrLegendaConfirmado" runat="server" Text="Confirmado"></asp:Literal>
                        </span>
                    </asp:Panel>
                </span>
                <div class="paginationPg">
                    <small>
                        <asp:Literal ID="ltrTextoPaginas" runat="server" /></small>
                    <asp:DataPager ID="dpgMinhaConta" runat="server" PagedControlID="lstHistorico">
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
        <!--/.row-->
    </div>
</asp:Content>
