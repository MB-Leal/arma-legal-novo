<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>REQUERIMENTO DE AQUISIÇÃO</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
            text-align: justify;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
        }

        .signature {
            margin-top: 40px;
            border-top: 1px solid #000;
            display: inline-block;
            width: 300px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('imagens/logo_tatica.png') }}" style="height: 80px;"><br>
        FUNDO DE ASSISTÊNCIA SOCIAL DA PMPA - FASPM<br>
        PROJETO ARMA LEGAL
    </div>

    <div class="section">
        <strong>ILMO SR. DIRETOR DO FUNDO DE ASSISTÊNCIA SOCIAL DA PMPA</strong>
    </div>

    <div class="section">
        O(A) associado(a) <strong>{{ $associado->nome_completo }}</strong>, RG: <strong>{{ $associado->rg_militar }}</strong>,
        CPF: <strong>{{ $associado->cpf }}</strong>, lotado na OPM: <strong>{{ $associado->opm }}</strong>,
        residente em {{ $associado->endereco->logradouro }}, nº {{ $associado->endereco->numero }},
        {{ $associado->endereco->bairro }}, {{ $associado->endereco->cidade }}-{{ $associado->endereco->estado }},
        vem requerer a vossa senhoria a autorização para aquisição de arma de fogo de uso permitido através do Projeto Arma Legal.
    </div>

    <div class="section">
        <strong>ESPECIFICAÇÕES DA ARMA:</strong>
        <table class="data-table">
            <tr>
                <td><strong>FABRICANTE:</strong> {{ $arma->fabricante->nome }}</td>
                <td><strong>MODELO:</strong> {{ $arma->modelo }}</td>
            </tr>
            <tr>
                <td><strong>CALIBRE:</strong> {{ $arma->calibre->nome }}</td>
                <td><strong>CAPACIDADE:</strong> {{ $arma->capacidade }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <strong>OPÇÃO DE PAGAMENTO:</strong><br>
        Parcelado em <strong>{{ $pedido->parcelas ?? '---' }}</strong> vezes via consignação em folha de pagamento,
        conforme regras estabelecidas pelo FASPM.
    </div>

    <div class="footer">
        Belém - PA, {{ $data_extenso }}<br><br>

        <div class="signature">
            Assinatura do Associado
        </div>
    </div>
</body>

</html>