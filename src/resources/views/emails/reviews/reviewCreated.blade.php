<x-mail::message>
    # Introduction

    <p>あなたの{{ $review->farm->name }}にしたレビューに対してコメントが届きましたのでお知らせいたします。</p>

    <x-mail::button :url="route('farm.detail', ['id' => $review->farm->id])">
        レビューコメントを見る
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
