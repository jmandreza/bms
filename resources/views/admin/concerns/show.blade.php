<x-app-layout>
    <x-slot name="header">
        <x-header title="Concern Details" />
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <x-container bg="bg-transparent" padding="sm:px-6 lg:px-8 pt-6">
            <a href="{{url()->previous()}}">
                <x-primary-button>Go Back</x-primary-button>
            </a>
        </x-container>
    </div>

    <x-section class="py-6">
        <x-container id="show-request-container" class="space-y-6">
            <div class="max-w-xl">
                <table>
                    <tr>
                        <td class="font-semibold">Email</td>
                        <td class="py-1 pl-4">{{$concern->email}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Subject</td>
                        <td class="py-1 pl-4">{{$concern->subject}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Message</td>
                        <td class="py-1 pl-4">{{$concern->message}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Date Sent</td>
                        <td class="py-1 pl-4">{{Carbon\Carbon::parse($concern->created_at)->format('F d, Y \a\\t h:i A')}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Date Replied</td>
                        <td class="py-1 pl-4">{{Carbon\Carbon::parse($concern->replied_at)->format('F d, Y \a\\t h:i A')}}</td>
                    </tr>
                </table>
            </div>
        </x-container>
    </x-section>
</x-app-layout>