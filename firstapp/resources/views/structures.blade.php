{{--
@for ($i = 0; $i < 5; $i++)
    <p>Nombre inférieur à {{$i}}</p>
@endfor

@if ($number < 5)
    Inferieur à 5
@elseif($number == 5)
    Egal à 5
@else
    Supérieur à 5<br>
@endif


@unless ($number == 5)
Number, différent de 5
@endunless

@foreach ($fruits as $fruit)
    <p>{{ $fruit }}</p>
@endforeach


@forelse ($fruits as $fruit)
    <p> {{ $fruit }}</p>
@empty
Aucun fruit    
@endforelse


@php
    echo rand(1, 15);
@endphp



@isset($fruits)
    {{ count($fruits) }}
@endisset


@switch($number)
    @case(2)
        Egal à 2
        @break
    @case(5)
        Egal à 5
        @break
    @case(15)
        Egal à 15
        @break
    @default
        Egal ni a 2 ni a 5 ni a 15
@endswitch

--}}