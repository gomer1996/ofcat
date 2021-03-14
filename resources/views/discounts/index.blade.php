<x-app-layout>
    @section('title', 'Скидки')
    <div id="hornav">
        <div class="field">
            <table>
                <tr>
                    <td>
                        <a href="#">Главная</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">Акции</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="field">
        @foreach($discounts as $discount)
            <div class="akcii {{ $loop->last ? "akciilast" : "" }}" style="min-height: 170px">
                {{--       todo put real img         --}}
                <img src="{{ asset('storage/'.$discount->img) }}" alt="Акция" />
                <div>
                    <p class="akciizag">{{ $discount->name }}</p>
                    <p>{!! $discount->description !!}</p>
                    <p class="akciidate">c {{ $discount->starts_at->format('d.m.Y') }} по {{ $discount->expires_at->format('d.m.Y') }}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
