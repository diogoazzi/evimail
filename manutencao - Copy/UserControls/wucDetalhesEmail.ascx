<%@ Control Language="vb" AutoEventWireup="false" CodeBehind="wucDetalhesEmail.ascx.vb"
    Inherits="WebSiteFrontEnd.wucDetalhesEmail" %>
<div class="box">
    <p>
        <asp:Label ID="lblIPOrigem" runat="server" />
        <asp:Label ID="lblIPOrigemValue" runat="server" />
    </p>
    <p>
        <asp:Label ID="lblIPDestino" runat="server" />
        <asp:Label ID="lblIPDestinoValue" runat="server" />
    </p>
    <div>
        <p>
            <asp:Label ID="lblEviMail" runat="server" Text="Evimail" />
            -
            <asp:Literal ID="ltrData" runat="server" />
            -
            <asp:Literal ID="ltrHora" runat="server" />
        </p>
    </div>
</div>
    <div class="box">
        <p>
            <asp:Label ID="lblCorpo" runat="server" />
            <asp:Literal runat="server" ID="ltlCorpoEmail" />
        </p>
<asp:Panel runat="server" ID="pnlAnexo">
        <p>
            <asp:Label ID="lblArquivos" runat="server" />
            <asp:Literal runat="server" ID="ltlAnexosValue" />
        </p>
        <asp:ListView runat="server" ID="lsvAnexos">
            <ItemTemplate>
                <p>
                    <asp:HyperLink runat="server" ID="lnkAnexo" CommandName="ExibirArquivo" /></p>
            </ItemTemplate>
        </asp:ListView>
</asp:Panel>
    </div>
<asp:Panel runat="server" ID="pnlGerarPdf" Visible="true">
    <asp:HyperLink ID="lnkGerarPDF" CssClass="button" runat="server" Target="_blank" />
</asp:Panel>
