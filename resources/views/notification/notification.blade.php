@forelse($notifications as $notification)
    @php
        if($notification->data['id'] !== 0) {
            $user = $users[$notification->data['id']];
        }
        
    @endphp
    <a href="{{ route('mark-as-read', $notification) }}" class="flex items-center px-4 py-2 gap-3 hover:bg-gray-300 transition-colors duration-200">
        <img class="w-12 aspect-square self-start object-cover object-center rounded-full" src="{{ asset('images/notification.png') }}" alt="">
        <div class="flex flex-col gap-1">
            <p class="text-md leading-none">
                @if(isset($user->resident))
                <span class="font-semibold">{{"{$user->resident->lname}, {$user->resident->fname}"}}</span> {{$notification->data['message']}}
                @elseif(isset($user->username))
                <span class="font-semibold">{{"{$user->username}"}}</span> {{$notification->data['message']}}
                @else
                <span class="font-semibold">Guest User</span> {{$notification->data['message']}}
                @endif
            </p>

            <p class="text-xs">{{Carbon\Carbon::parse($notification->updated_at)->diffForHumans()}}</p>
        </div>
    </a>
@empty
<p class="text-center">No notifications</p>
@endforelse