<div class="max-w-7xl mx-auto py-2 sm:px-4 lg:px-4 space-y-2">
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/dashboard">Dashboard</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active>{{ __('Comentarios') }}</x-ui.breadcrumbs.link>
        </x-ui.breadcrumbs>
    </x-slot>

    <div class="flex justify-between align-top py-4">
        <x-ui.input wire:model.live="search" type="text" placeholder="{{ __('Buscar comentario') }}..." />

        @can('create', App\Models\Comment::class)
            <a wire:navigate href="{{ route('comments.create') }}">
                <x-ui.button>New</x-ui.button>
            </a>
        @endcan
    </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('¿Estas seguro?') }}
            
        </x-slot>

        <x-slot name="footer">
            <x-ui.button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger class="ml-3" wire:click="delete({{ $deletingComment }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>

    <x-ui.modal.confirm wire:model="confirmingDenuncia">
        <x-slot name="title"> {{ __('Denunciar comentario') }} </x-slot>

        <x-slot name="content"> {{ __('¿Estas seguro?') }}
            <hr/>
            <p>{{$contenidoComentario}}</p>
         </x-slot>

        <x-slot name="footer">
            <x-ui.button wire:click="$toggle('confirmingDenuncia')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger class="ml-3" wire:click="denuncia({{ $denunciaComment }})" wire:loading.attr="disabled">
                {{ __('Confirmar') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>



    {{-- Index Table --}}
    <x-ui.container.table>
        <x-ui.table>
            <x-slot name="head">
                <x-ui.table.header for-crud wire:click="sortBy('comment')">{{ __('Comentario') }}</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('users.name')">{{ __('Usuario') }}</x-ui.table.header>
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($comments as $comment)
                    <x-ui.table.row wire:loading.class.delay="opacity-75" class="{{ $comment->eliminado ? 'bg-red-100' : 'bg-green-100' }}">
                        <x-ui.table.column width="40%" for-crud>
                            {{ Str::limit($comment->comment, 15, '...') }}
                        </x-ui.table.column>
                        <x-ui.table.column width="40%" for-crud>
                            {{ Str::limit($comment->user->name, 8, '...') }}
                        </x-ui.table.column>                                                
                        <x-ui.table.action-column>
                            <div class="flex justify-center items-center space-x-2">
                                <x-ui.action wire:navigate href="{{ route('comments.edit', $comment) }}"><x-editar
                                        w="18" h="18" /></x-ui.action>
                                <x-ui.action.danger wire:click="confirmDenuncia({{ $comment->id }}, '{{ $comment->comment }}')">
                                    <x-deletecomment w="16" h="16" fcolor="{{ $comment->inadecuado == 1 ? '#cc6666' : '#77cc66' }}" /></x-ui.action.danger>

                                <x-ui.action.danger wire:click="confirmDeletion({{ $comment->id }})"><x-delete w="18"
                                        h="18" /></x-ui.action.danger>
                            </div>

                        </x-ui.table.action-column>
                    </x-ui.table.row>
                @empty
                    <x-ui.table.row>
                        <x-ui.table.column
                            colspan="4">{{ __('No se han encontrado comentarios') }}</x-ui.table.column>
                    </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $comments->links() }}</div>
    </x-ui.container.table>
    <div class="flex justify-center">
        <a href="{{ url('/run-job') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300">
            🚀 Ejecutar Job Manualmente
        </a>
    </div>
</div>
