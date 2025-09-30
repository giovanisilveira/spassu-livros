<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Livros por Autor</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f5f5f5;
            color: #333;
            text-align: left;
        }
        td {
            background-color: #fff;
            color: #555;
        }
        .author-name {
            font-weight: bold;
            color: #fff;
            background-color: #808080;
            padding: 5px;
        }
        .no-border {
            border: none;
        }
    </style>
</head>
<body>

    <h1>Relatório de Livros por Autor</h1>

    <table>
        <thead>
            <tr>
                <th>Autor</th>
                <th>Título</th>
                <th>Editora</th>
                <th width="50px">Edição</th>
                <th width="70px">Publicação</th>
                <th width="70px" style="text-align: right;">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dadosRelatorio as $autorNome => $livros)
                <tr class="no-border">
                    <td colspan="6" class="author-name">{{ $autorNome }}</td>
                </tr>

                @foreach($livros as $livro)
                    <tr>
                        <td></td>
                        <td>{{ $livro->livro_titulo }}</td>
                        <td>{{ $livro->livro_editora }}</td>
                        <td>{{ $livro->livro_edicao }}</td>
                        <td>{{ $livro->livro_anopublicacao }}</td>
                        <td style="text-align: right;">{{ number_format($livro->livro_valor / 100, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>
