<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 space-y-4">

    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link href="{{ route('payments.index') }}">{{ __('Payments') }}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active>{{ __('Crear pago') }}</x-ui.breadcrumbs.link>
        </x-ui.breadcrumbs>
    </x-slot>
    
    <x-ui.toast timeout=5000 on="saved">{{__('Se ha generado el pago')}}</x-ui.toast>
    <x-ui.toast timeout=5000 on="errorpayment" color="red">{{__('Se ha prodcido un error generando el pago')}}</x-ui.toast>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-4 space-y-3">
                <div class="w-full">
                    <x-ui.label for="users_id">{{ __('Nom') }}</x-ui.label>
                    <x-ui.input.select wire:model="form.users_id" name="users_id" id="users_id" class="w-full" wire:change="consultarActuaciones(this.value)">
                        <option value="0" selected>Todos los usuarios</option>
                        @foreach ($users as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.input.select>
                    <x-ui.input.error for="form.users_id" />
                </div>

                <div class="w-full">
                    <x-ui.label for="fechaPago">{{ __('Fecha pago') }}</x-ui.label>
                    <x-ui.input type="date" class="w-full" wire:model="form.fechaPago" name="fechaPago" id="fechaPago" />
                    <x-ui.input.error for="form.fechaPago" />
                </div>

                <div class="w-full">
                    <x-ui.label for="descripcion">{{ __('Descripció') }}</x-ui.label>
                    <x-ui.input.text class="w-full" wire:model="form.descripcion" name="descripcion" id="descripcion"
                        placeholder="{{ __('Introduce una descripción orientativa de lo que se va a pagar') }}" />
                    <x-ui.input.error for="form.descripcion" />
                </div>

                <div class="w-full">
                    <x-ui.label for="fechaInicio">{{ __('Data Inici') }}</x-ui.label>
                    <x-ui.input type="date" class="w-full" wire:model="form.fechaInicio" name="fechaInicio" id="fechaInicio"
                    wire:change="consultarActuaciones(this.value)" />
                    <x-ui.input.error for="form.fechaInicio" />
                </div>

                <div class="w-full">
                    <x-ui.label for="fechaFin">{{ __('Data de Fi') }}</x-ui.label>
                    <x-ui.input type="date" class="w-full" wire:model="form.fechaFin" name="fechaFin" id="fechaFin"
                        wire:change="consultarActuaciones(this.value)"/>
                    <x-ui.input.error for="form.fechaFin" />
                </div>
            </div>
            <div class="flex justify-between mt-4 border-t border-gray-50 p-4">
                <div>
                    <!-- Other buttons here -->
                </div>
                <div>
                    <x-ui.button class="bg-lime-700 hover:bg-lime-800" type="submit">{{ __('Generar pago') }}</x-ui.button>
                </div>
            </div>                     
        </form>
        <div wire:loading> 
            <li class="flex items-center ml-4">
                <div role="status">
                    <svg aria-hidden="true" class="w-4 h-4 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="p-2 text-xs text-center">{{__('Cargando actuaciones')}}</div>
            </li>
        </div>
        
            @if($actuaciones) 
            <x-ui.container.table>
                <x-ui.table>
                    <x-slot name="head">
                        
                        <x-ui.table.header for-crud 
                            > {{ __('Fecha Actuacion') }}</x-ui.table.header>
                        <x-ui.table.header for-crud wire:click="sortBy('fechaPago')"
                            > {{ __('Descripcion') }}</x-ui.table.header>
                        <x-ui.table.header 
                            > {{ __('Obs.') }}</x-ui.table.header>          
                    </x-slot>
        
                    <x-slot name="body">
                        @forelse ($actuaciones as $actuacion)
                        <x-ui.table.row wire:loading.class.delay="opacity-75">
                            
                            <x-ui.table.column for-crud
                                >{{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</x-ui.table.column
                            >
                            <x-ui.table.column for-crud
                                >{{ $actuacion->descripcion }}</x-ui.table.column
                            >                              
                            <x-ui.table.column>
                                @if ($actuacion->pagado)
                                    <x-euro w="24" h="24" />
                                @endif
                                @if ($actuacion->noaplicapago)
                                    <x-noeuro w="24" h="24" />
                                @endif

                            </x-ui.table.column>
                        </x-ui.table.row>
                        @empty
                        <x-ui.table.row>
                            <x-ui.table.column colspan="4">                                    
                                    {{ __('No Results Found.') }}                                    
                            </x-ui.table.column>
                        </x-ui.table.row>
                        @endforelse
                    </x-slot>
                </x-ui.table>
            </x-ui.container.table>
            @else
            <div class="p-2 text-xs text-center">{{ __('No hay actuaciones en el rango de fechas seleccionadas.') }}<div>
            @endif           
    </div>
</div>
