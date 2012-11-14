<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="FaleConosco.aspx.vb" Inherits="WebSiteFrontEnd.FaleConosco" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">

    <script type="text/javascript" language="javascript">
        function fnCustomValidator(source, args) {
            args.IsValid = true;
        };

        function limitTextArea(sender, limit) {
            if (sender.val().length > limit) {
                var trunc = sender.val().substr(0, limit);
                sender.val(trunc);
            }
        }

        $(document).ready(function () {
            $("#ContentPlaceHolder_Body_txtMensagem").keyup(function () {
                limitTextArea($(this), 1024)
            })
        })

    </script>
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:UpdatePanel ID="upFaleConosco" runat="server" UpdateMode="Conditional" ChildrenAsTriggers="false">
        <Triggers>
            <asp:AsyncPostBackTrigger ControlID="btnEnviar" EventName="Click" />
        </Triggers>
        <ContentTemplate>
            <div id="content">
                <h2 class="title">
                    Fale Conosco</h2>
                <div class="entryContent" id="faleConoscoForm">
                    <fieldset>
                        <asp:Label ID="lblCampoObrigatorio" runat="server" Text="Label" CssClass="campo_obrigatorio"></asp:Label>
                        <div>
                            <asp:Label ID="lblNome" runat="server" AssociatedControlID="txtNome"></asp:Label>
                            <asp:TextBox ID="txtNome" runat="server" CssClass="textbox" MaxLength="100"></asp:TextBox>
                        </div>
                        <div>
                            <asp:Label ID="lblEmail" runat="server" AssociatedControlID="txtEmail"></asp:Label>
                            <asp:TextBox ID="txtEmail" runat="server" CssClass="textbox" MaxLength="50"></asp:TextBox>
                          
                        </div>
                        <div>
                            <asp:Label ID="lblAssunto" runat="server" AssociatedControlID="ddlAssunto"></asp:Label>
                            <!--<asp:TextBox ID="txtAssunto" runat="server" CssClass="textbox" MaxLength="30"></asp:TextBox>-->
                            <asp:DropDownList ID="ddlAssunto" runat="server" CssClass="select">
                                                <asp:ListItem>Selecione</asp:ListItem>
                                                <asp:ListItem>Elogio</asp:ListItem>
                                                <asp:ListItem>Reclamação</asp:ListItem>
                                                <asp:ListItem>Sugestão</asp:ListItem>
                                                <asp:ListItem>Crítica</asp:ListItem>
                                                <asp:ListItem>Informação</asp:ListItem>
                                                <asp:ListItem>Quero ser parceiro</asp:ListItem>
                                                <asp:ListItem>Inclusão de Projeto Ambiental</asp:ListItem>
                                                <asp:ListItem>Outros</asp:ListItem>
                                            </asp:DropDownList>
                        
                        </div>
                        <div>
                            <asp:Label ID="lblMensagem" runat="server" AssociatedControlID="txtMensagem"></asp:Label>
                            <asp:TextBox ID="txtMensagem" runat="server" CssClass="textarea" TextMode="MultiLine" MaxLength="1024"></asp:TextBox>
                            
                        </div>
                        <div>
                            <asp:CheckBox ID="chkReceberCopia" runat="server" />
                            <asp:Label ID="lblReceberCopia" runat="server" AssociatedControlID="chkReceberCopia"
                                CssClass="lblCheckbox"></asp:Label>
                        </div>
                        <div class="btnContLine">
                            <asp:LinkButton ID="btnEnviar" runat="server" CssClass="button" ValidationGroup="Fale">Enviar</asp:LinkButton>
                        </div>
                    </fieldset>
                    <asp:CustomValidator ID="ctvFale" runat="server" Display="None" ValidationGroup="Fale"
                        ClientValidationFunction="fnCustomValidator" />
                </div>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
