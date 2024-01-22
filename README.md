# TechShop

![screenshot](/images/home_readme.png)

Este projeto é um site e-commerce com registro seguro e pagamento online.
Está sendo desenvolvido em PHP. PDO, MySQL, HTML, CSS e outros plugins. 
Este site possui um painel de administração onde podemos gerenciar as categorias, usuários, produtos e visualizar as vendas. Falando em cadastro seguro, o formulário de cadastro do usuário possui recurso de caixa de seleção reCaptcha. 
Além do reCaptcha, o usuário deve cadastrar um e-mail válido, pois o sistema enviará para o e-mail fornecido uma verificação para verificar o e-mail do usuário para fins de segurança. 
Sobre o painel de administração, o usuário administrador deve preencher primeiro a lista de produtos e categorias para que os usuários possam explorar e criar suas transações. 
Para pagamento online, este sistema utiliza Paypal para finalização da compra.


### Features
- Adição de carrinho e ajuste de quantidade
- Pode reservar um determinado produto mesmo sem fazer login no site, mas não consegue finalizar a compra
- Pesquisa de produtos
- Função de ampliação (lupa) de imagem para melhor visualização do produto
- Verificação de e-mail na inscrição
- Google reCaptcha na inscrição
- Esqueci o e-mail da senha
- Check-out Paypal
- Impressão de relatório de vendas por intervalo de datas
- Gerenciamento de usuários
- Gerenciamento de categorias de produtos
- Gerenciamento de lista de produtos


### Plugins
- AdminLTE
- TCPPDF
- PHPMailer
