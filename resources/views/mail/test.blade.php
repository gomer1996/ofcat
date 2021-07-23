@component('mail::message')
    # {{ 'Пример' }}
    {{ 'что то еще какой то текст' }}
    @component('mail::button', ['url' => 'www.googl.com'])
        {{ 'перейти' }}
    @endcomponent
    {{ 'футтееееееееееерр' }}
@endcomponent
