<div>

    <div class="bg-white shadow rounded-lg p-6 mb-8">

        <form wire:submit="save">

            

            <div class="flex justify-end">
                <x-button>
                    Crear
                </x-button>
            </div>
        </form>

    </div>

 
    </form>

    @push('js')   
        <script>
            
            Livewire.on('post-created', function(comment) {
                console.log(comment[0]);
            });
            
        </script>
    @endpush


</div>
