<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="List.aspx.vb" Inherits="Manutencao.ListParametro" %>
<%@ Register Src="~/DynamicData/Content/GridViewPager.ascx" TagName="GridViewPager" TagPrefix="asp" %>
<%@ Register Src="~/DynamicData/Content/FilterUserControl.ascx" TagName="DynamicFilter" TagPrefix="asp" %>
<%@ Register Assembly="Catalyst.Web.DynamicData" Namespace="Catalyst.Web.DynamicData" TagPrefix="asp" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="Server">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />
    <h2><%= new Manutencao.util().FormatarNome(table.DisplayName)%></h2>
    <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />
    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true" HeaderText="List of validation errors" />
            <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1" Display="None" />
            <asp:DynamicFilterRepeater ID="DynamicFilterRepeater1" runat="server" DataSourceID="GridDataSource">
                <ItemTemplate>
                    <div>
                        <asp:Label ID="Label1" runat="server" Text='<%# Eval("DisplayName") %>' />
                        <asp:DynamicFilterControl ID="DynamicFilter" runat="server" CssClass="textbox" />
                    </div>
                </ItemTemplate>
            </asp:DynamicFilterRepeater>
            <asp:GridView ID="GridView1" runat="server" DataSourceID="GridDataSource" AllowPaging="True" AllowSorting="True" CssClass="gridview">
                <Columns>
                    <asp:TemplateField>
                        <ItemTemplate>
                            <asp:HyperLink ID="EditHyperLink" CssClass="btn_edit" ToolTip="Editar" runat="server" NavigateUrl='<%# table.GetActionPath(PageAction.Edit, GetDataItem()) %>'
                                Text="Editar" />
                        </ItemTemplate>
                    </asp:TemplateField>
                </Columns>
                <PagerStyle CssClass="footer" />
                <PagerTemplate>
                    <asp:GridViewPager runat="server" />
                </PagerTemplate>
                <EmptyDataTemplate>
                    Nenhuma informação encontrada
                </EmptyDataTemplate>
            </asp:GridView>
            <asp:DynamicLinqDataSource ID="GridDataSource" runat="server" EnableDelete="True">
            </asp:DynamicLinqDataSource>
            <br />
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>