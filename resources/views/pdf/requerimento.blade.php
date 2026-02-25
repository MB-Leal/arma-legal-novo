<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11pt; color: #333; line-height: 1.4; }
        .header { text-align: center; font-weight: bold; margin-bottom: 20px; font-size: 10pt; }
        .title { text-align: center; font-weight: bold; font-size: 14pt; text-decoration: underline; margin: 20px 0; }
        .section-title { font-weight: bold; background: #eee; padding: 5px; margin-top: 15px; border: 1px solid #ccc; font-size: 10pt; }
        .data-grid { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .data-grid td { border: 1px solid #ccc; padding: 8px; vertical-align: top; }
        .label { font-size: 8pt; font-weight: bold; color: #666; display: block; margin-bottom: 2px; text-transform: uppercase; }
        .content { margin-top: 30px; text-align: justify; }
        .footer { margin-top: 50px; text-align: center; }
        .signature-line { border-top: 1px solid #000; width: 300px; margin: 0 auto; margin-top: 40px; }
    </style>
</head>
<body>

    <div class="header">
        GOVERNO DO ESTADO DO PARÁ<br>
        SECRETARIA DE ESTADO DE SEGURANÇA PÚBLICA E DEFESA SOCIAL<br>
        POLÍCIA MILITAR DO PARÁ<br>
        FUNDO DE ASSISTÊNCIA SOCIAL DA POLÍCIA MILITAR<br>
        Programa Arma Legal
    </div>

    <div class="title">REQUERIMENTO</div>

    <p><strong>AO Ilm. Sr. DIRETOR DO FASPM</strong></p>
    <p><strong>OBJETIVO:</strong> Aquisição de ARMA de uso permitido, em consignação.</p>

    <div class="section-title">DADOS DO SOLICITANTE</div>
    <table class="data-grid">
        <tr>
            <td colspan="2"><span class="label">Nome Completo</span><strong>{{ $pedido->associado->nome_completo }}</strong></td>
            <td><span class="label">Posto/Graduação</span>{{ $pedido->associado->posto_graduacao }}</td>
        </tr>
        <tr>
            <td><span class="label">RG Militar</span>{{ $pedido->associado->rg_militar }}</td>
            <td><span class="label">Matrícula (MF)</span>{{ $pedido->associado->matricula }}</td>
            <td><span class="label">OPM</span>{{ $pedido->associado->opm }}</td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">Endereço</span>{{ $pedido->associado->endereco->logradouro }}, nº {{ $pedido->associado->endereco->numero }}</td>
            <td><span class="label">Bairro</span>{{ $pedido->associado->endereco->bairro }}</td>
        </tr>
        <tr>
            <td><span class="label">Cidade</span>{{ $pedido->associado->endereco->cidade }}</td>
            <td><span class="label">CEP</span>{{ $pedido->associado->endereco->cep }}</td>
            <td><span class="label">Telefone</span>{{ $pedido->associado->celular }}</td>
        </tr>
    </table>

    <div class="content">
        <p>
            Integrante do Quadro de Associados deste FASPM, vem mui respeitosamente solicitar a V.S.ª., que se digne em 
            <strong>AUTORIZAR</strong> este Requerente que seja atendido pelo Programa <strong>ARMA LEGAL</strong> o financiamento 
            para AQUISIÇÃO DE 01 (um/a) <strong>{{ $pedido->modelo->nome }}</strong>, calibre <strong>{{ $pedido->modelo->calibre }}</strong>, 
            no valor de <strong>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</strong>, parcelado em <strong>{{ $pedido->num_parcelas }}x</strong>, 
            junto à Empresa AMAZON SERVIÇOS DE ARMARIA E LIMPEZA EIRELI, CNPJ 40.720.043/0001-66, por intermédio do 
            FUNDO DE ASSISTÊNCIA SOCIAL DA POLÍCIA MILITAR, de acordo com o Contrato nº 011/2023.
        </p>
        <p>
            Declaro estar ciente das normas do programa e autorizo o desconto em folha de pagamento das parcelas citadas, 
            conforme margem consignável disponível.
        </p>
    </div>

    <div class="footer">
        Belém-PA, {{ now()->format('d/m/Y') }}<br><br><br>
        
        <div class="signature-line"></div>
        <strong>{{ $pedido->associado->nome_completo }}</strong><br>
        CPF: {{ $pedido->associado->cpf }}
    </div>

</body>
</html>