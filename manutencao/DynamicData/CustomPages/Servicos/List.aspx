<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="List.aspx.vb" Inherits="Manutencao.Servico"%>

<%@ Register src="~/DynamicData/Content/GridViewPager.ascx" tagname="GridViewPager" tagprefix="asp" %>
<%@ Register src="~/DynamicData/Content/FilterUserControl.ascx" tagname="DynamicFilter" tagprefix="asp" %>

<%@ Register assembly="Catalyst.Web.DynamicData" namespace="Catalyst.Web.DynamicData" tagprefix="asp" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" Runat="Server">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />

    <h2>Gerenciar Serviços</h2>

    <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />

    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
            <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1" Display="None" />

            <asp:DynamicFilterRepeater ID="DynamicFilterRepeater1" runat="server" 
                DataSourceID="GridDataSource">
        <HeaderTemplate>
            <div class="div_Filtros">
                <h3>Filtro</h3>
                
                </div>  
        </HeaderTemplate>
        <ItemTemplate>
        
        <fieldset> 
            <div style = "float: left; width: 220px" >
                <asp:Label ID="Label1" runat="server" Text='<%# Eval("DisplayName") %>' />
            </div>
            <div>
                <asp:DynamicFilterControl ID="DynamicFilter" runat="server" CssClass="textbox" />
            </div>
        </ItemTemplate>
       
        <FooterTemplate>
         </fieldset>
            <div class="botoes">
                <asp:LinkButton ID="SearchButton" runat="server" CommandName="Search" 
                    Text="Buscar" CssClass="botao_link" />
                <asp:LinkButton ID="ClearButton" runat="server" CommandName="Clear" 
                    Text="Limpar Filtro" CssClass="botao_link" />
            </div>
        </FooterTemplate>
    </asp:DynamicFilterRepeater>

            <asp:GridView ID="GridView1" runat="server" DataSourceID="GridDataSource"
                AllowPaging="True" AllowSorting="True" CssClass="gridview">
                <Columns>
                    <asp:TemplateField>
                        <ItemTemplate>
                            <asp:HyperLink ID="EditHyperLink" runat="server"
                                NavigateUrl='<%# table.GetActionPath(PageAction.Edit, GetDataItem()) %>'
                            Text="Editar" CssClass="btn_edit" />&nbsp;<asp:LinkButton ID="DeleteLinkButton" CssClass="btn_delete" runat="server" CommandName="Delete"
                                CausesValidation="false" Text="Excluir"
                                OnClientClick='return confirm("Deseja realmente excluir este item?");'
                            />
                        </ItemTemplate>
                    </asp:TemplateField>
                </Columns>

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

            <br />

            <div class="bottomhyperlink">
                <asp:HyperLink ID="InsertHyperLink" runat="server"><img runat="server" src="~/DynamicData/Content/Images/plus.gif" alt="Inserir novo item" />Inserir novo item</asp:HyperLink>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
