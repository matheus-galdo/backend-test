# Feedback
Esse documento visa coletar feedbacks sobre o teste de desenvolvimento. Desde o início do teste até a entrega do projeto.

## Antes de Iniciar o Teste

1 - Fale sobre suas primeiras impressões do Teste:
> As funcionalidades do teste são bastante simples, é um encurtador de links, já criei um projeto parecido. Os requisitos mais complexos do desafio são relacionados a implementação de testes automatizados e no uso de boas práticas de OO no projeto.

2 - Tempo estimado para o teste:
> 6 horas

3 - Qual parte você no momento considera mais difícil?
> A implementação dos testes automatizados. Não utilizo PHP a algum tempo, aprendi a criar testes automatizados em Node.js usando Jest, então preciso me adaptar com a construção dos testes usando o PHPUnit. O problema está mais relacionado com a estrutura e funções do PHPUnit, preciso aprender como usar esses recursos.

4 - Qual parte você no momento considera que levará mais tempo?
> Implementação dos testes, por conta dos motivos citados anteriormente.

5 - Por onde você pretende começar?
> Vou implementar o CRUD da criação de redirects, depois disso vou trabalhar na rota de redirecionamento, na criação dos logs e por fim vou fazer os testes. Idealmente usaria TDD para fazer o projeto, mas quero avançar nas funcionalidades antes de precisar aprender mais sobre o PHPUnit


## Após o Teste

1 - O que você achou do teste?
> Ainda acho que o teste não é difícil, trabalhando nas funcionalidades entendo que subestimei bastante algumas tarefas, mas ainda é bem realista fazer no tempo que foi disponibilizado.

2 - Levou mais ou menos tempo do que você esperava?
> Bem mais tempo, acho que fiquei 12 horas trabalhando no projeto. Uma coisa que me atrasou bastante foi me readaptar com o Laravel. Tem cerca de 1 ano que não uso o framework, então precisei relembrar aos poucos e isso me atrasou.

3 - Teve imprevistos? Quais?
> Tive dois problemas. O primeiro foi com o ambiente de desenvolvimento, não tinha instalado uma versão de PHP 8 na minha máquina, configurar isso acabou me tomando bastante tempo, acho que quase duas horas arrumando dependências do ubuntu que o php precisava para ser instalado.
> O segundo problema já  era esperado mas acreditei que daria conta de contorná-lo. Tenho uma viagem marcada, então não vou conseguir usar todo o tempo disponibilizado para o projeto. Diria que fiz cerca de 65% do projeto, falta corrigir alguns bugs, adicionar algumas pequenas funcionalidades, e principalmente, implementar os testes automatizados. Acredito que para concluir todos os itens precisaria de mais 8-10 horas. Infelizmente não tenho como concluir no prazo estipulado.

4 - Existem pontos que você gostaria de ter melhorado?
> Acredito que a injeção de dependência das classes de services e repositories nas controllers poderia ficar melhor. Como não escrevi os testes não tenho certeza de quanto acoplamento existe nas classes do projeto.
> Outra melhoria seria a questão de performance. Implementaria um índice na coluna de code onde armazeno o hash do id de um redirect. Essa coluna é usada como chave para pesquisar os redirects, fazer esse índice melhoraria a performance. Acredito que também possam existir problemas de performance na rota de status de um redirect, não aprofundei nesses testes para dizer com certeza o quão performático isso está.
> Ter implementado os testes.

5 - Quais falhas você encontrou na estrutura do projeto?
> Tem dois bugs que ainda não resolvi. Um é na rota de status, onde aparece o atributo `code` na resposta da requisição. Isso vem do evento de leitura de um na model RedirectLog. Sei o que causou o problema mas não foquei em corrigí-lo. Outro bug é no update de Redirects, as vezes fazer um update insere um novo redirect. Acredito que corrigir esses bugs é onde priorizaria as melhorias