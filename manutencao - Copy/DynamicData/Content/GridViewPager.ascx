<%@ Control Language="VB" CodeBehind="GridViewPager.ascx.vb" Inherits="Manutencao.GridViewPager" %>

<div class="pager">
    <span class="results1">
        <asp:ImageButton AlternateText="Primeira página" ToolTip="Primeira página" ID="ImageButtonFirst" runat="server" ImageUrl="Images/PgFirst.gif" Width="8" Height="9" CommandName="Page" CommandArgument="First" />
        &nbsp;
        <asp:ImageButton AlternateText="Próxima página" ToolTip="Próxima página" ID="ImageButtonPrev" runat="server" ImageUrl="Images/PgPrev.gif" Width="5" Height="9" CommandName="Page" CommandArgument="Prev" />
        &nbsp;
        <asp:Label ID="LabelPage" runat="server" Text="Página " AssociatedControlID="TextBoxPage" />
        <asp:TextBox ID="TextBoxPage" runat="server" Columns="5" AutoPostBack="true" ontextchanged="TextBoxPage_TextChanged" Width="20px" CssClass="droplist" />
        de
        <asp:Label ID="LabelNumberOfPages" runat="server" />
        &nbsp;
        <asp:ImageButton AlternateText="Próxima página" ToolTip="Próxima página" ID="ImageButtonNext" runat="server" ImageUrl="Images/PgNext.gif" Width="5" Height="9" CommandName="Page" CommandArgument="Next" />
        &nbsp;
        <asp:ImageButton AlternateText="Última página" ToolTip="Última página" ID="ImageButtonLast" runat="server" ImageUrl="Images/PgLast.gif" Width="8" Height="9" CommandName="Page" CommandArgument="Last" />
    </span>
    <span class="results2">
        <asp:Label ID="LabelRows" runat="server" Text="Resultados por página:" AssociatedControlID="DropDownListPageSize" />
        <asp:DropDownList ID="DropDownListPageSize" runat="server" AutoPostBack="true" CssClass="droplist" onselectedindexchanged="DropDownListPageSize_SelectedIndexChanged">
            <asp:ListItem Value="5" />
            <asp:ListItem Value="10" />
            <asp:ListItem Value="15" />
            <asp:ListItem Value="20" />
        </asp:DropDownList>
    </span>
</div>
