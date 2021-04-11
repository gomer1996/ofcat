@if($benefits->count())
    <div id="benefit">
        <div class="field">
            <table>
                <tr>
                    <td class="benefit_left">
                        <p>Выгодные предложения</p>
                    </td>
                    @foreach($benefits as $benefit)
                        <td class="benefit_first">
                            <a href="{{ route('selections.index', $benefit) }}">
                                <span>{{ $benefit->name }}</span>
                            </a>
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>
    </div>
@endif

@if($profits->count())
<div id="profit" class="field">
    <table class="profit_menu">
        <tr>
            @foreach($profits as $profit)
                <td>
                    <table>
                        <tr>
                            <td class="profit_left">
                                <img src="/images/week.png" alt="Акционное предложение" />
                            </td>
                            <td>
                                <p>
                                    <a href="{{ route('selections.index', $profit) }}">
                                        <span>{{ $profit->name }}</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            @endforeach
        </tr>
    </table>
</div>
@endif
