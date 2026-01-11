<x-mail::message>
# Introduction

<p>新しいファームが作成されましたのでお知らせいたします。</p>
<p>{{$farm->name}}</p>
<div class="flex">
    <p>{{$farm->street_address}}</p>
    <p>{{$farm->suburb}}</p>
    <p>{{$farm->state_id}}</p>
    <p>{{$farm->postcode}}</p>
</div>

<x-mail::button :url="route('farm.detail', ['id' => $farm->id])">
ファームを見る
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
