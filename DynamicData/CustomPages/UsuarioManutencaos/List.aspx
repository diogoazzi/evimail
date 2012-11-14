<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="List.aspx.vb" Inherits="Manutencao.List1" %>

<%@ Register Src="~/DynamicData/Content/GridViewPager.ascx" TagName="GridViewPager"
  TagPrefix="asp" %>
<%@ Register Src="~/DynamicData/Content/FilterUserControl.ascx" TagName="DynamicFilter"
  TagPrefix="asp" %>
<%@ Register Assembly="Catalyst.Web.DynamicData" Namespace="Catalyst.Web.DynamicData"
  TagPrefix="asp" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="Server">
  <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />
  <h2>
    <%= new Manutencao.util().FormatarNome(table.DisplayName)%></h2>
  <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />
  <asp:UpdatePanel ID="UpdatePanel1" runat="server">
    <ContentTemplate>
      <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
        HeaderText="List of validation errors" />
      <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1"
        Display="None" />
      <asp:DynamicFilterRepeater ID="DynamicFilterRepeater1" runat="server" DataSourceID="GridDataSource">
        <HeaderTemplate>
          <div class="div_Filtros">
            <h3>
              Filtro</h3>
            <fieldset>
        </HeaderTemplate>
        <ItemTemplate>
          <p>
            <asp:Label ID="Label1" runat="server" Text='<%# Eval("DisplayName") %>' />
            <asp:DynamicFilterControl ID="DynamicFilter" runat="server" CssClass="textbox" />
          </p>
        </ItemTemplate>
        <FooterTemplate>
          </fieldset>
          <div class="botoes">
            <asp:LinkButton ID="SearchButton" runat="server" CommandName="Search" Text="Buscar"
              CssClass="botao_link" />
            <asp:LinkButton ID="ClearButton" runat="server" CommandName="Clear" Text="Limpar Filtro"
              CssClass="botao_link" />
          </div>
          </div>
        </FooterTemplate>
      </asp:DynamicFilterRepeater>
      <asp:GridView ID="GridView1" runat="server" DataSourceID="GridDataSource" AllowPaging="True"
        AllowSorting="True" CssClass="gridview">
        <Columns>
          <asp:TemplateField>
            <ItemTemplate>
              <asp:HyperLink ID="EditHyperLink" runat="server" CssClass="btn_edit" NavigateUrl='<%# table.GetActionPath(PageAction.Edit, GetDataItem()) %>'
                Text="Editar" />&nbsp;<asp:LinkButton ID="DeleteLinkButton" CssClass="btn_delete" runat="server" CommandName="Delete"
                  CausesValidation="false" Text="Excluir" OnClientClick='return confirm("Are you sure you want to delete this item?");' />
            </ItemTemplate>
          </asp:TemplateField>
        </Columns>
        <PagerStyle CssClass="footer" />
        <PagerTemplate>
          <asp:GridViewPager ID="GridViewPager1" runat="server" />
        </PagerTemplate>
        <EmptyDataTemplate>
          Nenhuma informação encontrada
        </EmptyDataTemplate>
      </asp:GridView>
      <asp:DynamicLinqDataSource ID="GridDataSource" runat="server" EnableDelete="True">
      </asp:DynamicLinqDataSource>
      <br />
      <div class="bottomhyperlink">
        <asp:HyperLink ID="InsertHyperLink" runat="server">
          <img id="Img1" runat="server" src="~/DynamicData/Content/Images/plus.gif" alt="Inserir novo item" />Inserir
          novo item</asp:HyperLink>
      </div>
    </ContentTemplate>
  </asp:UpdatePanel>
</asp:Content>
