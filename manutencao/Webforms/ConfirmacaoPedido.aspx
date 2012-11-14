<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="ConfirmacaoPedido.aspx.vb" Inherits="WebSiteFrontEnd.ConfirmacaoPedido"  %>

<asp:Content ID="ContentHead" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
</asp:Content>
<asp:Content ID="ContentBody" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:PlaceHolder ID="pchConfirmaCompra" runat="server" >
        <!--Comfirma Compra-->
        <div class="confirmaCompra">
            <asp:Label ID="lblConfirmaCompra" runat="server"></asp:Label>
            <div class="rounded_a">
                <p>
                    <asp:Literal ID="ltlNumPedido" runat="server"></asp:Literal></p>
                <p>
                    <asp:Literal ID="ltlEmailPedido" runat="server"></asp:Literal></p>
                <p>
                    <asp:Literal ID="ltlTxtPedido" runat="server" text="O status do seu pedido é: "></asp:Literal></p><%--Text="Você já pode utilizar o serviço contratado."--%>
                <div class="btnContLine">
                    <asp:LinkButton ID="btnIrConta" CssClass="btnIrConta" Text="Ir para a minha conta"
                        runat="server"></asp:LinkButton>
                   <%-- <asp:LinkButton ID="btnGerarPDF" CssClass="btnGerarPDF" Text="Gerar PDF" runat="server"></asp:LinkButton>--%>
                </div>
            </div>
        </div>
    </asp:PlaceHolder>
</asp:Content>
