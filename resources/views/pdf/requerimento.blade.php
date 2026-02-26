<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 1.2cm; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 10px; color: #000; line-height: 1.3; }
        
        /* Cabeçalho com Logos Laterais */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .header-table td { vertical-align: middle; text-align: center; }
        .logo-img { height: 75px; width: auto; } /* Tamanho ampliado dos brasões */
        .header-text { font-weight: bold; font-size: 9pt; text-transform: uppercase; }

        /* Linha divisória tática */
        .header-line { border: 0; border-top: 2px solid #000; margin: 5px 0 15px 0; }

        .title { text-align: center; font-weight: bold; font-size: 13pt; text-decoration: underline; margin: 15px 0; }
        
        /* Grid de Dados Estilo Oficial */
        .data-section { width: 100%; border: 1px solid #000; border-collapse: collapse; margin-top: 10px; }
        .data-section td { border: 1px solid #000; padding: 4px 8px; vertical-align: top; }
        .label { font-size: 7pt; font-weight: bold; display: block; text-transform: uppercase; color: #333; }
        .value { font-size: 9pt; font-weight: bold; text-transform: uppercase; }

        .content { margin-top: 25px; text-align: justify; line-height: 1.6; font-size: 11pt; }
        .footer { margin-top: 50px; text-align: center; }
        .sig-line { border-top: 1px solid #000; width: 350px; margin: 0 auto; padding-top: 5px; font-weight: bold; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="90" style="text-align: left;">
                <img src="{{ public_path('imagens/brasao.png') }}" class="logo-img">
            </td>
            <td class="header-text">
                GOVERNO DO ESTADO DO PARÁ<br>
                SECRETARIA DE ESTADO DE SEGURANÇA PÚBLICA E DEFESA SOCIAL<br>
                POLÍCIA MILITAR DO PARÁ<br>
                FUNDO DE ASSISTÊNCIA SOCIAL DA POLÍCIA MILITAR
            </td>
            <td width="90" style="text-align: right;">
                <img src="{{ public_path('imagens/brasao_PMPA.png') }}" class="logo-img">
            </td>
        </tr>
    </table>

    <hr class="header-line">

    <div class="title">REQUERIMENTO</div>

    <p style="margin-bottom: 15px;"><strong>AO Ilm. Sr. DIRETOR DO FASPM</strong></p>
    <p><strong>OBJETIVO:</strong> Aquisição de ARMA de uso permitido, em consignação.</p>

    <table class="data-section">
        <tr>
            <td colspan="3">
                <span class="label">Nome Completo:</span>
                <span class="value">{{ $pedido->associado->nome_completo }}</span>
            </td>
        </tr>
        <tr>
            <td width="33%">
                <span class="label">RG Militar:</span>
                <span class="value">{{ $pedido->associado->rg_militar }}</span>
            </td>
            <td width="33%">
                <span class="label">Matrícula (MF):</span>
                <span class="value">{{ $pedido->associado->matricula }}</span>
            </td>
            <td width="34%">
                <span class="label">Posto / Graduação:</span>
                <span class="value">{{ $pedido->associado->posto_graduacao }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="label">Endereço:</span>
                <span class="value">{{ $pedido->associado->endereco->logradouro }}, Nº {{ $pedido->associado->endereco->numero }}</span>
            </td>
            <td>
                <span class="label">Bairro:</span>
                <span class="value">{{ $pedido->associado->endereco->bairro }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">Município:</span>
                <span class="value">{{ $pedido->associado->endereco->cidade }} - {{ $pedido->associado->endereco->estado }}</span>
            </td>
            <td>
                <span class="label">CEP:</span>
                <span class="value">{{ $pedido->associado->endereco->cep }}</span>
            </td>
            <td>
                <span class="label">Tel / Celular:</span>
                <span class="value">{{ $pedido->associado->celular }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="label">E-mail:</span>
                <span class="value" style="text-transform: lowercase;">{{ $pedido->associado->email }}</span>
            </td>
            <td>
                <span class="label">OPM:</span>
                <span class="value">{{ $pedido->associado->opm }}</span>
            </td>
        </tr>
    </table>

    <div class="content">
        <p>
            Integrante do Quadro de Associados deste FASPM, vem mui respeitosamente solicitar a V.S.ª., que se digne em 
            <strong>AUTORIZAR</strong> este Requerente que seja atendido pelo Programa <strong>ARMA LEGAL</strong> o financiamento 
            para AQUISIÇÃO DE 01 (um/a) <strong>{{ $pedido->modelo->nome }}</strong>, calibre <strong>{{ $pedido->modelo->calibre }}</strong>, 
            no valor de <strong>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</strong>, parcelado em <strong>{{ $pedido->parcelas }}x</strong>, 
            junto à Empresa AMAZON SERVIÇOS DE ARMARIA E LIMPEZA EIRELI, CNPJ 40.720.043/0001-66, por intermédio do 
            FUNDO DE ASSISTÊNCIA SOCIAL DA POLÍCIA MILITAR, de acordo com o Contrato nº 011/2023.
        </p>
        <p>
            Declaro estar ciente das normas do programa e autorizo o desconto em folha de pagamento das parcelas citadas, 
            conforme margem consignável disponível.
        </p>
    </div>

    <div class="footer">
        Belém-PA, {{ now()->translatedFormat('d \d\e F \d\e Y') }}<br><br><br><br>
        
        <div class="sig-line">
            {{ $pedido->associado->nome_completo }}<br>
            <span style="font-size: 8pt; font-weight: normal;">CPF: {{ $pedido->associado->cpf }}</span>
        </div>
    </div>

</body>
</html>