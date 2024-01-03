<x-table>
    <x-slot name="thead">
        <x-cell type="td">Name</x-cell>
        <x-cell type="td">Username</x-cell>
        <x-cell type="td">Email</x-cell>
        <x-cell type="td">Phone</x-cell>
        <x-cell type="td">Action</x-cell>
    </x-slot>

    <x-slot name="tbody">
        @forelse($users as $user)
        <tr>
            <x-cell>{{"{$user->lname}, {$user->fname} {$user->mname}"}}</x-cell>
            <x-cell>{{$user->username}}</x-cell>
            <x-cell>{{$user->email}}</x-cell>
            <x-cell>{{$user->phone}}</x-cell>
            <x-cell>
                <div class="flex gap-x-2">
                    <form action="{{route('admin.residents.destroy', $user)}}" method="post" class="delete-resident-form">
                        @method('delete')
                        @csrf

                        <x-danger-button type="submit" :hasLoader="false">Delete</x-danger-button>
                    </form>
                    <a href="{{route('admin.residents.edit', $user)}}" class="edit-resident-link" x-data x-on:click.prevent="$dispatch('open-modal', 'show-edit-resident-form')">
                        <x-primary-button type="button">Edit</x-primary-button>
                    </a>
                    
                </div>
            </x-cell>
        </tr>
        @empty
        <tr>
            <x-cell colspan="5" class="text-center">No residents found.</x-cell>
        </tr>
        @endforelse
    </x-slot>
</x-table>

<script type="module">
    $(".edit-resident-link").click(function(e) {
        e.preventDefault();

        Method.load({
            link: $(this).attr('href'),
            loader: $("#edit-resident-loader"),
            container: $("#edit-resident-container"),
        });
    });

    $('.delete-resident-form').submit(function(e) {
        e.preventDefault()
        Alert.fire({
            icon: 'warning',
            title: 'Delete Resident',
            text: 'This action is irreversible. Are you sure you want to delete this resident from the record?',
        }).then((action) => {
            if(action.isConfirmed) {
                Method.submit({
                    form: $(this),
                    edit: false,
                    container: $("#resident-container"),
                    selected: $(this).find('button[type=submit]'),
                    button: $(this).find('button'),
                    text: ['Delete', 'Delete'],
                });
            }
        });
    });
</script>