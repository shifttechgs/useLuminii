<x-filament-widgets::widget class="fi-wi-quote-comments">
<x-filament::section>

    <x-slot name="heading">
        <div class="flex items-center gap-2">
            <span>Client Messages</span>
            @php $count = $this->getComments()->count(); @endphp
            @if($count)
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold text-white" style="background:#1a3a2a;">
                    {{ $count }}
                </span>
            @endif
        </div>
    </x-slot>

    <div class="space-y-4">

        {{-- Thread --}}
        @php $comments = $this->getComments(); @endphp

        @if($comments->isEmpty())
            <p class="text-sm text-gray-400 text-center py-4">No messages yet from the client on this quote.</p>
        @else
        <div class="space-y-3">
            @foreach($comments as $comment)
            <div class="flex gap-3 {{ $comment->isFromClient() ? '' : 'flex-row-reverse' }}">
                {{-- Avatar --}}
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0 mt-0.5"
                     style="background:{{ $comment->isFromClient() ? '#1a3a2a' : '#374151' }};">
                    {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                </div>
                {{-- Bubble --}}
                <div class="max-w-lg {{ $comment->isFromClient() ? '' : 'items-end' }} flex flex-col">
                    <div class="flex items-baseline gap-2 mb-1 {{ $comment->isFromClient() ? '' : 'flex-row-reverse' }}">
                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $comment->author_name }}</span>
                        @if(!$comment->isFromClient())
                            <span class="text-[9px] font-bold uppercase tracking-widest px-1.5 py-0.5 rounded-full" style="background:#e8f0ec;color:#1a3a2a;">Team</span>
                        @endif
                        <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed whitespace-pre-line
                        {{ $comment->isFromClient()
                            ? 'rounded-tl-sm bg-gray-100 dark:bg-white/5 text-gray-800 dark:text-gray-200'
                            : 'rounded-tr-sm text-white' }}"
                         style="{{ !$comment->isFromClient() ? 'background:#1a3a2a;' : '' }}">
                        {{ $comment->message }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Reply form --}}
        <div class="pt-4 border-t border-gray-100 dark:border-white/10">
            <form wire:submit="postReply" class="flex gap-3 items-end">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Reply to client</label>
                    <textarea
                        wire:model="reply"
                        rows="2"
                        placeholder="Type your reply…"
                        class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-sm text-gray-900 dark:text-white px-3 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-green-800"
                    ></textarea>
                    @error('reply') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:opacity-90 transition-opacity shrink-0 mb-px"
                    style="background:#1a3a2a;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Send
                </button>
            </form>
        </div>

    </div>

</x-filament::section>
</x-filament-widgets::widget>
