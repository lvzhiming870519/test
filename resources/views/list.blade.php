<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Redis</title>


    </head>
    <body>

        <table border="1">
            <tr>
                <td>ID</td>
                <td>ADDRESS</td>
                <td>PRICE</td>
                <td>SORT</td>
                <td>PRICE1</td>
                <td>STATUS</td>
                <td>PINYIN</td>
            </tr>
            @foreach($data as $k=>$v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['address']}}</td>
                <td>{{$v['price']}}</td>
                <td>{{$v['sort']}}</td>
                <td>{{$v['price1']}}</td>
                <td>{{$v['status']}}</td>
                <td>{{$v['pinyin']}}</td>
            </tr>
            @endforeach
        </table>




    </body>
</html>
