<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master" CodeBehind="PerguntasFrequentes.aspx.vb" Inherits="WebSiteFrontEnd.PerguntasFrequentes" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
<script type="text/javascript">
    $(function () {
        $("#faq dd").hide();
        $("#faq dt").css('cursor', 'pointer').click(function () {
            $(this).toggleClass("on").next("#faq dd").slideToggle();
        });
    });
</script>

</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">
    <div id="content">
        <h2 class="title">Perguntas Frequentes</h2>
        <div class="entryContent"> 
            <dl id="faq">
                <dt>Como faço para me cadastrar?</dt>
                <dd>Basta clicar no link Cadastre-se e escolher o serviço que deseja contratar.</dd>
                <dt>Quais as diferenças entre contratar um pacote e um plano?</dt>
                <dd>Basta clicar no link Cadastre-se e escolher o serviço que deseja contratar.</dd>
            </dl>
        </div>
    </div>
</asp:Content> 
