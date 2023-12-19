<x-table>
    <x-slot name="thead">
        <x-cell type="tr">Name</x-cell>
        <x-cell type="tr">Username</x-cell>
        <x-cell type="tr">Email</x-cell>
        <x-cell type="tr">Phone</x-cell>
        <x-cell type="tr">Action</x-cell>
    </x-slot>

    <x-slot name="tbody">
        @forelse($users as $user)
        <tr>
            <x-cell>{{"{$user->resident->lname}, {$user->resident->fname} {$user->resident->mname}"}}</x-cell>
            <x-cell>{{$user->username}}</x-cell>
            <x-cell>{{$user->email}}</x-cell>
            <x-cell>{{$user->resident->phone}}</x-cell>
            <x-cell>
                <div class="flex gap-x-2">
                    <form action="{{route('admin.users.destroy', $user)}}" method="post" class="delete-user-form">
                        @method('delete')
                        @csrf

                        <x-danger-button type="submit">Delete</x-danger-button>
                    </form>
                    <x-primary-button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'show-edit-user-form')">Edit</x-primary-button>
                </div>
            </x-cell>
        </tr>
        @empty
        <tr>
            <x-cell colspan="5" class="text-center">No registered users found.</x-cell>
        </tr>
        @endforelse
    </x-slot>
</x-table>

<script type="module">
    $('.delete-user-form').submit(function(e) {
        e.preventDefault()
        Alert.fire({
            icon: 'info',
            title: 'Edit User',
            text: 'Are you sure?',
        });
    });
</script>