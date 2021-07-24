<x-app-layout>
    @section('title', 'Акции')
    <div id="hornav">
        <div class="field">
            <table>
                <tr>
                    <td>
                        <a href="/">Главная</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    <td>
                        <a href="{{ route('discounts.index') }}">Акции</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="field">
        @foreach($discounts as $discount)
            <div class="akcii {{ $loop->last ? "akciilast" : "" }}" style="min-height: 170px">
                <img src="{{ asset('storage/'.$discount->img) }}" alt="Акция" />
                <div>
                    <p class="akciizag">{{ $discount->name }}</p>
                    <div style="margin: 20px 0 20px 30px;">{!! $discount->description !!}</div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
