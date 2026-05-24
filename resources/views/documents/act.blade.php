<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        h1 {
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 8px;
        }

        .label {
            display: inline-block;
            width: 140px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .signatures {
            margin-top: 30px;
            width: 100%;
        }

        .signatures td {
            border: none;
            width: 50%;
            vertical-align: top;
            padding: 10px;
        }

        .sign-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 200px;
            margin-top: 30px;
        }

        .sign-label {
            font-size: 10px;
            color: #555;
        }
    </style>
</head>
<body>

<h1>Акт приема-передачи геодезического оборудования</h1>

<div class="row"><span class="label">Город:</span> {{ $city ?? '__________________________' }}</div>
<div class="row"><span class="label">Дата:</span> {{ $date?->isoFormat('D MMMM YYYY') ?? '"_" ____________ 20__ г.' }}
</div>

<p>Мы, нижеподписавшиеся:</p>

<div class="row"><strong>Передающая сторона:</strong></div>
<div class="row"><span class="label">ФИО:</span> {{ $sender?->getFullName() ?? '__________________________' }}</div>
<div class="row"><span class="label">Должность:</span> {{ $sender?->position?->label() ?? '______________________' }}
</div>
<div class="row"><span class="label">Телефон:</span>______________________</div>

<br>

<div class="row"><strong>Принимающая сторона:</strong></div>
<div class="row"><span class="label">ФИО:</span> {{ $receiver?->getFullName() ?? '__________________________' }}</div>
<div class="row"><span class="label">Должность:</span> {{ $receiver?->position?->label() ?? '______________________' }}
</div>
<div class="row"><span class="label">Телефон:</span>______________________</div>

<p>составили настоящий акт о следующем:</p>
<p><strong>1. Оборудование</strong></p>
<p>Передача происходит по следующему перечню геодезического оборудования:</p>

<table>
    <thead>
    <tr>
        <th style="width: 5%;">№</th>
        <th style="width: 30%;">Наименование</th>
        <th style="width: 20%;">Инв. номер</th>
        <th style="width: 10%;">Кол-во</th>
        <th style="width: 15%;">Состояние</th>
        <th style="width: 20%;">Примечание</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>{{ $equipment->type->name ?? '' }}</td>
        <td>{{ $equipment->inventory_number ?? '' }}</td>
        <td>1</td>
        <td></td>
        <td>{{ $comment ?? '' }}</td>
    </tr>
    </tbody>
</table>

<table class="signatures">
    <tr>
        <td>
            <strong>Передающая сторона</strong><br><br><br>
            <span class="sign-line"></span><br>
            <span class="sign-label">(Подпись, ФИО)</span>
        </td>
        <td>
            <strong>Принимающая сторона</strong><br><br><br>
            <span class="sign-line"></span><br>
            <span class="sign-label">(Подпись, ФИО)</span>
        </td>
    </tr>
</table>

</body>
</html>
