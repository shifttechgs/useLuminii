<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use App\Models\QuoteComment;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class QuoteCommentsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quote-comments';

    protected int | string | array $columnSpan = 'full';
    protected static bool $isDiscovered = false;

    public string $quoteId = '';
    public string $reply   = '';

    public function mount(string $quoteId = ''): void
    {
        $this->quoteId = $quoteId;
    }

    public function getComments()
    {
        return QuoteComment::where('quote_id', $this->quoteId)
            ->orderBy('created_at')
            ->get();
    }

    public function postReply(): void
    {
        $this->validate(['reply' => 'required|string|max:2000']);

        QuoteComment::create([
            'quote_id'    => $this->quoteId,
            'author_type' => 'team',
            'author_name' => auth()->user()->name ?? 'ShiftTech Team',
            'message'     => $this->reply,
        ]);

        $this->reply = '';
        $this->dispatch('comment-posted');
    }
}
