<%@ Page Title="" Language="vb" AutoEventWireup="false" MasterPageFile="~/MasterPage/Master.Master" CodeBehind="Default.aspx.vb" Inherits="WebSiteFrontEnd._Default" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
<script type="text/javascript">
    $(function () {
        $('#lnkSlide').click(function (e) { e.preventDefault(); $('#slideContentInit').fadeOut(); });

        /* slide */
        var ulContent = $('#slidePasso1 .slideContent'),
            liContent = $('#slidePasso1 .slideContent li'),
            ulContentWidth = liContent.length * liContent.width(),
            ulNav = $('#slidePasso1 .slideNav'),
            liNav = $('#slidePasso1 .slideNav li');

        ulContent.css('width', ulContentWidth);

        ulNav.find('a').bind('click', function (e) {
            e.preventDefault();
            var indexLi = $(this).parent('li').index();
            var leftValue = (liContent.width() * indexLi) * -1

            ulContent.animate({ left: leftValue }, 1000);
            $(this).parent('li').siblings().find('a').removeClass('hover');
            $(this).addClass('hover');
        });
        /* end slide */
    });
</script>
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Body" runat="server">

        <div id="homeBloco1">
            <h2 class="titleHome"><asp:Literal ID="ltrTituloBloco1" runat="server" /></h2>
            <asp:Literal ID="ltrConteudoBloco1" runat="server" /> 
        </div>

        <div id="homeBloco2">
           <div id="slideContentInit" class="slide">
               <asp:Image ID="imgTxt" CssClass="imgTxt" ImageUrl="~/img/txtHome1.png"  runat="server" />
               <asp:HyperLink ID="lnkSlide" ClientIDMode="Static" ImageUrl="~/img/btnSlide.png" NavigateUrl="#" runat="server"></asp:HyperLink>
           </div>   
           <div id="slidePasso1" class="slide">
               <ul class="slideContent">
                    <li><asp:Image ID="imgSlide1" ClientIDMode="Static" ImageUrl="~/img/slidePs1.png" runat="server" /></li>
                    <li><asp:Image ID="imgSlide2" ClientIDMode="Static" ImageUrl="~/img/slidePs2.png" runat="server" /></li>
                    <li><asp:Image ID="imgSlide3" ClientIDMode="Static" ImageUrl="~/img/slidePs3.png" runat="server" /></li>
                    <li><asp:Image ID="imgSlide4" ClientIDMode="Static" ImageUrl="~/img/slidePs4.png" runat="server" /></li>
                    <li><asp:Image ID="imgSlide5" ClientIDMode="Static" ImageUrl="~/img/slidePs5.png" runat="server" /></li>               
               </ul>
               <ul class="slideNav">
                    <li><a href="#" class="hover">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
               </ul>
           </div>          
        </div>

        <div id="homeBloco3">
            <ul>
                <li><asp:HyperLink ID="lnkVantagem" NavigateUrl="Vantagens.aspx" CssClass="linkHome" runat="server" Text="Vantagens pra você e sua empresa"></asp:HyperLink></li>
                <li><asp:HyperLink ID="lnkPlano" NavigateUrl="MelhorPlano.aspx" CssClass="linkHome" runat="server" Text="Escolha o melhor plano"></asp:HyperLink></li>
                <li><asp:HyperLink ID="lnkLaudo" NavigateUrl="ModeloLaudo.aspx" CssClass="linkHome" runat="server" Text="Veja o modelo de laudo"></asp:HyperLink></li>
            </ul>
        </div>

        <div id="homeBloco4" class="rounded_a">
            <h4><asp:Literal ID="Literal1" runat="server" Text="Nós ajudamos o meio ambiente"></asp:Literal></h4>
            <ul>
                <li>
                    <asp:Label ID="lblPapel" runat="server" Text="Total de papel economizado"></asp:Label>
                    <asp:Label ID="lblPeso" runat="server" ></asp:Label>
                </li>
                <li>
                    <asp:Label ID="lblParceiro" CssClass="marginHome" runat="server" Text="Um parceiro"></asp:Label>
                    <asp:HyperLink ID="lnkImgUvaia" runat="server" ImageUrl="~/img/logoUvaia.jpg" Target="_blank"></asp:HyperLink>
                   
                </li>
                
            </ul>
        </div>

</asp:Content>
