<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master"
    CodeBehind="ConfirmacaoCadastro.aspx.vb" Inherits="WebSiteFrontEnd.ConfirmacaoCadastro" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <asp:UpdatePanel ID="upConfirmacaoCadastro" runat="server" ChildrenAsTriggers="false"
        UpdateMode="Conditional">
        <Triggers>
            <asp:AsyncPostBackTrigger ControlID="lnkConfirmar" EventName="Click" />
        </Triggers>
        <ContentTemplate>
            <asp:PlaceHolder ID="phConfirmacaoComChave" runat="server" Visible="false">
                <asp:Literal ID="ltrMensagemAtivacao" runat="server" />
            </asp:PlaceHolder>
            <asp:PlaceHolder ID="phConfirmacaoSemChave" runat="server" Visible="false">
                <div>
                    <asp:Label ID="lblChaveAtivacao" runat="server" AssociatedControlID="txtChaveAtivacao" /><br />
                    <asp:TextBox ID="txtChaveAtivacao" runat="server" />
                </div>
                <div>
                    <asp:LinkButton ID="lnkConfirmar" runat="server" />
                </div>
            </asp:PlaceHolder>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
