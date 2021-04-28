@if($large || $smallTop || $smallBottom)
    <div id="slider">
        <table>
            <tr>
                @if($large)
                    <td rowspan="2" class="owl-carousel" style="width: 800px">
                        <a href="{{ $large->link }}">
                            <img src="{{ asset('/storage/'.$large->img) }}" alt="Акционное предложение" />
                        </a>
                        <a href="{{ $large->link }}">
                            <img src="{{ asset('/storage/'.$large->img) }}" alt="Акционное предложение" />
                        </a>
                        <a href="{{ $large->link }}">
                            <img src="{{ asset('/storage/'.$large->img) }}" alt="Акционное предложение" />
                        </a>
                        <a href="{{ $large->link }}">
                            <img src="{{ asset('/storage/'.$large->img) }}" alt="Акционное предложение" />
                        </a>
                    </td>
                @endif
                @if($smallTop)
                    <td>
                        <a href="{{ $smallTop->link }}">
                            <img src="{{ asset('/storage/'.$smallTop->img) }}" alt="Акционное предложение" />
                        </a>
                    </td>
                @endif
            </tr>
            <tr>
                @if($smallBottom)
                    <td>
                        <a href="{{ $smallBottom->link }}">
                            <img src="{{ asset('/storage/'.$smallBottom->img) }}" alt="Акционное предложение" />
                        </a>
                    </td>
                @endif
            </tr>
        </table>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function(){
                $(".owl-carousel").owlCarousel({
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 3000
                });
            });
        </script>
    @endpush
@endif
