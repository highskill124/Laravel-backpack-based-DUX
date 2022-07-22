@extends(backpack_view('blank'))



@php

    $widgets['before_content'][] = [
       'type'       => 'card',
         'wrapper' => ['class' => 'text-center'], // optional
         //'class'   => '', // optional

        'content'    => [
            //'header' => 'Promotions Manager', // optional
            'body'   => "Welcome to Dux HQ! ",
        ]
    ];
    $widgets['before_content'][] = [
       'type'       => 'card',
         'wrapper' => ['class' => 'text-center'], // optional


        'content'    => [
            //'header' => 'Promotions Manager', // optional
            'body'   => "<a href='/admin/promotion'><i style='color:green!important' class='la la-lightbulb'></i><span style='color:green!important'>Promotions Manager</span></a>",
        ]
    ];

    $widgets['before_content'][] = [
        'type'    => 'div',
        'class'   => 'row  text-center col-sm-12 col-md-12 ',

        'content' => [ // widgets

            [ 'type' => 'card', 'content' => ['body' => '<a href="/admin/location"><span style="color:green!important">Locations Manager</span></a>'] ],
            [ 'type' => 'card', 'content' => ['body' => '<a href="/admin/category"><span style="color:green!important">Categories </span></a>'] ],
            [ 'type' => 'card', 'content' => ['body' => '<a href="/admin/statistics"><span style="color:green!important">Statistics</span>'] ],
        ]
    ]
@endphp
@section('content')

@endsection

