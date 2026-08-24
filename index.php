<?php
$mensagem = "";
$classeMensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["txtNome"] ?? "");
    $valorCompra = (float)($_POST["txtValorCompra"] ?? 0);
    $formaPagamento = $_POST["cmbPag"] ?? "";

    if ($nome == "" || $valorCompra <= 0) {
        $mensagem = "Preencha o nome e informe um valor de compra válido.";
        $classeMensagem = "erro";
    } else {
        $desconto = 0;

        if ($formaPagamento == "deposito") {
            $desconto = $valorCompra * 0.10;
            $formaTexto = "depósito";
        } elseif ($formaPagamento == "boleto") {
            $desconto = $valorCompra * 0.08;
            $formaTexto = "boleto";
        } elseif ($formaPagamento == "cartaoCredito") {
            $desconto = 0;
            $formaTexto = "cartão de crédito";
        } else {
            $mensagem = "Selecione uma forma de pagamento válida.";
            $classeMensagem = "erro";
        }

        if ($mensagem == "") {
            $valorFinal = $valorCompra - $desconto;

            $mensagem = "Olá, $nome! Sua compra de R$ " .
                number_format($valorCompra, 2, ',', '.') .
                " foi realizada com $formaTexto. " .
                "Seu desconto foi de R$ " .
                number_format($desconto, 2, ',', '.') .
                ". O valor final da compra é R$ " .
                number_format($valorFinal, 2, ',', '.') . ".";

            $classeMensagem = "sucesso";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madeira e Cia Ltda. - Promoção de Aniversário</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <header class="cabecalho">
            <h1>Madeira e Cia Ltda.</h1>
            <p>Promoção especial de aniversário</p>
        </header>

        <main class="conteudo">
            <section class="promocao">
                <h2>Escolha sua forma de pagamento</h2>
                <p>
                    Depósito: <strong>10% de desconto</strong> |
                    Boleto: <strong>8% de desconto</strong> |
                    Cartão de crédito: <strong>sem desconto</strong>
                </p>
            </section>

            <form method="POST" action="">
                <div>
                    <label for="txtNome">Nome do cliente</label>
                    <input type="text" id="txtNome" name="txtNome"
                           placeholder="Digite seu nome" required>
                </div>

                <div>
                    <label for="txtValorCompra">Valor da compra</label>
                    <input type="number" id="txtValorCompra" name="txtValorCompra"
                           placeholder="Ex.: 1500,00" min="0.01" step="0.01" required>
                </div>

                <div>
                    <label for="cmbPag">Forma de pagamento</label>
                    <select id="cmbPag" name="cmbPag" required>
                        <option value="">Selecione uma opção</option>
                        <option value="deposito">Depósito</option>
                        <option value="boleto">Boleto</option>
                        <option value="cartaoCredito">Cartão de crédito</option>
                    </select>
                </div>

                <button type="submit">Calcular desconto</button>
            </form>

            <?php if ($mensagem != ""): ?>
                <div class="mensagem <?php echo $classeMensagem; ?>">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>
        </main>

        <footer class="rodape">
            Madeira e Cia Ltda. — Atividade Ag3 DS II
        </footer>
    </div>
</body>
</html>

<!--
COMENTÁRIO REFLEXIVO

Para desenvolver esta atividade, primeiro analisei o código recebido e identifiquei
que os percentuais de desconto do depósito e do boleto estavam trocados. O depósito
deve receber 10% e o boleto 8%, enquanto o cartão de crédito não possui desconto.

Depois, organizei a lógica usando uma estrutura if/elseif para verificar a forma de
pagamento escolhida pelo usuário. A partir dessa escolha, calculei o desconto e
subtraí esse valor do preço original para encontrar o valor final da compra.

Também percebi que a mensagem original mostrava apenas o valor do desconto e não
informava o preço final. Por isso, acrescentei o cálculo do valor final e utilizei
number_format para exibir os valores com duas casas decimais e no padrão brasileiro.

Para a interface, criei um formulário próprio em HTML e CSS, com campos para nome,
valor da compra e forma de pagamento. O formulário envia os dados pelo método POST
para a própria página, onde o PHP recebe e processa as informações.

Por fim, fiz testes considerando as três formas de pagamento. No depósito, o desconto
é de 10%; no boleto, de 8%; e no cartão de crédito, o desconto permanece em R$ 0,00.
Também foi verificado se o valor final é calculado corretamente em cada situação.
-->
