@if($largeBanners->count() || $smallTop || $smallBottom)
    <div id="slider">
        <table>
            <tr>
                @if($largeBanners->count())
                    <td rowspan="2">
                        <div class="owl-carousel"  style="width: 800px">
                            @foreach($largeBanners as $banner)
                                <a href="{{ $banner->link }}">
                                    <img src="{{ asset('/storage/'.$banner->img) }}" alt="Акционное предложение" />
                                </a>
                            @endforeach
                        </div>
                    </td>
                @endif
                @if($smallTop)
                    <td style="vertical-align: top">
                        <a href="{{ $smallTop->link }}">
                            <img src="{{ asset('/storage/'.$smallTop->img) }}" alt="Акционное предложение" />
                        </a>
                    </td>
                @endif
            </tr>
            <tr>
                @if($smallBottom)
                    <td style="vertical-align: top">
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
                    loop: true,
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 3000
                });
            });
        </script>
    @endpush
@endif
