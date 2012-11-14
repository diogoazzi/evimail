<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="ContratarServico.aspx.vb" Inherits="WebSiteFrontEnd.ContratarServico" %>

<asp:Content ID="ContentHead" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
    <script type="text/javascript">
        $(function () {
            i = 0;
            $('#formaPagamentoLeft ol li').each(function () {
                i++;
                $(this).addClass('li_' + i);
            });
        });
        //
        function fnCustomValidator(source, args) {
            args.IsValid = true;
        };
    </script>
</asp:Content>
<asp:Content ID="ContentBody" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:UpdatePanel runat="server" ID="uppContratarServico">
        <ContentTemplate>
            <div id="content">
                <asp:PlaceHolder ID="pchMainContent" runat="server">
                    <!--Conteudo Principal-->
                    <div class="relative row">
                        <h2 class="title">
                            contratar um serviço</h2>
                        <asp:Panel runat="server" ID="pnlAlertaServico" CssClass="alert">
                            Você ainda não possui um serviço contratado!</asp:Panel>
                    </div>
                    <asp:PlaceHolder ID="pchOptions" runat="server">
                        <!--COM OPÇÃO 1 E 2-->
                        <h5 class="title_1">
                            Escolha o tipo de serviço que deseja contratar:</h5>
                        <asp:Label ID="lblMsgCredUvaia" runat="server" Text='As opções assinaladas com o ícone <span class="icoFolha"></span> podem ser pagas com seus créditos Uvaia.'></asp:Label>
                        <div id="tipoServico">
                            <!--DESABILITADO-->
                            <div>
                                <asp:HiddenField ID="hdnServicoSelecionado" runat="server" /> 
                                <asp:Panel ID="pnlPlano" runat="server">
                                    <div id="tipoServicoLeft">
                                        <div class="opcao opcao1">
                                            <h3>
                                                Planos</h3>
                                            <span>Escolha a quantidade mensal que preferir.</span>
                                        </div>
                                        <div class="boxrounded_a">
                                            <div class="boxroundedCont_a">
                                                <h4>
                                                    Planos disponíveis:</h4>
                                                <fieldset>
                                                    <asp:RadioButtonList ID="rblPlanosDisp" CssClass="radioList" runat="server" RepeatLayout="UnorderedList"
                                                        AutoPostBack="true">
                                                        <asp:ListItem Text='emails/mês - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails/mês - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails/mês - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails/mês - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                    </asp:RadioButtonList>
                                                </fieldset>
                                            </div>
                                            <div class="boxroundedBot_a">
                                            </div>
                                        </div>
                                        <!--/.boxrounded_a-->
                                        <asp:HyperLink ID="btnSaibaMaisSobrePlanos" NavigateUrl="#" runat="server" CssClass="btnSaibaMais openBoxTip">Saiba mais sobre Planos</asp:HyperLink>
                                        <div class="boxTip">
                                            <div class="boxTipCont">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas faucibus nisl
                                                    in purus lacinia ultricies. Curabitur nibh mauris, facilisis et euismod nec, consequat
                                                    vitae libero. Aliquam lectus lacus, tristique quis volutpat ac, adipiscing tincidunt
                                                    risus. Vivamus vitae suscipit nisl. Morbi pretium bibendum diam venenatis bibendum.
                                                    Aliquam erat volutpat. Vivamus
                                                </p>
                                            </div>
                                            <a href="#" class="closeBoxTip">Fechar</a>
                                        </div>
                                    </div>
                                </asp:Panel>
                                <asp:Panel ID="pnlCreditos" runat="server">
                                    <div id="tipoServicoRight">
                                        <div class="opcao opcao2">
                                            <h3>
                                                créditos
                                            </h3>
                                            <span>Adquira créditos com a quantidade de emails que deseja enviar (1 crédito = 1 e-mail).</span>
                                        </div>
                                        <div class="boxrounded_a">
                                            <div class="boxroundedCont_a">
                                                <h4>
                                                    Pacotes disponíveis:</h4>
                                                <fieldset>
                                                    <asp:RadioButtonList ID="rblCreditosDisp" CssClass="radioList" runat="server" RepeatLayout="UnorderedList"
                                                        AutoPostBack="true">
                                                        <asp:ListItem Text='emails - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails - <span class="credUvaia">R$</span>'></asp:ListItem>
                                                    </asp:RadioButtonList>
                                                </fieldset>
                                            </div>
                                            <div class="boxroundedBot_a">
                                            </div>
                                        </div>
                                        <!--/.boxrounded_a-->
                                        <asp:HyperLink ID="btnSaibaMaisSobreCreditos" NavigateUrl="#" runat="server" CssClass="btnSaibaMais openBoxTip">Saiba mais sobre Créditos</asp:HyperLink>
                                        <div class="boxTip">
                                            <div class="boxTipCont">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas faucibus nisl
                                                    in purus lacinia ultricies. Curabitur nibh mauris, facilisis et euismod nec, consequat
                                                    vitae libero. Aliquam lectus lacus, tristique quis volutpat ac, adipiscing tincidunt
                                                    risus. Vivamus vitae suscipit nisl. Morbi pretium bibendum diam venenatis bibendum.
                                                    Aliquam erat volutpat. Vivamus
                                                </p>
                                            </div>
                                            <a href="#" class="closeBoxTip">Fechar</a>
                                        </div>
                                    </div>
                                </asp:Panel>
                            </div>
                            <!--fecharDESABILITADO-->
                            <!--/#tipoServicoLeft-->
                            <div>
                                <asp:Panel ID="pnlPlanosIndisp" runat="server" Visible="true">
                                    <div id="tipoServicoLeft1">
                                        <div class="desabilita1_box">
                                        </div>
                                        <div class="opcao opcao1">
                                            <h3>
                                                Planos indisponíveis</h3>
                                            <span>Escolha um período para enviar quantos e-mails quiser.</span>
                                        </div>
                                        <div class="boxrounded_a">
                                            <div class="boxroundedCont_a">
                                                <h4>
                                                    Planos disponíveis:</h4>
                                                <fieldset>
                                                    <asp:RadioButtonList ID="rblPlanosIndisp" CssClass="radioList" runat="server" RepeatLayout="UnorderedList"
                                                        AutoPostBack="true" Enabled="false">
                                                        <asp:ListItem Text='emails/mês - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails/mês - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails/mês - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails/mês - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                    </asp:RadioButtonList>
                                                </fieldset>
                                            </div>
                                            <div class="boxroundedBot_a">
                                            </div>
                                        </div>
                                        <!--/.boxrounded_a-->
                                        <asp:HyperLink ID="HyperLink1" NavigateUrl="#" runat="server" CssClass="btnSaibaMais openBoxTip">Saiba mais sobre Planos</asp:HyperLink>
                                        <div class="boxTip">
                                            <div class="boxTipCont">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas faucibus nisl
                                                    in purus lacinia ultricies. Curabitur nibh mauris, facilisis et euismod nec, consequat
                                                    vitae libero. Aliquam lectus lacus, tristique quis volutpat ac, adipiscing tincidunt
                                                    risus. Vivamus vitae suscipit nisl. Morbi pretium bibendum diam venenatis bibendum.
                                                    Aliquam erat volutpat. Vivamus
                                                </p>
                                            </div>
                                            <a href="#" class="closeBoxTip">Fechar</a>
                                        </div>
                                    </div>
                                </asp:Panel>
                                <asp:Panel ID="pnlCreditosIndisp" runat="server">
                                    <div id="tipoServicoRight2">
                                        <div class="desabilita2_box">
                                        </div>
                                        <div class="opcao opcao2">
                                            <h3>
                                                créditos indisponíveis
                                            </h3>
                                            <span>Adquira créditos com a quantidade de emails que deseja enviar (1 crédito = 1 e-mail).</span>
                                        </div>
                                        <div class="boxrounded_a">
                                            <div class="boxroundedCont_a">
                                                <h4>
                                                    Pacotes disponíveis:</h4>
                                                <fieldset>
                                                    <asp:RadioButtonList ID="rblCreditosIndisp" CssClass="radioList" runat="server" RepeatLayout="UnorderedList"
                                                        AutoPostBack="true" Enabled="false">
                                                        <asp:ListItem Text='emails - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                        <asp:ListItem Text='emails - <span class="semCredUvaia">R$</span>'></asp:ListItem>
                                                    </asp:RadioButtonList>
                                                </fieldset>
                                            </div>
                                            <div class="boxroundedBot_a">
                                            </div>
                                        </div>
                                        <!--/.boxrounded_a-->
                                        <asp:HyperLink ID="HyperLink2" NavigateUrl="#" runat="server" CssClass="btnSaibaMais openBoxTip">Saiba mais sobre Créditos</asp:HyperLink>
                                        <div class="boxTip">
                                            <div class="boxTipCont">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas faucibus nisl
                                                    in purus lacinia ultricies. Curabitur nibh mauris, facilisis et euismod nec, consequat
                                                    vitae libero. Aliquam lectus lacus, tristique quis volutpat ac, adipiscing tincidunt
                                                    risus. Vivamus vitae suscipit nisl. Morbi pretium bibendum diam venenatis bibendum.
                                                    Aliquam erat volutpat. Vivamus
                                                </p>
                                            </div>
                                            <a href="#" class="closeBoxTip">Fechar</a>
                                        </div>
                                    </div>
                                </asp:Panel>
                            </div>
                            <!--fechaDESABILITADO-->
                            <!--/#tipoServicoRight-->
                        </div>
                    </asp:PlaceHolder>
                    <asp:PlaceHolder ID="pchCreditOnly" runat="server"></asp:PlaceHolder>
                    <!--/#tipoServico-->
                    
                    <div id="formaPagamento">
                        <div id="formaPagamentoLeft">
                            <div class="boxrounded_a">
                                <div class="boxroundedCont_a">
                                    <h4>
                                        Cartões de crédito disponíveis:</h4>
                                    <fieldset class="formPagamentoCard">
                                        <asp:RadioButtonList ID="rblBandeiraCartao" CssClass="bandeiraCartao" runat="server"
                                            RepeatLayout="OrderedList" AutoPostBack="true">
                                            <%--<asp:ListItem Value="American Express"><span><img src="../img/site/american-express.gif" alt="AMEX" title="AMEX" /></span>AMEX</asp:ListItem>--%>
                                            <asp:ListItem Value="Mastercard"><span><img src="../img/site/mastercard.gif" alt="Mastercard" title="Mastercard" /></span>Mastercard</asp:ListItem>
                                            <asp:ListItem Value="Visa"><span><img src="../img/site/visa.gif" alt="Visa" title="Visa" /></span>Visa</asp:ListItem>
                                            <asp:ListItem Value="Créditos Uvaia" Enabled="false"><span><img src="../img/credUvaia.png" alt="Créditos Uvaia" title="Créditos Uvaia" /></span><strong>Créditos Uvaia</strong><a target="_blank" href="http://www.uvaia.com.br/webforms/Default.aspx" class="linkUvaia">Conheça o Uvaia</a></asp:ListItem>
                                        </asp:RadioButtonList>
                                        <div class="boxTip">
                                            <div class="boxTipCont">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas faucibus nisl
                                                    in purus lacinia ultricies. Curabitur nibh mauris, facilisis et euismod nec, consequat
                                                    vitae libero. Aliquam lectus lacus, tristique quis volutpat ac, adipiscing tincidunt
                                                    risus. Vivamus vitae suscipit nisl. Morbi pretium bibendum diam venenatis bibendum.
                                                    Aliquam erat volutpat. Vivamus
                                                </p>
                                            </div>
                                            <a href="#" class="closeBoxTip">Fechar</a>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="boxroundedBot_a">
                                </div>
                            </div>
                            <!--/.boxrounded_a-->
                        </div>
                        <!--/#formaPagamentoLeft-->
                        <div id="formaPagamentoRight">
                            <fieldset>
                                <asp:PlaceHolder ID="plchldrCartao" runat="server">
                                    <!--Era o q já estava programado-->
                                    <div>
                                        <asp:Label ID="lblNomeCartao" AssociatedControlID="tbNomeCartao" runat="server" CssClass="lblTextbox">Nome impresso no cartão:</asp:Label>
                                        <asp:TextBox ID="tbNomeCartao" runat="server" CssClass="textbox"></asp:TextBox>
                                    </div>
                                   
                                </asp:PlaceHolder>
                                <asp:PlaceHolder ID="pchNaoSelect" runat="server">
                                    <div class="formPagamento">
                                        <p>
                                            <asp:Literal ID="ltlFormPagamento" runat="server" Text="Forma do Pagamento: "></asp:Literal>
                                            <asp:Label ID="lblFormPagamento" runat="server" Text="não selecionado"></asp:Label>
                                        </p>
                                        <asp:PlaceHolder ID="pchComFormPag" runat="server">
                                            <p>
                                                <asp:Literal ID="ltlServico" runat="server" Text="Serviço escolhido: "></asp:Literal>
                                                <asp:Label ID="lblServico" runat="server"></asp:Label>
                                            </p>
                                            <asp:CheckBox ID="cbxRenovar" CssClass="cbxRenovar" runat="server" Text="Renovar serviço mensalmente"
                                                Visible="false" />
                                            <asp:PlaceHolder ID="pchComCredUvaia" runat="server" Visible="false">
                                                <div class="loginUvaia">
                                                    <p>
                                                        <asp:Label ID="lblUserUvaia" AssociatedControlID="txtUserUvaia" runat="server" Text="Usuário Uvaia"></asp:Label>
                                                        <asp:TextBox ID="txtUserUvaia" runat="server"></asp:TextBox>
                                                    </p>
                                                    <p>
                                                        <asp:Label ID="lblPassUvaia" AssociatedControlID="txtPassUvaia" runat="server" Text="Senha Uvaia"></asp:Label>
                                                        <asp:TextBox ID="txtPassUvaia" runat="server" TextMode="Password"></asp:TextBox>
                                                    </p>
                                                </div>
                                            </asp:PlaceHolder>
                                        </asp:PlaceHolder>
                                    </div>
                                </asp:PlaceHolder>
                            </fieldset>
                        </div>

                        <!--/#formaPagamentoRight-->
                        <div class="btnContLine">
                            <contenttemplate>
                            <asp:Label ID="lblMsgCielo" CssClass="msgCielo" runat="server" Text="Você será redirecionado para o site da Cielo" visible="false" ></asp:Label>
                            <asp:LinkButton ID="btnConcluirCompra" runat="server" CssClass="btnConcluirCompra"
                                Text="Concluir Compra" ValidationGroup="Contratar" ></asp:LinkButton>
                        </contenttemplate>
                        </div>
                    </div>
                    <!--/#formaPagamento-->
                    <asp:CustomValidator ID="ctvContratar" runat="server" Display="None" ValidationGroup="Contratar"
                        ClientValidationFunction="fnCustomValidator" />
                </asp:PlaceHolder>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
