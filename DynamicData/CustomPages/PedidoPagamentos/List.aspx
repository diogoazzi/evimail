<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="List.aspx.vb" Inherits="Manutencao.ListPedidoPagamentos" %>

<%@ Register src="~/DynamicData/Content/GridViewPager.ascx" tagname="GridViewPager" tagprefix="asp" %>
<%@ Register src="~/DynamicData/Content/FilterUserControl.ascx" tagname="DynamicFilter" tagprefix="asp" %>

<%@ Register assembly="Catalyst.Web.DynamicData" namespace="Catalyst.Web.DynamicData" tagprefix="asp" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" Runat="Server">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />

    <h2><%= new Manutencao.util().FormatarNome(table.DisplayName)%></h2>

    <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />

    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
            <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1" Display="None" />

            <asp:DynamicFilterRepeater ID="DynamicFilterRepeater1" runat="server" 
                DataSourceID="GridDataSource">
        <HeaderTemplate>
            <div>
                Filtro</div>
        </HeaderTemplate>
        <ItemTemplate>
            <div>
                <asp:Label ID="Label1" runat="server" Text='<%# Eval("DisplayName") %>' />
                <asp:DynamicFilterControl ID="DynamicFilter" runat="server" />
            </div>
        </ItemTemplate>
        <FooterTemplate>
            <div>
                <asp:LinkButton ID="SearchButton" runat="server" CommandName="Search" 
                    Text="Buscar" />
                <asp:LinkButton ID="ClearButton" runat="server" CommandName="Clear" 
                    Text="Limpar Filtro" />
            </div>
        </FooterTemplate>
    </asp:DynamicFilterRepeater>

            <asp:GridView ID="GridView1" runat="server" DataSourceID="GridDataSource"
                AllowPaging="True" AllowSorting="True" CssClass="gridview">

                <PagerStyle CssClass="footer"/>        
                <PagerTemplate>
                    <asp:GridViewPager runat="server" />
                </PagerTemplate>
                <EmptyDataTemplate>
                    Nenhuma informação encontrada
                </EmptyDataTemplate>
            </asp:GridView>

            <asp:DynamicLinqDataSource ID="GridDataSource" runat="server" 
                EnableDelete="True">
            </asp:DynamicLinqDataSource>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
