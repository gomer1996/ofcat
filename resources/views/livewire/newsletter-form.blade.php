<td  class="news_right subscr">
    <p>ХОТИТЕ ПЛАТИТЬ<br />МЕНЬШЕ?</P>
    <form name="subscription" wire:submit.prevent="subscribe" action="#" method="post">
        <p><input type="text" wire:model="name" name="Name" placeholder="Ваше имя" /></p>
        <p><input type="email" wire:model="email" name="email" required="required" placeholder="Ваш e-mail" /></p>
        <p><input type="submit" name="subscription" value="ПОДПИШУСЬ Я НА РАССЫЛКУ КОТА" /></p>
    </form>
</td>
