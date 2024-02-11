<div>
    <div class="main-chat-list" id="ChatList">

        @foreach($conversations as $conversation)

            <div class="media new"
                 wire:click="chatUserSelected({{ $conversation }},'{{ $this->getUsers($conversation,$name='id')}}')">
                <div class="main-img-user online">
                    <img alt="" src="{{URL::asset('dashboard/img/faces/5.jpg')}}"> <span>2</span>
                </div>
                <div class="media-body">
                    <div class="media-contact-name">
                        <span>{{ $this->getUsers($conversation,$name='name')}}</span> {{--get name of receiver--}}
                        <span>{{$conversation->messages->last()->created_at->shortAbsoluteDiffForHumans()}}</span>

                    </div>
                    <p>{{$conversation->messages->last()->body}}</p>
                </div>
            </div>

        @endforeach
    </div>
</div>


