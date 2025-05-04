<form wire:submit="logout">
    @csrf
    <flux:menu.item icon="arrow-right-start-on-rectangle" wire:loading.class="opacity-50">
        <button type="submit" class="w-full text-left" wire:loading.attr="disabled">
            <span wire:loading.remove>Logout</span>
            <span wire:loading>Logging out...</span>
        </button>
    </flux:menu.item>
</form> 